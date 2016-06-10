<?php

class Maxxdev_Helper_Date {

    /**
     * Converts nglish day names to german day names
     * This can be very helpful, if you´re not able/allowed to setlocale() on some servers
     *
     * @param string $str
     * @return string
     */
    public static function getGermanDays($str) {
        return str_replace(array(
            "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
            ), array(
            "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag", "Sonntag"
            ), $str);
    }

    /**
     * Converts english month names to german month names
     * This can be very helpful, if you´re not able/allowed to setlocale() on some servers
     *
     * @param string $str
     * @return string
     */
    public static function getGermanMonths($str) {
        return str_replace(array(
            "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
            ), array(
            "Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"
            ), $str);
    }

    public static function getTimestamp($timestampOrDate) {
        if (strpos($timestampOrDate, "-") !== false || strpos($timestampOrDate, ".") !== false) {
            // DATE
            return strtotime($timestampOrDate);
        } else {
            // TIMESTAMP
            return $timestampOrDate;
        }
    }

    public static function getAngularTimestamp($datetime) {
        //return str_replace(" ", "T", $datetime) . "Z";
        return str_replace(" ", "T", $datetime);
    }

}
