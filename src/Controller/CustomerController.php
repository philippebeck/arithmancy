<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;

/**
 * Class CustomerController
 * @package App\Controller
 */
class CustomerController extends MainController
{
    public function defaultMethod()
    {
        $this->redirect("admin");
    }

    public function deleteMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Customer")->deleteData($this->getGet("id"));

        $this->setSession([
            "message"   => "Suppression du client effectuée !", 
            "type"      => "red"
        ]);

        $this->redirect("admin");
    }
}
