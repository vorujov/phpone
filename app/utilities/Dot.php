<?php
namespace Utilities;

/**
 * Array dot notation class.
 * Used to convert dot notation to the array
 */
class Dot
{
    /**
     * Returns whether or not the $key exists within the $array
     * @param  array  $array Array to be checked
     * @param  string  $key  Dot notation key
     * @return boolean       True if the $key exists, false otherwise
     */
    public static function has($array, $key)
    {
        if (!is_array($array) || !is_string($key)) {
            return false;
        }

        if (strpos($key, '.') !== false) {
            $keys = explode('.', $key);

            foreach ($keys as $key) {
                if (!is_array($array) || !array_key_exists($key, $array)) {
                    return false;
                }

                $array = $array[$key];
            }

            return true;
        }

        return array_key_exists($key, $array);
    }

    /**
     * Returns the value of the $key if found in $array or $default
     * @param  array $array   An array to be checked
     * @param  string $key    Dot notation string to serach for
     * @param  mixed $default Default value $Key not found
     * @return mixed          
     */
    public static function get($array, $key, $default = null)
    {
        if (!is_array($array) || !is_string($key)) {
            return $default;
        }

        if (strpos($key, '.') !== false) {
            $keys = explode('.', $key);

            foreach ($keys as $key) {
                if (!is_array($array) || !array_key_exists($key, $array)) {
                    return $default;
                }

                $array = $array[$key];
            }

            return $array;
        }

        return array_key_exists($key, $array) ? $array[$key] : $default;
    }

    /**
     * Used to set the $value identified by $key inside the $array
     * @param array  &$array An array to add $key to.
     * @param string $key    Dot notation key
     * @param mixed $value  Value of the key
     */
    public static function set(array &$array, $key, $value)
    {
        if (strpos($key, '.') !== false) {
            $keys = explode('.', $key);

            while (count($keys) > 1) {
                $key = array_shift($keys);

                if (!isset($array[$key]) || !is_array($array[$key])) {
                    $array[$key] = [];
                }

                $array = &$array[$key];
            }

            $array[array_shift($keys)] = $value;
        } else {
            $array[$key] = $value;
        }
    }

    /**
     * Deletes a $key and its value from the $array
     *
     * @param  array &$array
     * @param string $key
     */
    public static function delete(array &$array, $key)
    {
        if (strpos($key, '.') !== false) {
            $keys = explode('.', $key);

            while (count($keys) > 1) {
                $key = array_shift($keys);
                $array = &$array[$key];
            }

            $key = array_shift($keys);
            unset($array[$key]);
        } else {
            unset($array[$key]);
        }
    }
}
