<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\InvReturnItemInfo;
use App\Models\Inventory\InvItemOnSupportReturnToSupplierVendorInformation;
use Auth;
use Session;
use DB;

class ItemOnSupportReturnToSupplierVendorInformationController extends Controller
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

        $data = InvItemOnSupportReturnToSupplierVendorInformation::getMasterData();
        $data['item_on_support_return_to_supplier_vendor_information'] = InvItemOnSupportReturnToSupplierVendorInformation::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;

        return view('inventory.item-on-support-return-to-supplier-vendor-information.index', $data);
    }

    public function create()
    {
        $data = InvItemOnSupportReturnToSupplierVendorInformation::getMasterData();
        
        return view('inventory.item-on-support-return-to-supplier-vendor-information.create', $data);
    }

    public function store(Request $request)
    {
        // return $request->all();
         try { 
             $this->validate($request, [
                'supplier_vendor' => 'required',
                'date' => 'required'
			
		]);
            
            $requestData['created_by'] = Auth::id();
            InvItemOnSupportReturnToSupplierVendorInformation::saveOrUpdate($request);

            Session::flash('success', __('Saved Successfully!'));

            // Redirect to edit mode.
            return redirect(action('Inventory\ItemOnSupportReturnToSupplierVendorInformationController@create'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
        
    }

    public function edit($id)
    {
        $item_on_support_return_to_supplier_vendor_information = InvItemOnSupportReturnToSupplierVendorInformation::findOrFail($id);
        $data = InvItemOnSupportReturnToSupplierVendorInformation::getMasterData($item_on_support_return_to_supplier_vendor_information);
        $data['item_on_support_return_to_supplier_vendor_information'] = $item_on_support_return_to_supplier_vendor_information;
        $data['ivn_return_item_info'] = $item_on_support_return_to_supplier_vendor_information->ivnReturnItemInfo()->get();

        return view('inventory.item-on-support-return-to-supplier-vendor-information.edit', $data);
    }

    public function show($id)
    {
        $item_on_support_return_to_supplier_vendor_information = InvItemOnSupportReturnToSupplierVendorInformation::findOrFail($id);
        $data = InvItemOnSupportReturnToSupplierVendorInformation::getMasterData($item_on_support_return_to_supplier_vendor_information);
        $data['item_on_support_return_to_supplier_vendor_information'] = InvItemOnSupportReturnToSupplierVendorInformation::getAll([], $id)[0];
        $data['ivn_return_item_info'] = $item_on_support_return_to_supplier_vendor_information->ivnReturnItemInfo()->get();
        return view('inventory.item-on-support-return-to-supplier-vendor-information.show', $data);
    }

    public function update(Request $request, $id)
    {

        try {
            $this->validate($request, [
                'supplier_vendor' => 'required',
                'date' => 'required'
                
            ]);
            InvItemOnSupportReturnToSupplierVendorInformation::saveOrUpdate($request, $id);
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
            InvItemOnSupportReturnToSupplierVendorInformation::destroy($id);
            
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
