<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
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
     * @var array
     */
    private $number = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $numbers = ModelFactory::getModel("Number")->listData();

        return $this->render("front/number.twig", [
            "numbers" => $numbers
        ]);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        if ($this->checkArray($this->getPost())) {
            $this->setNumberData();

            ModelFactory::getModel("Number")->createData(
                $this->number
            );

            $this->setSession([
                "message"   => "Nouveau Nombre créé !", 
                "type"      => "green"
            ]);

            $this->redirect("admin");
        }

        return $this->render("back/createNumber.twig");
    }

    private function setNumberData()
    {
        $this->number["number"] = (int) trim($this->getPost("number"));

        $this->number["description"]    = (string) trim($this->getPost("description"));
        $this->number["astral"]         = (string) trim($this->getPost("astral"));
        $this->number["expression"]     = (string) trim($this->getPost("expression"));
        $this->number["soul"]           = (string) trim($this->getPost("soul"));
        $this->number["day"]            = (string) trim($this->getPost("day"));
        $this->number["realization"]    = (string) trim($this->getPost("realization"));
        $this->number["personal"]       = (string) trim($this->getPost("personal"));
        $this->number["hereditary"]     = (string) trim($this->getPost("hereditary"));
        $this->number["goal"]           = (string) trim($this->getPost("goal"));
        $this->number["power"]          = (string) trim($this->getPost("power"));
        $this->number["spiritual"]      = (string) trim($this->getPost("spiritual"));
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        $number = ModelFactory::getModel("Number")->readData($this->getGet("id"));

        if (!empty($this->getPost())) {
            $this->setNumberData();

            ModelFactory::getModel("Number")->updateData(
                $this->getGet("id"), 
                $this->number
            );

            $this->setSession([
                "message"   => "Nombre sélectionné modifié !", 
                "type"      => "blue"
            ]);

            $this->redirect("admin");
        }

        return $this->render("back/updateNumber.twig", ["number" => $number]);
    }

    public function deleteMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Number")->deleteData($this->getGet("id"));

        $this->setSession([
            "message"   => "Nombre sélectionné supprimé !", 
            "type"      => "red"
        ]);

        $this->redirect("admin");
    }
}
