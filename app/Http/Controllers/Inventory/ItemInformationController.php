<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\InvItemInformation;
use App\Http\Requests\Inventory\InvItemInformationRequest;
use Auth;
use Session;
use DB;

class ItemInformationController extends Controller
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
                'name_en',
                'code_en',
                'category',
                'part_number'
            )
            );

        $data = InvItemInformation::getMasterData();
        $data['item_information'] = InvItemInformation::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;

        return view('inventory.item-information.index', $data);
    }

    public function create()
    {
        $data = InvItemInformation::getMasterData();
        return view('inventory.item-information.create' , $data);
    }

    public function store(InvItemInformationRequest $request)
    {
        // return $request->all();
         try {
    
            $requestData = $request->all();
            
            $requestData['created_by'] = Auth::id();
            InvItemInformation::create($requestData);

            Session::flash('success', __('Saved Successfully!'));

            // Redirect to edit mode.
            return redirect(action('Inventory\ItemInformationController@create'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
        
    }

    public function edit($id)
    {
        $item_information = InvItemInformation::findOrFail($id);
        $data = InvItemInformation::getMasterData($item_information);
        $data['item_information'] = $item_information;

        return view('inventory.item-information.edit', $data);
    }

    public function show($id)
    {
        $item_information = InvItemInformation::getAll([], $id)[0];

        return view('inventory.item-information.show', compact('item_information'));
    }

    public function update(InvItemInformationRequest $request, $id)
    {

        try {
            $requestData = $request->all();
            
            $item_information = InvItemInformation::findOrFail($id);
            $requestData['updated_by'] = Auth::id();
            $item_information->update($requestData);

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

            InvItemInformation::destroy($id);

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
