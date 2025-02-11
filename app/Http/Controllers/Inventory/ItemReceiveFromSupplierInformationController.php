<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\InvItemReceiveFromSupplierInformation;
use App\Models\Inventory\InvSupplierItemInfo;
use Auth;
use Session;
use DB;

class ItemReceiveFromSupplierInformationController extends Controller
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
                'receive_id',
                'inventory_center',
                'supplier',
                'package',
                'item',
                'po_number',
                'date_from',
                'date_to',
            )
            );

        $data = InvItemReceiveFromSupplierInformation::getMasterData();
        $data['item_receive_from_supplier_information'] = InvItemReceiveFromSupplierInformation::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;

        return view('inventory.item-receive-from-supplier-information.index', $data);
    }

    public function create()
    {
        $data = InvItemReceiveFromSupplierInformation::getMasterData();

        return view('inventory.item-receive-from-supplier-information.create', $data);
    }

    public function store(Request $request)
    {
        // return $request->all();
         try {
             $this->validate($request, [
			'supplier_id' => 'required',
			'po_number' => 'required',
            'receive_date' => 'required'

		]);

            $requestData['created_by'] = Auth::id();
            DB::beginTransaction();
            InvItemReceiveFromSupplierInformation::saveOrUpdate($request);
            DB::commit();
            Session::flash('success', __('Saved Successfully!'));

            // Redirect to edit mode.
            return redirect(action('Inventory\ItemReceiveFromSupplierInformationController@create'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }

    }

    public function edit($id)
    {
        $item_receive_from_supplier_information = InvItemReceiveFromSupplierInformation::findOrFail($id);
        $data = InvItemReceiveFromSupplierInformation::getMasterData($item_receive_from_supplier_information);
        $data['item_receive_from_supplier_information'] = $item_receive_from_supplier_information;
        $data['ivn_supplier_item_info'] = $item_receive_from_supplier_information->ivnSupplierItemInfo()->get();

        return view('inventory.item-receive-from-supplier-information.edit', $data);
    }

    public function show($id)
    {
        $item_receive_from_supplier_information = InvItemReceiveFromSupplierInformation::findOrFail($id);
        $data = InvItemReceiveFromSupplierInformation::getMasterData($item_receive_from_supplier_information);
        $data['item_receive_from_supplier_information'] = InvItemReceiveFromSupplierInformation::getAll([], $id)[0];
        $data['ivn_supplier_item_info'] = $item_receive_from_supplier_information->ivnSupplierItemInfo()->get();
        return view('inventory.item-receive-from-supplier-information.show', $data);
    }

    public function update(Request $request, $id)
    {

        try {
            $this->validate($request, [
                'supplier_id' => 'required',
                'po_number' => 'required',
                'receive_date' => 'required'

            ]);
            DB::beginTransaction();
            InvItemReceiveFromSupplierInformation::saveOrUpdate($request, $id);
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

            InvSupplierItemInfo::where('supplier_item_id', $id)->delete();
            InvItemReceiveFromSupplierInformation::destroy($id);

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
