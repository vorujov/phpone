<?php 
namespace Controllers;

/**
 * 404 Page Controller
 */
class NotFound extends \Core\Controller
{
    /**
     * Run the controller to proceed the main logic
     * @return void 
     */
    public function run()
    {
        $this->view("not-found");
    }
}

