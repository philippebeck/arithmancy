<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class DefinitionController
 * @package App\Controller
 */
class DefinitionController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $definitions = ModelFactory::getModel("Definition")->listData();

        return $this->render("front/definitions.twig", [
            "definitions" => $definitions
        ]);
    }
}
