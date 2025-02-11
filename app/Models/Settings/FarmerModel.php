<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\OrganizationScope;
use DB;

class FarmerModel extends Model
{
    use HasFactory;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'farmers';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
            'division_id',
            'district_id',
            'upazila_id',
            'union_id',
            'organization_id',
            'organogram_id',
            'project_id',

            'name_en',
            'name_bn',
            'gender',
            'is_ethnic',
            'ethnic_community_id',
            'father_name',
            'mother_name',
            'spouse_name',
            'spouse_name',
            'village',
            'date_of_birth',
            'nid',
            'mobile_no',
            'is_active',

            'created_by', 'updated_by',
            'created_at', 'updated_at'
    ];


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new OrganizationScope);
    }

    public function getDateOfBirthAttribute($value)
    {
        if ($value) {
            return date('d-m-Y', strtotime($value));
        } else {
            return null;
        }
    }
    public function setDateOfBirthAttribute($value)
    {
        if ($value) {
            $this->attributes['date_of_birth'] =  date('Y-m-d', strtotime($value));
        } else {
            $this->attributes['date_of_birth'] = null;
        }
    }



    /**
     * Get cigs List.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch cigs otherwise null.
     * --------------------------------------------------
     */
    public static function getAll($args = array(), $id = null)
    {
        $defaults = array(
            'exclude'           => array(),
            'order'             => array(
                'id'      => 'desc'
            ),
            'items_per_page' => -1,
            'paginate'       => false, // ignored, if 'items_per_page' = -1
        );
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $arguments = parseArguments($args, $defaults);

        $demoProductions =  FarmerModel::query();
        if (auth()->user()->organization_id == config('app.organization_id_dae')) {
            $demoProductions = $demoProductions->leftJoin('regions AS div', 'farmers.division_id', '=', 'div.id');
        }else{
            $demoProductions = $demoProductions->leftJoin('divisions AS div', 'farmers.division_id', '=', 'div.id');
        }

        $demoProductions = $demoProductions->leftJoin('districts AS dis', 'farmers.district_id', '=', 'dis.id')
                ->leftJoin('thana_upazilas AS t', 'farmers.upazila_id', '=', 't.id')
                ->leftJoin('union_wards AS u', 'farmers.union_id', '=', 'u.id')
                ->select('farmers.*',
                    "div.$name AS division_name",
                    "dis.$name AS district_name",
                    "t.$name AS upazila_name",
                    "u.$name AS union_name",
                );

        if (!is_null($id)) {
            $demoProductions = $demoProductions->where('farmers.id', $id);
        }

        if (!empty($arguments['division_id'])) {
            $demoProductions = $demoProductions->where('farmers.division_id', $arguments['division_id']);
        }
        if (!empty($arguments['district_id'])) {
            $demoProductions = $demoProductions->where('farmers.district_id', $arguments['district_id']);
        }

        if (!empty($arguments['upazila_id'])) {
            $demoProductions = $demoProductions->where('farmers.upazila_id', $arguments['upazila_id']);
        }

        if (!empty($arguments['union_id'])) {
            $demoProductions = $demoProductions->where('farmers.union_id', $arguments['union_id']);
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $demoProductions = $demoProductions->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $demoProductions = $demoProductions->get();
        } else {
            if (true == $arguments['paginate']) {
                $demoProductions = $demoProductions->paginate(intval($arguments['items_per_page']));
            } else {
                $demoProductions = $demoProductions->take(intval($arguments['items_per_page']));
                $demoProductions = $demoProductions->get();
            }
        }

        return $demoProductions;
    }


    /**
     * Get Technology List according to organization
     */
    public static function getFarmerList()
    {
        $lang = config('app.locale');
        $name = "name_{$lang} AS name";
        $farmers = FarmerModel::where('is_active',1);
        $farmers = $farmers->pluck($name, 'id');
        return $farmers;
    }



}
