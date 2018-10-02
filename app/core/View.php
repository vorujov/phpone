<?php 
namespace Core;

/**
 * View, the V in the MVC. View interacts with Helpers and view variables passed
 * in from the controller to render the results of the controller action. Often 
 * this is HTML, but can also take the form of JSON, XML, PDF's or streaming files.
 */
class View extends Config
{
    /**
     * An associative array of the context directories to look for the view file
     * Key is the context name, value if the path of the directory
     * @var array
     */
    private static $contexts = [];

    /**
     * Name of the default context
     * @var null
     */
    private static $default_context = null;

    /**
     * View name
     * @var string|null
     */
    private $view = null;

    /**
     * Used to define whether the view file should be searched in context or not
     * @var boolean
     */
    private $view_in_context = true;

    /**
     * Contructor method. Define $view and $view_in_context properties
     * @param string  $view       View name
     * @param boolean $view_in_context 
     */
    public function __construct($view, $view_in_context = true)
    {
        if (!is_string($view)) {
            throw new \Exception('View name must be string');       
        }   

        $this->view = $view;
        $this->view_in_context = (bool)$view_in_context;
    }



    /**
     * Add/set context directory to the look for the view files
     * @param string $context 
     * @param string $path    
     */
    public static function setContext($context, $path)
    {
        if (is_string($context) && is_string($path)) {
            self::$contexts[$context] = $path;
        }
    }

    /**
     * Get the directory of the view files for the $context
     * @param  string $context 
     * @return string|null          
     */
    public static function getContext($context)
    {
        return isset(self::$contexts[$context]) 
            ? self::$contexts[$context] : null;
    }

    /**
     * Set the name of the default context
     * @param string $context Name of the context to be set as default
     */
    public static function setDefaultContext($context)
    {
        if (!is_string($context)) {
            throw new \Exception('Context name must be string.');
        }

        self::$default_context = $context;
    }

    /**
     * Render the view
     * @param  array  $data An associative array of the data to set 
     *                      as variable for the view files
     * @return void       
     */
    public function render($data = [])
    {
        $view_file = $this->view;

        if ($this->view_in_context) {
            if (strpos($this->view, ".") !== false) {
                $view = explode(".", $this->view, 2);
                $context = $view[0];
                $view = $view[1];
            } else if (self::$default_context) {
                $context = self::$default_context;
                $view = $this->view;
            } else {
                throw new \Exception('Context required.');
            }

            if ($context && self::getContext($context)) {
                $view_file = self::getContext($context) . "/" . $view . ".php";
            } else {
                throw new \Exception('Undefined context: "'.$context.'"');
            }
        }

        if (file_exists($view_file) && is_readable($view_file)) {
            // Parse data array
            foreach ($data as $key => $value) {
                ${$key} = $value;
            }

            include $view_file;
        } else {
            throw new \Exception('Couldn\'t find a readable view file: "'.$view_file.'"');
        }
    }
}
