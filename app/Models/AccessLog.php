<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class AccessLog extends Model
{
    protected $table = 'access_logs';

    //protected $dates = ['login_datetime', 'logout_datetime'];


    public function saveAccesslog()
    {
        $attributes_data = [
            'user_id' => Auth::id(),
            'login_ip' => Request::ip(),
            'login_datetime' => Carbon::now(),
            'user_agent' => Request::header('User-Agent')
        ];

        $id = DB::table($this->table)->insertGetId($attributes_data);
        session(['access_log_id' => $id]);
    }

    public function updateAccesslog()
    {
        DB::table($this->table)
            ->where('id', session('access_log_id'))
            ->update(['logout_datetime' => Carbon::now()]);
    }

    public static function getLogs($params)
    {
        if(empty($params['date_from'])){
            $dateFrom = '0000-00-00';
        } else {
            $dateFrom = date('Y-m-d', strtotime($params['date_from']));
        }

        $lang = config('app.locale');
        $name = "name_{$lang}";

        if(empty($params['date_to'])){
            $dateTo = '5000-00-00';
        }else {
            $dateTo = date('Y-m-d', strtotime($params['date_to']));
        }

        $logs = AccessLog::query()
                ->leftJoin('users', 'access_logs.user_id', '=', 'users.id')
                ->whereDate('access_logs.login_datetime', '>=', $dateFrom)
                ->whereDate('access_logs.login_datetime', '<=', $dateTo)
                ->select(
                    'access_logs.*',
                    "users.$name AS user_name",
                    "users.user_level AS user_level",
                    "users.address AS address"
                );

        if(!empty($params['user_id'])){
            $logs = $logs->where('users.id', $params['user_id']);
        }
        return $logs->latest('login_datetime')->get();
    }
}
