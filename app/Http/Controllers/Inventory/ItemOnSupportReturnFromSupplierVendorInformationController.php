<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\InvReturnItemInfo;
use App\Models\Inventory\InvItemOnSupportReturnFromSupplierVendorInformation;
use Auth;
use Session;
use DB;

class ItemOnSupportReturnFromSupplierVendorInformationController extends Controller
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
                'transaction_id',
                'inventory_center_from',
                'date_from',
                'date_to',
                'item',
                'supplier'
            )
            );

        $data = InvItemOnSupportReturnFromSupplierVendorInformation::getMasterData();
        $data['item_on_support_return_from_supplier_vendor_information'] = InvItemOnSupportReturnFromSupplierVendorInformation::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;

        return view('inventory.item-on-support-return-from-supplier-vendor-information.index', $data);
    }

    public function create()
    {
        $data = InvItemOnSupportReturnFromSupplierVendorInformation::getMasterData();
        
        return view('inventory.item-on-support-return-from-supplier-vendor-information.create', $data);
    }

    public function store(Request $request)
    {
        // return $request->all();
         try { 
             $this->validate($request, [
                'supplier_vendor' => 'required',
                'receive_date' => 'required'
			
		]);
            
            $requestData['created_by'] = Auth::id();
            InvItemOnSupportReturnFromSupplierVendorInformation::saveOrUpdate($request);

            Session::flash('success', __('Saved Successfully!'));

            // Redirect to edit mode.
            return redirect(action('Inventory\ItemOnSupportReturnFromSupplierVendorInformationController@create'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
        
    }

    public function edit($id)
    {
        $item_on_support_return_from_supplier_vendor_information = InvItemOnSupportReturnFromSupplierVendorInformation::findOrFail($id);
        $data = InvItemOnSupportReturnFromSupplierVendorInformation::getMasterData($item_on_support_return_from_supplier_vendor_information);
        $data['item_on_support_return_from_supplier_vendor_information'] = $item_on_support_return_from_supplier_vendor_information;
        $data['ivn_return_from_item_info'] = $item_on_support_return_from_supplier_vendor_information->ivnReturnFromItemInfo()->get();

        return view('inventory.item-on-support-return-from-supplier-vendor-information.edit', $data);
    }

    public function show($id)
    {
        $item_on_support_return_from_supplier_vendor_information = InvItemOnSupportReturnFromSupplierVendorInformation::findOrFail($id);
        $data = InvItemOnSupportReturnFromSupplierVendorInformation::getMasterData($item_on_support_return_from_supplier_vendor_information);
        $data['item_on_support_return_from_supplier_vendor_information'] = InvItemOnSupportReturnFromSupplierVendorInformation::getAll([], $id)[0];
        $data['ivn_return_item_info'] = $item_on_support_return_from_supplier_vendor_information->ivnReturnItemInfo()->get();
        return view('inventory.item-on-support-return-from-supplier-vendor-information.show', $data);
    }

    public function update(Request $request, $id)
    {

        try {
            $this->validate($request, [
                'supplier_vendor' => 'required',
                'receive_date' => 'required'
                
            ]);
            InvItemOnSupportReturnFromSupplierVendorInformation::saveOrUpdate($request, $id);
            Session::flash('success', __('Updated Successfully!'));
            return back();

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            InvReturnItemInfo::where('return_item_id', $id)->delete();
            InvItemOnSupportReturnFromSupplierVendorInformation::destroy($id);
            
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
