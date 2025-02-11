<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\InvItemCategorySubCategoryInformation;
use Illuminate\Validation\Rule;
use App\Http\Requests\Inventory\InvItemCategorySubCategoryInformationRequest;
use Auth;
use Session;
use DB;

class ItemCategorySubCategoryInformationController extends Controller
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
                'name_bn',
                'parent',
            )
            );

        $data = InvItemCategorySubCategoryInformation::getMasterData();
        $data['item_category_sub_category_information'] = InvItemCategorySubCategoryInformation::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;

        return view('inventory.item-category-sub-category-information.index', $data);
    }

    public function create()
    {
        $data = InvItemCategorySubCategoryInformation::getMasterData();
        return view('inventory.item-category-sub-category-information.create' , $data);
    }

    public function store(InvItemCategorySubCategoryInformationRequest $request)
    {
        // return $request->all();
         try {
    
            $requestData = $request->all();
            
            $requestData['created_by'] = Auth::id();
            InvItemCategorySubCategoryInformation::create($requestData);

            Session::flash('success', __('Saved Successfully!'));

            // Redirect to edit mode.
            return redirect(action('Inventory\ItemCategorySubCategoryInformationController@create'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
        
    }

    public function edit($id)
    {
        $item_category_sub_category_information = InvItemCategorySubCategoryInformation::findOrFail($id);
        $data = InvItemCategorySubCategoryInformation::getMasterData($item_category_sub_category_information);
        $data['item_category_sub_category_information'] = $item_category_sub_category_information;

        return view('inventory.item-category-sub-category-information.edit', $data);
    }

    public function show($id)
    {
        $item_category_sub_category_information = InvItemCategorySubCategoryInformation::getAll([], $id)[0];

        return view('inventory.item-category-sub-category-information.show', compact('item_category_sub_category_information'));
    }

    public function update(InvItemCategorySubCategoryInformationRequest $request, $id)
    {

        try {
            $requestData = $request->all();
            
            $item_category_sub_category_information = InvItemCategorySubCategoryInformation::findOrFail($id);
            $requestData['updated_by'] = Auth::id();
            $item_category_sub_category_information->update($requestData);

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

            InvItemCategorySubCategoryInformation::destroy($id);

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
