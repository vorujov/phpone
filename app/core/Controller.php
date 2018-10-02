<?php 
namespace Core;

/**
 * Main Controller
 * All controllers must be inherited from this class
 */
class Controller extends Data
{
    /**
     * Reference to the instance of the App
     * @var App
     */
    protected $app;

    /**
     * Response data wrapper
     * @var Response
     */
    protected $response;

    /**
     * summary
     */
    public function __construct($app)
    {
        /**
         * Set app
         * @var App
         */
        $this->app = $app;

        /**
         * Init. response wrapepr
         * @var Response
         */
        $this->response = new Response;
    }

    /**
     * Get response wrapper
     * @return Response 
     */
    public function resp()
    {
        return $this->response;
    }


    /**
     * Render the view with internal data and $extra_data
     * @param  string $view Name of the view. View name might 
     *                      contain the context name also. Ex: "index", "app.index"
     * @return void       
     */
    public function view($view, $extra_data = [], $view_in_context = true)
    {
        $data = $this->data();
        $data->app = $this->app->data();
        foreach ($extra_data as $key => $value) {
            $data->{$key} = $value;
        }

        $view  = new \Core\View($view, $view_in_context);
        $view->render($data);
    }

    /**
     * Each controller must have its own run() method.
     * Main logic of the controller should be processed in this method
     * @return void 
     */
    public function run()
    {
        // Do nothing here
    }
}
