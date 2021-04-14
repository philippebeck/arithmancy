<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class NumberController
 * @package App\Controller
 */
class NumberController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $numbers = ModelFactory::getModel("Number")->listData();

        return $this->render("front/numbers.twig", [
            "numbers" => $numbers
        ]);
    }
}
