<?php

namespace App\Models\Settings;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Employee Organogram Model Class.
 * php version >= 7.3
 *
 * @category Application
 * @package  MIS-NATP2
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @author   Ariful Islam Srabon <arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class EmployeeOrganogram extends Model
{
    use HasFactory;

    protected $table = 'employee_organograms';

    protected $fillable = [
        'employee_id',
        'organogram_id'
    ];

    /**
     * The Employees that belong to the Offices/Organograms.
     */
    public function employees(){
        return $this->belongsToMany(Employee::class, 'employee_organograms', 'employee_id', 'organogram_id');
    }
}