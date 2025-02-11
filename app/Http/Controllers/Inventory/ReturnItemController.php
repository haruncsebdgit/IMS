<?php

namespace App\Http\Controllers\Inventory;

use DB;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\ReturnItem;
use App\Models\Inventory\RequestItem;
use App\Models\Inventory\ReturnItemDetails;
use App\Models\Inventory\InvItemInformation;
use App\Models\Inventory\RequestItemDetails;

class ReturnItemController extends Controller
{
    public function index(Request $request)
    {
        $itemsPerPage = itemsPerPage();
        $_args = array(
            'items_per_page' => $itemsPerPage,
            'paginate'       => true
        );

        $_args = filterParams(
            $_args,
            array(
                'request_from',
                'request_to',
            )
        );

        $data = ReturnItem::getMasterData();
        $data['returnItems'] = ReturnItem::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;

        return view('inventory.item-return.index', $data);
    }

    public function create()
    {
        $data = ReturnItem::getMasterData();

        return view('inventory.item-return.create', $data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            ReturnItem::saveOrUpdate($request);
            DB::commit();
            Session::flash('success', __('Saved Successfully!'));

            // Redirect to edit mode.
            return redirect(action('Inventory\ReturnItemController@create'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

    public function edit($id)
    {
        $requestedItem = ReturnItem::findOrFail($id);
        $data = ReturnItem::getMasterData($requestedItem);
        $data['requestedItem'] = $requestedItem;
        $data['itemDetails'] = $requestedItem->itemDetails()->get();

        return view('inventory.item-return.edit', $data);
    }

    public function show($id)
    {
        $requestedItem = ReturnItem::findOrFail($id);
        $data = ReturnItem::getMasterData($requestedItem);
        $data['requestedItem'] = $requestedItem;
        $data['itemDetails'] = $requestedItem->itemDetails()->get();
        return view('inventory.item-return.show', $data);
    }

    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            ReturnItem::saveOrUpdate($request, $id);
            DB::commit();
            Session::flash('success', __('Updated Successfully!'));
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            ReturnItemDetails::where('return_item_master_id', $id)->delete();
            ReturnItem::destroy($id);

            DB::commit();

            return redirect()->back()->with('success', __('Deleted Successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }
}
