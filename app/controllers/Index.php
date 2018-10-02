<?php 
namespace Controllers;

/**
 * Index Page Controller
 */
class Index extends \Core\Controller
{
    /**
     * Run the controller to proceed the main logic
     * @return void 
     */
    public function run()
    {
        $this->view("index");
    }
}

