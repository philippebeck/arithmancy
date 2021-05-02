<?php

namespace App\Controller;

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
        if ($this->checkArray($this->getPost())) {
            $this->createVisitorData();

            return $this->render("front/home.twig", [
                "numbers" => $this->numbers
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
