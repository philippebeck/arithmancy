<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
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

        return $this->render("front/calculations.twig", [
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
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        if (!empty($this->getPost()->getPostArray())) {
            $this->setCalculationData();

            ModelFactory::getModel("Calculation")->createData(
                $this->calculation
            );

            $this->getSession()->createAlert(
                "Nouveau Nombre Calculé créé !", "green"
            );

            $this->redirect("admin");
        }

        return $this->render("back/calculation/createCalculation.twig");
    }

    private function setCalculationData()
    {
        $this->calculation["name"] = (string) trim(
            $this->getPost()->getPostVar("name")
        );

        $this->calculation["description"] = (string) trim(
            $this->getPost()->getPostVar("description")
        );
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        $calculation = ModelFactory::getModel("Calculation")->readData(
            $this->getGet()->getGetVar("id")
        );

        if (!empty($this->getPost()->getPostArray())) {
            $this->setCalculationData();

            ModelFactory::getModel("Calculation")->updateData(
                $this->getGet()->getGetVar("id"), $this->calculation
            );

            $this->getSession()->createAlert(
                "Nombre Calculé sélectionné modifié !", "blue"
            );

            $this->redirect("admin");
        }

        return $this->render("back/calculation/updateCalculation.twig", [
            "calculation" => $calculation
        ]);
    }

    public function deleteMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Calculation")->deleteData(
            $this->getGet()->getGetVar("id")
        );

        $this->getSession()->createAlert(
            "Nombre Calculé sélectionné supprimé !", "red"
        );

        $this->redirect("admin");
    }
}
