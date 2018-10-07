<?php 
namespace Core;

/**
 * Main application class
 */
class App extends Data
{
    /**
     * An array of the URL routes;
     * Each route is an array itself
     * @var array
     */
    private static $routes = [];

    /**
     * Initialize the App
     */
    public function __construct()
    {
    }

    /**
     * Add a new route to the App::$routes static property
     * App::$routes will be mapped with a route in App::run();
     *
     * Format: ["METHOD", "/uri/", "Controller"]
     * Example: App::addRoute("GET|POST", "/stores/?", "Stores")
     */
    public static function addRoute()
    {
        $route = func_get_args();
        if ($route) {
            self::$routes[] = $route;
        }
    }

    /**
     * Get App:$routes static property
     * @return array An array of the added routes
     */
    public static function getRoutes()
    {
        return self::$routes;
    }

    /**
     * Load route patterns, find the matched route 
     * and initialize the corresponding controller. 
     * @return self 
     */
    protected function route()
    {
        // Define Base Path (for routing)
        $base_path = explode("//", APP_URL, 2);
        $base_path = explode("/", $base_path[1], 2);
        $base_path = isset($base_path[1]) ? "/" . $base_path[1] : "";

        $router = new \AltoRouter();
        $router->setBasePath($base_path);
        $router->addMatchTypes([
            's'  => '[0-9A-Za-z\-]++', // url slug
        ]);

        include APP_PATH . "/inc/routes.inc.php";

        // Map routes
        $router->addRoutes(self::getRoutes());

        // Match the route
        $route = $router->match();
        $route = json_decode(json_encode($route));

        if ($route) {
            if (is_array($route->target)) {
                require_once $route->target[0];
                $controller = $route->target[1];
            } else {
                $controller = "\Controllers\\" . $route->target;
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            $controller = "\Controllers\\NotFound";
        }

        $this->set("controller", new $controller($this));
        $this->set("route", $route);

        return $this;
    }

    /**
     * Setup database connection
     * @return self 
     */
    protected function db()
    {
        $serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
        $serviceContainer->checkVersion('2.0.0-dev');
        $serviceContainer->setAdapterClass('default', 'mysql');

        $manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
        $manager->setConfiguration(
            [
                'classname' => '\Propel\\Runtime\\Connection\\ConnectionWrapper',
                'dsn' => 'mysql:host=' . DB_HOST . ';dbname='. DB_NAME .'',
                'user' => DB_USER,
                'password' => DB_PASS,
                'settings' => [
                    'charset' => DB_CHARSET,
                    'queries' => []
                ],
                'model_paths' => []
            ]
        );

        $manager->setName('default');
        $serviceContainer->setConnectionManager('default', $manager);
        $serviceContainer->setDefaultDatasource('default');
    }

    /**
     * Setup internationalization
     * @return self 
     */
    protected function i18n()
    {
        $route = $this->route;

        if (isset($route->params->lang)) {
            // Direct link or language change
            // Getting lang from route
            $lang = $route->params->lang;
        } else if (Input::cookie("lang")) {
            // Returning user,
            // Getting lang. from the cookie
            $lang = Input::cookie("lang");
        } else {
            $lang = Config::get("i18n.default");
        }

        // Validate found language code
        $active_lang = Config::get("i18n.default");
        foreach (Config::get("i18n.langs") as $l) {
            if ($l["code"] == $lang || $l["shortcode"] == $lang) {
                // found, break loop
                $active_lang = $l["code"];
                break;
            }
        }

        define("ACTIVE_LANG", $active_lang);
        setcookie("lang", ACTIVE_LANG, time() + 30 * 86400, "/");

        $translator = new \Gettext\Translator;

        // Load locale
        $path = APP_PATH . "/locale/" . ACTIVE_LANG . "/messages.po";
        if (file_exists($path)) {
            $translations = \Gettext\Translations::fromPoFile($path);
            $translator->loadTranslations($translations);
        }

        // Register global functions of the translator: __() etc.
        $translator->register();

        return $this;
    }

    /**
     * Add view contexts
     * @return self 
     */
    protected function views()
    {
        View::setContext("app", APP_PATH . "/views");
        View::setDefaultContext("app");
        return $this;
    }

    /**
     * Run the application
     * @return void 
     */
    public function run()
    {
        // Handle database connection
        $this->db();
        
        // Proceed the route
        $this->route();

        // Internationalization
        $this->i18n();

        // Setup view contexts/directories
        $this->views();

        // Run the controller
        $this->controller->run();
    }
}
