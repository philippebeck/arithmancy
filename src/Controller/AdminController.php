<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
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
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        $numbers        = ModelFactory::getModel("Number")->listData();
        $definitions    = ModelFactory::getModel("Definition")->listData();
        $users          = ModelFactory::getModel("User")->listData();

        return $this->render("back/admin/admin.twig", [
            "numbers"       => $numbers,
            "definitions"   => $definitions,
            "users"         => $users
        ]);
    }
}
