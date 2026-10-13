<?php

namespace Webkul\Admin\Http\Controllers\Theme;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\DataGrids\Theme\HeroSliderDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\FPC\Facades\PageCache;
use Webkul\Theme\Repositories\HeroLayerRepository;
use Webkul\Theme\Repositories\HeroSlideRepository;
use Webkul\Theme\Repositories\HeroSliderRepository;

class HeroSliderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected HeroSliderRepository $heroSliderRepository,
        protected HeroSlideRepository $heroSlideRepository,
        protected HeroLayerRepository $heroLayerRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return View|JsonResponse
     */
    public function index()
    {
        if (request()->ajax()) {
            return datagrid(HeroSliderDataGrid::class)->process();
        }

        return view('admin::theme.hero-sliders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin::theme.hero-sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required',
            'code' => 'required|unique:theme_hero_sliders,code',
            'placement' => 'required',
        ]);

        $data = request()->all();
        $data['status'] = isset($data['status']);

        if (isset($data['settings'])) {
            $data['settings'] = [
                'autoplay' => isset($data['settings']['autoplay']),
                'duration' => (int) ($data['settings']['duration'] ?? 6000),
                'loop' => isset($data['settings']['loop']),
            ];
        }

        Event::dispatch('theme.hero_sliders.create.before');

        $heroSlider = $this->heroSliderRepository->create($data);

        Event::dispatch('theme.hero_sliders.create.after', $heroSlider);

        try {
            Artisan::call('cache:clear');
            try {
                Artisan::call('responsecache:clear');
            } catch (\Exception $e) {
            }
            if (class_exists(PageCache::class)) {
                PageCache::flush();
            }
        } catch (\Exception $e) {
        }

        session()->flash('success', trans('admin::app.theme.hero-sliders.create-success'));

        return redirect()->route('admin.cms.hero_sliders.edit', $heroSlider->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id)
    {
        $heroSlider = $this->heroSliderRepository->with(['slides.layers'])->findOrFail($id);

        return view('admin::theme.hero-sliders.edit', compact('heroSlider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update($id)
    {
        $this->validate(request(), [
            'name' => 'required',
            'code' => 'required|unique:theme_hero_sliders,code,'.$id,
        ]);

        $data = request()->all();
        $data['status'] = isset($data['status']);

        if (isset($data['settings'])) {
            $data['settings'] = [
                'autoplay' => isset($data['settings']['autoplay']),
                'duration' => (int) ($data['settings']['duration'] ?? 6000),
                'loop' => isset($data['settings']['loop']),
            ];
        }

        Event::dispatch('theme.hero_sliders.update.before', $id);

        $heroSlider = $this->heroSliderRepository->update($data, $id);

        // Handle slides JSON payload from Vue/Alpine component
        if (isset($data['slides_data'])) {
            $slidesData = json_decode($data['slides_data'], true);
            $this->processSlides($heroSlider, $slidesData);
        }

        Event::dispatch('theme.hero_sliders.update.after', $heroSlider);

        try {
            Artisan::call('cache:clear');
            try {
                Artisan::call('responsecache:clear');
            } catch (\Exception $e) {
            }
            if (class_exists(PageCache::class)) {
                PageCache::flush();
            }
        } catch (\Exception $e) {
        }

        session()->flash('success', trans('admin::app.theme.hero-sliders.update-success'));

        return redirect()->route('admin.cms.hero_sliders.index');
    }

    /**
     * Process slides and layers
     */
    protected function processSlides($heroSlider, $slidesData)
    {
        // Sync slides: simple implementation for now, deleting all and recreating
        // In a production scenario, we'd sync properly by ID to preserve media

        $existingSlideIds = [];

        foreach ($slidesData as $index => $slideData) {
            $slidePayload = [
                'hero_slider_id' => $heroSlider->id,
                'name' => $slideData['name'] ?? 'Slide '.($index + 1),
                'status' => $slideData['status'] ?? 1,
                'sort_order' => $index,
                'media_type' => $slideData['media_type'] ?? 'image',
                'desktop_media' => $slideData['desktop_media'] ?? null,
                'mobile_media' => $slideData['mobile_media'] ?? null,
                'video_url' => $slideData['video_url'] ?? null,
                'duration' => $slideData['duration'] ?? 5000,
                'settings' => $slideData['settings'] ?? null,
            ];

            if (isset($slideData['id']) && $slideData['id']) {
                $slide = $this->heroSlideRepository->update($slidePayload, $slideData['id']);
                $existingSlideIds[] = $slide->id;
            } else {
                $slide = $this->heroSlideRepository->create($slidePayload);
                $existingSlideIds[] = $slide->id;
            }

            // Handle layers
            if (isset($slideData['layers'])) {
                $existingLayerIds = [];
                foreach ($slideData['layers'] as $layerIndex => $layerData) {
                    $layerPayload = [
                        'hero_slide_id' => $slide->id,
                        'type' => $layerData['type'] ?? 'text',
                        'content' => $layerData['content'] ?? '',
                        'sort_order' => $layerIndex,
                        'desktop_settings' => $layerData['desktop_settings'] ?? [],
                        'tablet_settings' => $layerData['tablet_settings'] ?? [],
                        'mobile_settings' => $layerData['mobile_settings'] ?? [],
                        'settings' => $layerData['settings'] ?? [],
                    ];

                    if (isset($layerData['id']) && $layerData['id']) {
                        $layer = $this->heroLayerRepository->update($layerPayload, $layerData['id']);
                        $existingLayerIds[] = $layer->id;
                    } else {
                        $layer = $this->heroLayerRepository->create($layerPayload);
                        $existingLayerIds[] = $layer->id;
                    }
                }

                // Delete removed layers
                $this->heroLayerRepository->getModel()->where('hero_slide_id', $slide->id)->whereNotIn('id', $existingLayerIds)->delete();
            }
        }

        // Delete removed slides
        $this->heroSlideRepository->getModel()->where('hero_slider_id', $heroSlider->id)->whereNotIn('id', $existingSlideIds)->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $heroSlider = $this->heroSliderRepository->findOrFail($id);

        try {
            Event::dispatch('theme.hero_sliders.delete.before', $id);

            $this->heroSliderRepository->delete($id);

            Event::dispatch('theme.hero_sliders.delete.after', $id);

            return response()->json(['message' => trans('admin::app.theme.hero-sliders.delete-success')]);
        } catch (\Exception $e) {
            return response()->json(['message' => trans('admin::app.theme.hero-sliders.delete-failed')], 500);
        }
    }
}
