<?php
namespace Core;

use Utilities\Dot;

/**
 * Configuration class.
 * Used for managing runtime configuration information.
 */
class Config
{
    /**
     * An array of values currently stored in Config.
     * @var array
     */
    protected static $values = [];


    /**
     * Used to store a dynamic variable in Config.
     * @param string $key  name of setting.
     * @param mixed $value value of setting.
     */
    public static function set($key, $value = null)
    {
        Dot::set(self::$values, $key, $value);
    }

    /**
     * Used to read information stored in Config.
     * @param  string $key    Variable to obtain
     * @param  mixed $default The return value when the configure does not exist
     * @return mixed          Value stored in Config or default value
     */
    public static function get($key, $default = null)
    {
        return Dot::get(self::$values, $key, $default);
    }    
}
