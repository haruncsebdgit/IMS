<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\InvSupplier;
use Auth;
use Session;
use DB;
class SupplierController extends Controller
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
                'cig_name',
                'division_id',
                'district_id',
                'upazila_id',
                'union_id',
            )
        );


        $data['supplier_information'] = InvSupplier::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;

        return view('inventory.supplier-information.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = InvSupplier::getMasterData();
        return view('inventory.supplier-information.create', $data);
    }

    
    public function store(Request $request)
    {
        // dd($request->all());
         try {
            $this->validate($request, [
                'name_en' => 'required',
			
		]);
            $requestData = $request->all();
            
            $requestData['created_by'] = Auth::id();
            InvSupplier::create($requestData);

            Session::flash('success', __('Saved Successfully!'));

            // Redirect to edit mode.
            return redirect(action('Inventory\SupplierController@create'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $supplier_information = InvSupplier::getAll([], $id)[0];

        return view('inventory.supplier-information.show', compact('supplier_information'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $supplier_information = InvSupplier::findOrFail($id);
        $data = InvSupplier::getMasterData($supplier_information);
        $data['supplier_information'] = $supplier_information;

        return view('inventory.supplier-information.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        try {
            $requestData = $request->all();
            
            $supplier_information = InvSupplier::findOrFail($id);
            $requestData['updated_by'] = Auth::id();
            $supplier_information->update($requestData);

            Session::flash('success', __('Updated Successfully!'));
            return back();

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            InvSupplier::destroy($id);

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
