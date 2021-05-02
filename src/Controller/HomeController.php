<?php

namespace App\Controller;

use App\Manager\DateInterpreter;
use App\Manager\MainInterpreter;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends MainInterpreter
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if ($this->checkArray($this->getPost(), "birthDate")) {
            $this->createVisitorData();

            $dateInterpreter    = new DateInterpreter();
            $dateData           = $dateInterpreter->getDateData();

            return $this->render("front/home.twig", [
                "dateData" => $dateData
            ]);
        }

        return $this->render("front/home.twig");
    }

    private function createVisitorData()
    {
        $visitorData["visitDate"] = date('Y-m-d H:i:s');
        $visitorData["birthDate"] = $this->getPost("birthDate");

        ModelFactory::getModel("Visitor")->createData($visitorData);
    }
}
