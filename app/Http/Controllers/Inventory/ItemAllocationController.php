<?php

namespace App\Http\Controllers\Inventory;

use DB;
use Auth;

use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Inventory\Stock;
use App\Http\Controllers\Controller;
use App\Models\Inventory\ItemAllocation;
use App\Models\Inventory\InvItemInformation;
use App\Models\Inventory\RequestItemDetails;
use App\Models\Inventory\ItemAllocationDetails;
use App\Models\Inventory\RequestItemApprovalHistory;

class ItemAllocationController extends Controller
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

        $data = ItemAllocation::getMasterData();
        $data['item_receive_from_supplier_information'] = ItemAllocation::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;

        return view('inventory.item-allocation.index', $data);
    }

    public function create()
    {
        $data = ItemAllocation::getMasterData();
        $data['locationId'] = !empty(auth()->user()->location_id) ? auth()->user()->location_id : null;
        $data['requestDate'] = date('d-m-Y');
        return view('inventory.item-allocation.create', $data);
    }

    public function store(Request $request)
    {
        // return $request->all();
        try {
            DB::beginTransaction();
            ItemAllocation::saveOrUpdate($request);
            DB::commit();
            Session::flash('success', __('Saved Successfully!'));

            // Redirect to edit mode.
            return redirect(action('Inventory\ItemAllocationController@create'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

    public function edit($id)
    {
        $itemAllocation = ItemAllocation::findOrFail($id);
        $data = ItemAllocation::getMasterData($itemAllocation);
        $data['itemAllocation'] = $itemAllocation;
        $data['itemDetails'] = $itemAllocation->itemDetails()->get();

        return view('inventory.item-allocation.edit', $data);
    }

    public function show($id)
    {
        $itemAllocation = ItemAllocation::findOrFail($id);
        $data = ItemAllocation::getMasterData($itemAllocation);
        $data['itemAllocation'] = $itemAllocation;
        $data['itemDetails'] = $itemAllocation->itemDetails()->get();
        return view('inventory.item-allocation.show', $data);
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            ItemAllocation::saveOrUpdate($request, $id);
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

            ItemAllocationDetails::where('allocation_item_master_id', $id)->delete();
            ItemAllocation::destroy($id);

            DB::commit();

            return redirect()->back()->with('success', __('Deleted Successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function getItemQtyByItemId($itemId)
    {
        $qty =  Stock::where('dept', 'dept_cse')
                ->whereNull('user_id')
                ->where('item_id', $itemId)
                ->sum('stock_quantity');
        return response()->json($qty);
    }
}
