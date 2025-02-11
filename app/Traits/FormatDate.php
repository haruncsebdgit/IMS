<?php
/**
 * Simple trait  for converting date from one format to another format
 * @author: Nazmul Hasan
 *
 */

namespace App\Traits;
use Carbon\Carbon;

trait FormatDate
{
    /**
     * This function is execute before storing data using laravel ORM
     * First check if form data is  date, then format date from (d-m-Y) to (Y-m-d)
     *
     * @param $key
     * @param $value
     * @return mixed
     * -----------------------------------------------------------------------------------------
     */
    public function setAttribute($key, $value)
    {

        if($this->isDate(trim($value))){
            $value = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        }

        return parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {

        $value = parent::getAttribute($key);

        if($this->isDate(trim($value), 'Y-m-d')){
            $value = Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y');
        }

        return $value;
    }

    /**
     * Check if a string is date or not
     *
     * @param $value    Form value
     * @return bool     true if date, false otherwise
     * --------------------------------------------------------------------------
     */
    public function isDate($value, $format = 'd-m-Y')
    {
        if(empty($value))   return false;

        if(date($format, strtotime($value)) == $value){
            return true;
        }else{
            return false;
        }
    }

}
