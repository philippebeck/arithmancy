<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class CalculationController
 * @package App\Controller
 */
class CalculationController extends MainController
{
    /**
     * @var array
     */
    private $calculation = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $calculations = ModelFactory::getModel("Calculation")->listData();

        return $this->render("front/calculation.twig", [
            "calculations" => $calculations
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
            $this->setCalculationData();

            ModelFactory::getModel("Calculation")->createData(
                $this->calculation
            );

            $this->setSession([
                "message"   => "Nouveau Nombre Calculé créé !", 
                "type"      => "green"
            ]);

            $this->redirect("admin");
        }

        return $this->render("back/createCalculation.twig");
    }

    private function setCalculationData()
    {
        $this->calculation["name"]          = (string) trim($this->getPost("name"));
        $this->calculation["description"]   = (string) trim($this->getPost("description"));
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

        $calculation = ModelFactory::getModel("Calculation")->readData($this->getGet("id"));

        if ($this->checkArray($this->getPost())) {
            $this->setCalculationData();

            ModelFactory::getModel("Calculation")->updateData(
                $this->getGet("id"), 
                $this->calculation
            );

            $this->setSession([
                "message"   => "Nombre Calculé sélectionné modifié !", 
                "type"      => "blue"
            ]);

            $this->redirect("admin");
        }

        return $this->render("back/updateCalculation.twig", [
            "calculation" => $calculation
        ]);
    }

    public function deleteMethod()
    {
        if ($this->checkAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Calculation")->deleteData($this->getGet("id"));

        $this->setSession([
            "message"   => "Nombre Calculé sélectionné supprimé !", 
            "type"      => "red"
        ]);

        $this->redirect("admin");
    }
}
