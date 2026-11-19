<?php

namespace Webkul\Admin\Http\Controllers\Settings;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Webkul\Admin\DataGrids\Settings\ShippingZoneDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Shipping\Repositories\ShippingZoneLocationRepository;
use Webkul\Shipping\Repositories\ShippingZoneMethodRepository;
use Webkul\Shipping\Repositories\ShippingZoneRepository;

class ShippingZoneController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ShippingZoneRepository $shippingZoneRepository,
        protected ShippingZoneLocationRepository $shippingZoneLocationRepository,
        protected ShippingZoneMethodRepository $shippingZoneMethodRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(ShippingZoneDataGrid::class)->toJson();
        }

        return view('admin::settings.shipping.zones.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin::settings.shipping.zones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $validated = $this->validateZoneRequest();

        DB::transaction(function () use ($validated) {
            $zone = $this->shippingZoneRepository->create([
                'name' => $validated['name'],
                'is_active' => $validated['is_active'],
            ]);

            $this->syncZoneRelations(
                $zone->id,
                $validated['locations'] ?? [],
                $validated['methods'] ?? []
            );
        });

        session()->flash('success', 'Shipping Zone created successfully.');

        return redirect()->route('admin.settings.shipping.zones.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id)
    {
        $zone = $this->shippingZoneRepository->with(['locations', 'methods'])->findOrFail($id);

        return view('admin::settings.shipping.zones.edit', compact('zone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update($id)
    {
        $validated = $this->validateZoneRequest();

        DB::transaction(function () use ($validated, $id) {
            $this->shippingZoneRepository->update([
                'name' => $validated['name'],
                'is_active' => $validated['is_active'],
            ], $id);

            $this->syncZoneRelations(
                (int) $id,
                $validated['locations'] ?? [],
                $validated['methods'] ?? [],
                true
            );
        });

        session()->flash('success', 'Shipping Zone updated successfully.');

        return redirect()->route('admin.settings.shipping.zones.index');
    }

    /**
     * Validate shipping zone payload including regions and methods.
     */
    protected function validateZoneRequest(): array
    {
        return $this->validate(request(), [
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['required', 'boolean'],
            'locations' => ['nullable', 'array'],
            'locations.*.type' => ['required', 'in:country,state,postcode'],
            'locations.*.code' => ['required', 'string', 'max:255'],
            'methods' => ['nullable', 'array'],
            'methods.*.title' => ['required', 'string', 'max:255'],
            'methods.*.type' => ['required', 'in:flat_rate,free_shipping'],
            'methods.*.price' => ['nullable', 'numeric', 'min:0'],
            'methods.*.is_active' => ['nullable', 'boolean'],
            'methods.*.priority' => ['nullable', 'integer', 'min:0'],
            'methods.*.min_subtotal' => ['nullable', 'numeric', 'min:0'],
            'methods.*.max_subtotal' => ['nullable', 'numeric', 'min:0'],
            'methods.*.min_weight' => ['nullable', 'numeric', 'min:0'],
            'methods.*.max_weight' => ['nullable', 'numeric', 'min:0'],
        ]);
    }

    /**
     * Persist shipping zone locations and methods, replacing existing rows on update.
     */
    protected function syncZoneRelations(int $zoneId, array $locations, array $methods, bool $replaceExisting = false): void
    {
        if ($replaceExisting) {
            $this->shippingZoneLocationRepository->deleteWhere(['shipping_zone_id' => $zoneId]);
            $this->shippingZoneMethodRepository->deleteWhere(['shipping_zone_id' => $zoneId]);
        }

        foreach ($locations as $location) {
            $this->shippingZoneLocationRepository->create([
                'shipping_zone_id' => $zoneId,
                'location_type' => $location['type'],
                'location_code' => $location['code'],
            ]);
        }

        foreach ($methods as $method) {
            $type = $method['type'];

            $this->shippingZoneMethodRepository->create([
                'shipping_zone_id' => $zoneId,
                'type' => $type,
                'title' => $method['title'],
                'is_active' => $method['is_active'] ?? 1,
                'price' => $type === 'free_shipping' ? 0 : ($method['price'] ?? 0),
                'priority' => $method['priority'] ?? 0,
                'min_subtotal' => ($method['min_subtotal'] ?? '') !== '' ? $method['min_subtotal'] : null,
                'max_subtotal' => ($method['max_subtotal'] ?? '') !== '' ? $method['max_subtotal'] : null,
                'min_weight' => ($method['min_weight'] ?? '') !== '' ? $method['min_weight'] : null,
                'max_weight' => ($method['max_weight'] ?? '') !== '' ? $method['max_weight'] : null,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->shippingZoneRepository->delete($id);

            return response()->json(['message' => 'Shipping Zone deleted successfully.']);
        } catch (\Exception $e) {
        }

        return response()->json(['message' => 'Shipping Zone could not be deleted.'], 400);
    }
}
