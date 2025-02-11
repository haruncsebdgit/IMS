<?php

namespace App\Http\Controllers\FrontEnd;


use Illuminate\Http\Request;

use App\Models\Settings\District;
use App\Models\Settings\Division;
use App\Models\Settings\UnionWard;
use App\Http\Controllers\Controller;
use App\Models\Settings\ThanaUpazila;
use App\Models\Settings\FinancialYear;

class DashboardController extends Controller
{
    /**
     * Dashboard Index page.
     * Display subsequent pages based on the submitted form data.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array();


        // $view = 'frontend.index';
        $view = 'auth.login';

        return view($view)->with($data);
    }
}
