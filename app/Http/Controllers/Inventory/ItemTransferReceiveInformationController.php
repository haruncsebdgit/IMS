<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\InvItemTransferReceiveInformation;
use App\Models\Inventory\InvItemTransferReceiveInformationItemInformation;
use Auth;
use Session;
use DB;

class ItemTransferReceiveInformationController extends Controller
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

        $data = InvItemTransferReceiveInformation::getMasterData();
        $data['item_transfer_receive_information'] = InvItemTransferReceiveInformation::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;

        return view('inventory.item-transfer-receive-information.index', $data);
    }

    public function create()
    {
        $data = InvItemTransferReceiveInformation::getMasterData();
        
        return view('inventory.item-transfer-receive-information.create', $data);
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
            InvItemTransferReceiveInformation::saveOrUpdate($request);

            Session::flash('success', __('Saved Successfully!'));

            // Redirect to edit mode.
            return redirect(action('Inventory\ItemTransferReceiveInformationController@create'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
        
    }

    public function edit($id)
    {
        $item_transfer_receive_information = InvItemTransferReceiveInformation::findOrFail($id);
        $data = InvItemTransferReceiveInformation::getMasterData($item_transfer_receive_information);
        $data['item_transfer_receive_information'] = $item_transfer_receive_information;
        $data['ivn_transfer_receive_item_info'] = $item_transfer_receive_information->ivnTransferReceiveItemInfo()->get();

        return view('inventory.item-transfer-receive-information.edit', $data);
    }

    public function show($id)
    {
        $item_transfer_receive_information = InvItemTransferReceiveInformation::findOrFail($id);
        $data = InvItemTransferReceiveInformation::getMasterData($item_transfer_receive_information);
        $data['item_transfer_receive_information'] = InvItemTransferReceiveInformation::getAll([], $id)[0];
        $data['ivn_transfer_receive_item_info'] = $item_transfer_receive_information->ivnTransferReceiveItemInfo()->get();
        return view('inventory.item-transfer-receive-information.show', $data);
    }

    public function update(Request $request, $id)
    {

        try {
            $this->validate($request, [
                'inventory_cost_center_to' => 'required',
                'transfer_date' => 'required'
                
            ]);
            InvItemTransferReceiveInformation::saveOrUpdate($request, $id);
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

            InvItemTransferReceiveInformationItemInformation::where('transfer_receive_item_id', $id)->delete();
            InvItemTransferReceiveInformation::destroy($id);
            
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
