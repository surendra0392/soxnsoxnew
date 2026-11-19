<?php

namespace Webkul\Admin\Http\Controllers\Settings;

use Illuminate\View\View;
use Webkul\Admin\DataGrids\Settings\InventoryLedgerDataGrid;
use Webkul\Admin\Http\Controllers\Controller;

class InventoryLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(InventoryLedgerDataGrid::class)->toJson();
        }

        return view('admin::settings.inventory_ledger.index');
    }
}
