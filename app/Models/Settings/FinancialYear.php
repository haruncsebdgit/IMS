<?php

namespace App\Models\Settings;

use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Financial Year Model Class.
 *
 * @category Application
 * @package  LGSP3
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class FinancialYear extends Model
{
    protected $table = "financial_years";

    protected $fillable = [
        'year_name',
        'start_date',
        'end_date',

        'sort_order',
        'is_active',
        'is_current_fy',

        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * Get Financial Year.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch financial year otherwise null.
     * --------------------------------------------------
     */
    public static function getFinancialYear($args = array())
    {
        $defaults = array(
            'exclude'        => array(),
            'year_name'      => '',
            'start_date'     => null,
            'end_date'       => null,
            'search'         => '',
            'author'         => null, // int|array
            'status'         => '',
            'order'          => array(
                'financial_years.id'        => 'desc',
                'financial_years.year_name' => 'asc'
            ),
            'items_per_page' => -1,
            'paginate'       => false, // ignored, if 'items_per_page' = -1
        );

        $arguments = parseArguments($args, $defaults);

        $financialYears = DB::table('financial_years');

        $financialYears = $financialYears->select('financial_years.*');

        if (!empty($arguments['exclude'])) {
            $financialYears = $financialYears->whereNotIn('financial_years.id', $arguments['exclude']);
        }

        if (!empty($arguments['year_name'])) {
            $search_name = $arguments['year_name'];

            $financialYears = $financialYears->where(
                function ($financialYears) use ($search_name) {
                    $financialYears->where('financial_years.year_name', 'LIKE', '%' . $search_name . '%');
                }
            );
        }

        if (!empty($arguments['start_date'])) {
            $startDate = date("Y-m-d", strtotime($arguments['start_date']));
        }

        if (!empty($arguments['end_date'])) {
            $endDate = date("Y-m-d", strtotime($arguments['end_date']));
        }

        if (!empty($arguments['start_date'])) {
            $financialYears = $financialYears->where('financial_years.start_date', $startDate);
        }

        if (!empty($arguments['end_date'])) {
            $financialYears = $financialYears->where('financial_years.end_date', $endDate);
        }

        if (!empty($arguments['author'])) {
            if (is_array($arguments['author'])) {
                $financialYears = $financialYears->whereIn('financial_years.created_by', $arguments['author']);
            } else {
                $financialYears = $financialYears->where('financial_years.created_by', $arguments['author']);
            }
        }

        if (!empty($arguments['search'])) {
            $search_query = $arguments['search'];

            $financialYears = $financialYears->where(
                function ($financialYears) use ($search_query) {
                    $financialYears->where('financial_years.year_name', 'LIKE', '%' . $search_query . '%');
                }
            );
        }

        if ($arguments['status']) {
            if (is_array($arguments['status'])) {
                $financialYears = $financialYears->whereIn('financial_years.is_active', $arguments['status']);
            } else {
                $financialYears = $financialYears->where('financial_years.is_active', $arguments['status']);
            }
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $financialYears = $financialYears->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $financialYears = $financialYears->get();
        } else {
            if (true == $arguments['paginate']) {
                $financialYears = $financialYears->paginate(intval($arguments['items_per_page']));
            } else {
                $financialYears = $financialYears->take(intval($arguments['items_per_page']));
                $financialYears = $financialYears->get();
            }
        }

        return $financialYears;
    }

    /**
     * Get Financial Year List
     *
     * @return array
     */
    public function getYearList()
    {
        $yearList = DB::table($this->table)->orderBy('year_name', 'desc')->where('is_active', 1)->pluck('year_name', 'id');

        return $yearList;
    }

    /**
     * Get All Financial Year List
     *
     * @return array
     */
    public function getAllFinancialYearList()
    {
        $yearList = DB::table($this->table)->where('is_active', 1)->orderBy('year_name', 'desc')->pluck('year_name', 'id');

        return $yearList;
    }

    /**
     * Get Financial Year Range
     *
     * @param int $start_date Start Date of Financial Year .
     * @param int $end_date End Date of Financial Year .
     *
     * @return \Illuminate\Http\Response
     */
    public static function getFinancialYearRange($start_date, $end_date)
    {
        $yearInfo = DB::select("SELECT id, start_date, end_date, year_name
                                FROM financial_years
                                WHERE (start_date BETWEEN '{$start_date}' AND '{$end_date}'
                                OR end_date BETWEEN '{$start_date}' AND '{$end_date}'
                                OR '{$start_date}' BETWEEN start_date AND end_date)
                                ORDER BY start_date,end_date");

        $year_array = [];

        foreach ($yearInfo as $key => $value) {
            $year_array[$value->id] = $value->year_name;
        }

        $min_year_value = translateString(min($year_array));
        $max_year_value = translateString(max($year_array));

        if ($min_year_value === $max_year_value) {
            return $min_year_value;
        } else {
            return "{$min_year_value} ― {$max_year_value}";
        }
    }

    public static function getAllYearList(){
        return FinancialYear::orderBy('year_name', 'desc')->where('is_active', 1)->pluck('year_name', 'id');
    }
}
