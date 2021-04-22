<?php

namespace App\Controller;

use App\Controller\Service\InterpretationManager;
use Pam\Model\Factory\ModelFactory;
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
            $this->createVisitorData();

            return $this->render("front/home/home.twig", [
                "numbers" => $this->numbers
            ]);
        }

        return $this->render("front/home/home.twig");
    }

    private function createVisitorData()
    {
        $visitorData["visitDate"] = date('Y-m-d H:i:s');
        $visitorData["birthDate"] = $this->getPost()->getPostVar(
            "birthDate"
        );

        ModelFactory::getModel("Visitor")->createData($visitorData);
    }
}
