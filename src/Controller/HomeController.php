<?php

namespace App\Controller;

use App\Controller\Service\InterpretationManager;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends InterpretationManager
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

            return $this->render("front/home.twig", [
                "numbers" => $this->numbers
            ]);
        }

        return $this->render("front/home.twig");
    }
}
