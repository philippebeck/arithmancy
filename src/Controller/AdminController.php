<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        $numbers        = ModelFactory::getModel("Number")->listData();
        $calculations   = ModelFactory::getModel("Calculation")->listData();
        $visitors       = ModelFactory::getModel("Visitor")->listData();
        $customers      = ModelFactory::getModel("Customer")->listData();
        $users          = ModelFactory::getModel("User")->listData();

        return $this->render("back/admin.twig", [
            "numbers"       => $numbers,
            "calculations"  => $calculations,
            "visitors"      => $visitors,
            "customers"     => $customers,
            "users"         => $users
        ]);
    }
}
