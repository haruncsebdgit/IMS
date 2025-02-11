<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\InvItemTransferInformation;
use App\Models\Inventory\InvItemTransferInformationItemInformation;
use Auth;
use Session;
use DB;

class ItemTransferInformationController extends Controller
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
                'inventory_center_from',
                'date_from',
                'date_to',
                'item'
            )
            );

        $data = InvItemTransferInformation::getMasterData();
        $data['item_transfer_information'] = InvItemTransferInformation::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;

        return view('inventory.item-transfer-information.index', $data);
    }

    public function create()
    {
        $data = InvItemTransferInformation::getMasterData();
        
        return view('inventory.item-transfer-information.create', $data);
    }

    public function store(Request $request)
    {
        // return $request->all();
         try { 
             $this->validate($request, [
                'inventory_cost_center_to' => 'required',
                'transfer_date' => 'required'
			
		]);
            
            $requestData['created_by'] = Auth::id();
            InvItemTransferInformation::saveOrUpdate($request);

            Session::flash('success', __('Saved Successfully!'));

            // Redirect to edit mode.
            return redirect(action('Inventory\ItemTransferInformationController@create'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
        
    }

    public function edit($id)
    {
        $item_transfer_information = InvItemTransferInformation::findOrFail($id);
        $data = InvItemTransferInformation::getMasterData($item_transfer_information);
        $data['item_transfer_information'] = $item_transfer_information;
        $data['ivn_transfer_item_info'] = $item_transfer_information->ivnTransferItemInfo()->get();

        return view('inventory.item-transfer-information.edit', $data);
    }

    public function show($id)
    {
        $item_transfer_information = InvItemTransferInformation::findOrFail($id);
        $data = InvItemTransferInformation::getMasterData($item_transfer_information);
        $data['item_transfer_information'] = InvItemTransferInformation::getAll([], $id)[0];
        $data['ivn_transfer_item_info'] = $item_transfer_information->ivnTransferItemInfo()->get();
        return view('inventory.item-transfer-information.show', $data);
    }

    public function update(Request $request, $id)
    {

        try {
            $this->validate($request, [
                'inventory_cost_center_to' => 'required',
                'transfer_date' => 'required'
                
            ]);
            InvItemTransferInformation::saveOrUpdate($request, $id);
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

            InvItemTransferInformationItemInformation::where('transfer_item_id', $id)->delete();
            InvItemTransferInformation::destroy($id);
            
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
