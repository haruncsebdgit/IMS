<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings\District;
use App\Models\Settings\Division;
use App\Models\Settings\ThanaUpazila;
use App\Models\Settings\UnionWard;
use DB;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Admin Dashboard Controller.
 * php version 7.1.3
 *
 * @category CMS/Admin
 * @package  LGSP3
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     * --------------------------------------------------
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function index($module = null)
    {
        //dd($module);
        $data               = array();

        return view("admin.dashboard", $data);

    }

    /**
     * Showing inventory dashboard
     */
    public function showInventoryModule()
    {
        return view('admin.dashboard-inventory');
    }
}
