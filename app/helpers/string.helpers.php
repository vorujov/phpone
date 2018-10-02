<?php 
/**
 * Used to define string related helper functions
 */

if (!function_exists("html_escape")) {
    /**
     * Escape HTML tags. Converts special characters to HTML entities
     * @param  string $string String to be escaped
     * @return string         The converted string
     */
    function html_escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, "UTF-8");
    }
}


if (!function_exists("truncate_string")) {
    /**
     * Truncates the string and adds ellipsis to the end of the 
     * string if it's truncated.
     * @param  string  $string     String to truncate
     * @param  integer $max_length Max length of the final string
     * @param  string  $ellipsis   Ellipsis to add the the end of the 
     *                             truncated string
     * @return string              
     */
    function truncate_string($string = "", $max_length = 50, $ellipsis = "...")
    {
        $max_length = (int)$max_length;
        if ($max_length < 1) {
            $max_length = 50;
        }

        if (!is_string($string)) {
            $string = "";
        }

        if (!is_string($ellipsis)) {
            $ellipsis = "...";
        }

        $string_length = mb_strlen($string);
        $ellipsis_length = mb_strlen($ellipsis);

        if($string_length > $max_length){
            if ($ellipsis_length >= $max_length) {
                $string = mb_substr($ellipsis, 0, $max_length);
            } else {
                $string = mb_substr($string, 0, $max_length - $ellipsis_length)
                        . $ellipsis;
            }
        }

        return $string;
    }
}

if (!function_exists("mask_string")) {
    /**
     * Masks the given string with mask symbol
     * @param  string $string String to be masked
     * @param  string $type   Mask type
     * @param  string $mask   Mask sysbol. Should be single symbol.
     * @return string         Masked string
     */
    function mask_string($string = "", $type = "auto", $mask = "*")
    {
        $type = strtolower($type);
        if (strlen($string) < 1) {
            return $string;
        }

        if (!in_array($type, ["auto", "email", "phone", "regular"])) {
            $type = "regular";
        }

        if ($type == "auto") {
            if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
                $type = "email";
            } else if (
                preg_match("/^\+?[0-9]+$/i", str_replace([" ", "-"], "", $string))
            ) {
                $type = "phone";
            } else {
                $type = "regular";
            }
        }

        if ($type == "email") {
            $parts = explode("@", $string, 2);
            return mask_string($parts[0], "regular") 
                    . "@" 
                    . mask_string($parts[1], "regular");
        } else if ($type == "phone") {
            $string = str_replace(" ", "", $string);
            $length = strlen($string);
            for ($i = 4; $i >= 1; $i--) {
                if ($length > $i) {
                    return str_pad("", $length - $i, $mask) 
                            . substr($string, $length - $i);
                }
            }

            return $mask;
        } else {
            $length = strlen($string);
            if ($length > 2) {
                return substr($string, 0, 1) 
                        . str_pad("", $length - 2, $mask) 
                        . substr($string, $length - 1);
            } else if ($length == 2) {
                return $mask . substr($string, $length - 1);
            } else {
                return str_pad("", $length, "*");
            }
        }
    }
}
