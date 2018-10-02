<?php 
namespace Core;

/**
 * Data holder class;
 * Used to hold variables of the App and Controllers'
 * Uses magic __set() and __get() methods
 */
class Data
{
    /**
     * An associative array to push variables.
     * Key is the name of the variable, and value is the value of the variable
     * @var array
     */
    private $data = [];

    /**
     * Load new data
     * @param string $key   Name of the variable
     * @param mixed $value  Value of the variable
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;   
    }

    /**
     * Load new data with magic method. $obj->key = value;
     * @param string $key   Name of the variable
     * @param mixed $value  Value of the variable
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }


    /**
     * Get the value of the data
     * @param  string $key Name of the variable
     * @return mixed       Value of the variable
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        return null;   
    }

    /**
     * Get the value of the data with magic method: $obj->key;
     * @param  string $key Name of the variable
     * @return mixed       Value of the variable
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Return an array of all stored data
     * @return array 
     */
    public function data()
    {
        $data = new \stdClass;
        foreach ($this->data as $key => $value) {
            $data->{$key} = $value;
        }

        return $data;
    }
}
