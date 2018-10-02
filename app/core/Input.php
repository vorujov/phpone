<?php
namespace Core;

/**
 * Get value of input (get, post, request, session, cookie) 
 */
class Input
{
    private static $methods = ["get", "post", "request", "cookie", "session"];

    /**
     * Session inputs
     * @param  string  $method      Name of method (get | post | request | session | cookie)
     * @param  string  $key         Key of input
     * @param  int|bool  $index     Index in input array of treat as $trim
     * @param  boolean $trim        Trim input value (if it is string) or not
     * @return mixed             
     */
    public static function getInput($method, $key, $index = true, $trim = true)
    {
        if(!in_array($method, self::$methods)) {
            throw new \Exception('Invalid method!');
        }

        $input = null;
        $method = "_".strtoupper($method);


        if (isset($GLOBALS[$method][$key])) {
            $input = $GLOBALS[$method][$key];
        }

        if (is_array($input) && is_int($index)){
            if ($index >= 0) {
                if (isset($input[$index])) {
                    $input = $input[$index];
                } else {
                    throw new \Exception('Index does not exist!');
                }
            } else {
                throw new \Exception('Index must be zero or positive integer');
            }
        }

        if (!is_array($input) || is_bool($index))  {
            $trim = (bool)$index;
        }

        if (is_string($input) && $trim) {
            $input =  trim($input);
        }

        return $input;
    }


    /**
     * Magic method to call static method
     * @param  string $name     Name of the method
     * @param  array $params    An array of the parameters to pass to the method
     * @return mixed            
     */
    public static function __callStatic($name, $params) 
    {   
        $name = strtolower($name);

        if($name == "req") {
            $name = "request";
        }

        if (in_array($name, self::$methods)) {
            array_unshift($params, $name);
            return call_user_func_array([__CLASS__, 'getInput'], $params);
        } else {
            throw new \Exception(__CLASS__ . "::" . $name . "() static method doesn't exist");
        }
    }


    /**
     * Magic method to call method
     * @param  string $name     Name of the method
     * @param  array $params    An array of the parameters to pass to the method
     * @return mixed            
     */
    public function __call($name, $arguments) 
    {   
        $name = strtolower($name);

        if($name == "req") {
            $name = "request";
        }

        if (in_array($name, self::$methods)) {
            array_unshift($arguments, $name);
            return call_user_func_array(['Input', 'getInput'], $arguments);
        } else {
            throw new \Exception(__CLASS__ . "::" . $name . "() method doesn't exist");
        }
    }

}
