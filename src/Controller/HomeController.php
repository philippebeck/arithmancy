<?php

namespace App\Controller;

use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends CalculationController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if (!empty($this->getPost()->getPostArray())) {
            $astralNumbers  = $this->getAstralNumbers();
            $astralNumber   = ModelFactory::getModel("Numbers")->readData($astralNumbers[2]);

            return $this->render("front/home.twig", [
                "astralNumber" => $astralNumber
            ]);
        }

        return $this->render("front/home.twig");
    }
}
