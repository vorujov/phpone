<?php 

if (!function_exists("active_lang")) {
    /**
     * Get/Set option values [code, shortcode, name, localname] for the ACTIVE_LANG
     * @param  string|null $option Name of the option
     * @param  string|null $value  value of the option to set. If null don't update the value
     * @return string|null         Value of the option or null (if not found)
     */
    function active_lang($option = null, $value = null)
    {
        if (!defined("ACTIVE_LANG")) {
            // Active lang is not defined,
            // It's too early to call this function yet
            return null;
        }

        if (is_null($options)) {
            return ACTIVE_LANG;
        }

        $options = ["code", "shortcode", "name", "localname"];
        if (!in_array($option, $options)) {
            // Invalid option name
            return null;
        }

        if (is_null($value)) {
            if (\Core\Config::get("i18n.active.".$option)) {
                // Found the required value
                return \Core\Config::get("i18n.active.".$option);
            }   

            // Search for the value of the option
            foreach (\Core\Config::get("i18n.langs") as $al) {
                if ($al["code"] == ACTIVE_LANG) {
                    // found, break loop
                    foreach ($al as $key => $value) {
                        \Core\Config::set("i18n.active.".$key, $value);
                    }
                    break;
                }
            }

            // Return the option value.
            // If the option is not found in the foreach loop above
            // then NULL value will be returned automatically. See \Core\Config::get()
            return \Core\Config::get("i18n.active.".$option);
        } else {
            \Core\Config::set("i18n.active.".$option, $value);
            return \Core\Config::get("i18n.active.".$option);
        }
    }
}

if (!function_exists("url")) {
    /**
     * Converts application root absolute urls to the domain root absolute urls 
     * @param  string $url URL relative to the app root url
     *                               Ex: "/dashboard"
     * @return string|null           Absolute URL on success, null otherwise
     */
    function url($url) 
    {
        if (!defined("APP_URL") || !defined("DOMAIN_URL")) {
            return $url;
        }

        if (!is_string($url) || $url[0] != "/") {
            return $url;
        }

        $url = APP_URL . $url;

        if (strpos($url, DOMAIN_URL) === 0) {
            $url = substr($url, strlen(DOMAIN_URL));
        }

        return $url;
    }
}

if (!function_exists("is_valid_date")) {
        /**
         * Validates date format
         * @param string $date date to validate
         * @return boolean 
         */
        function is_valid_date($date, $format="d-m-Y"){
            $d = DateTime::createFromFormat($format, $date);
            return $d && $d->format($format) === $date;
        }

}

