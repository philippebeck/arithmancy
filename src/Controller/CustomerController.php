<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;

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
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Customer")->deleteData(
            $this->getGet()->getGetVar("id")
        );

        $this->getSession()->createAlert(
            "Suppression du client effectuée !", 
            "red"
        );

        $this->redirect("admin");
    }
}
