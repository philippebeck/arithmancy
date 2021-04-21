<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;

/**
 * Class VisitorController
 * @package App\Controller
 */
class VisitorController extends MainController
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

        ModelFactory::getModel("Visitor")->deleteData(
            $this->getGet()->getGetVar("id")
        );

        $this->getSession()->createAlert(
            "Suppression du visiteur effectuée !", 
            "red"
        );

        $this->redirect("admin");
    }
}
