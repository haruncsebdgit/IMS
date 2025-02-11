<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\CommonLabel;
use App\Scopes\OrganizationScope;
use App\Models\Procurement\Tenderer;
use DB;

class InvSupplier extends Model
{
    use HasFactory;
    protected $table = 'inv_suppliers';

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
         'organization_id',
         'name_en',
        'name_bn', 'contact_no',
        'email', 'website',
        'address', 'tender_id',
        'remarks', 'is_active',
        'organogram_id',
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

        $inv_suppliers = InvSupplier::query()
            ->select(
                'inv_suppliers.*'
            );

        if (!is_null($id)) {
            $inv_suppliers = $inv_suppliers->where('inv_suppliers.id', $id);
        }

        if (!empty($arguments['name'])) {
            $inv_suppliers = $inv_suppliers->where('inv_suppliers.name_en', 'LIKE', '%' . $arguments['name'] . '%');
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $inv_suppliers = $inv_suppliers->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $inv_suppliers = $inv_suppliers->get();
        } else {
            if (true == $arguments['paginate']) {
                $inv_suppliers = $inv_suppliers->paginate(intval($arguments['items_per_page']));
            } else {
                $inv_suppliers = $inv_suppliers->take(intval($arguments['items_per_page']));
                $inv_suppliers = $inv_suppliers->get();
            }
        }

        return $inv_suppliers;
    }

    /**
     * Get all master data to populate dropdown in CIG info form
     */
    public static function getMasterData($inv_suppliers = null)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";
        $data['tenderer'] = [];
        return $data;
    }
}
