<?php namespace App\Http;


class ENtoBN
{
    /**
     * Bangla Date translate class for WordPress
     *
     * Converts English months, dates to equivalent Bangla digits
     * and month names.
     *
     * @author Tareq Hasan <tareq@wedevs.com>
     */

    /**
     * Main function that handles the string
     *
     * @param string $str
     * @return string
     */
    public static function translate($str)
    {
//        if (!$str) {
//            return;
//        }

        $str = self::translate_number($str);
        $str = self::translate_day($str);
        $str = self::translate_am($str);

        return $str;
    }

    /**
     * Translate numbers only
     *
     * @param string $str
     * @return string
     */
    public static function translate_number($str)
    {
        $en = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        $bn = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');

        $str = str_replace($en, $bn, $str);

        return $str;
    }

    /**
     * Translate months only
     *
     * @param string $str
     * @return string
     */
    public static function translate_day($str)
    {
        $en = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $en_short = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

        $bn = array('জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর');
        $bn_short = array('জানু.', 'ফেব্রু.', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টে.', 'অক্টো.', 'নভে.', 'ডিসে.');

        $str = str_replace($en, $bn, $str);
        $str = str_replace($en_short, $bn_short, $str);

        return $str;
    }

    /**
     * Translate AM and PM
     *
     * @param string $str
     * @return string
     */
    public static function translate_am($str)
    {
        $en = array('am', 'AM', 'pm', 'PM');
        $bn = array('পূর্বাহ্ন', 'পূর্বাহ্ন', 'অপরাহ্ন', 'অপরাহ্ন');

        $str = str_replace($en, $bn, $str);

        return $str;
    }


    public static function translateAlphabetToConsonent($str){


        $en = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $bn = array('ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ', 'ছ', 'জ', 'ঝ', 'ঞ', 'ট', 'ঠ', 'ড', 'ঢ', 'ণ', 'ত', 'থ', 'দ', 'ধ', 'ন', 'প', 'ফ', 'ব', 'ভ', 'ম', 'য');

        $str = str_replace($en, $bn, $str);

        return $str;
    }

}
