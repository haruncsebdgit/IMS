<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\InvReturnItemInfo;
use App\Models\Inventory\InvItemReturnOnSupport;
use Auth;
use Session;
use DB;

class ItemReturnOnSupportController extends Controller
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

        $data = InvItemReturnOnSupport::getMasterData();
        $data['item_return_on_support'] = InvItemReturnOnSupport::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;

        return view('inventory.item-return-on-support.index', $data);
    }

    public function create()
    {
        $data = InvItemReturnOnSupport::getMasterData();
        
        return view('inventory.item-return-on-support.create', $data);
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
            InvItemReturnOnSupport::saveOrUpdate($request);

            Session::flash('success', __('Saved Successfully!'));

            // Redirect to edit mode.
            return redirect(action('Inventory\ItemReturnOnSupportController@create'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
        
    }

    public function edit($id)
    {
        $item_return_on_support = InvItemReturnOnSupport::findOrFail($id);
        $data = InvItemReturnOnSupport::getMasterData($item_return_on_support);
        $data['item_return_on_support'] = $item_return_on_support;
        $data['ivn_return_item_info'] = $item_return_on_support->ivnReturnItemInfo()->get();

        return view('inventory.item-return-on-support.edit', $data);
    }

    public function show($id)
    {
        $item_return_on_support = InvItemReturnOnSupport::findOrFail($id);
        $data = InvItemReturnOnSupport::getMasterData($item_return_on_support);
        $data['item_return_on_support'] = InvItemReturnOnSupport::getAll([], $id)[0];
        $data['ivn_return_item_info'] = $item_return_on_support->ivnReturnItemInfo()->get();
        return view('inventory.item-return-on-support.show', $data);
    }

    public function update(Request $request, $id)
    {

        try {
            $this->validate($request, [
                'supplier_vendor' => 'required',
                'date' => 'required'
                
            ]);
            InvItemReturnOnSupport::saveOrUpdate($request, $id);
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
            InvItemReturnOnSupport::destroy($id);
            
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
