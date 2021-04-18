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
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        if (!empty($this->getPost()->getPostArray())) {
            $this->setNumberData();

            ModelFactory::getModel("Number")->createData(
                $this->number
            );

            $this->getSession()->createAlert(
                "Nouveau Nombre créé !", "green"
            );

            $this->redirect("admin");
        }

        return $this->render("back/number/createNumber.twig");
    }

    private function setNumberData()
    {
        $this->number["number"] = (int) trim(
            $this->getPost()->getPostVar("number")
        );

        $this->number["description"] = (string) trim(
            $this->getPost()->getPostVar("description")
        );

        $this->number["astral"] = (string) trim(
            $this->getPost()->getPostVar("astral")
        );

        $this->number["expression"] = (string) trim(
            $this->getPost()->getPostVar("expression")
        );

        $this->number["soul"] = (string) trim(
            $this->getPost()->getPostVar("soul")
        );

        $this->number["day"] = (string) trim(
            $this->getPost()->getPostVar("day")
        );

        $this->number["realization"] = (string) trim(
            $this->getPost()->getPostVar("realization")
        );

        $this->number["personal"] = (string) trim(
            $this->getPost()->getPostVar("personal")
        );

        $this->number["hereditary"] = (string) trim(
            $this->getPost()->getPostVar("hereditary")
        );

        $this->number["goal"] = (string) trim(
            $this->getPost()->getPostVar("goal")
        );

        $this->number["power"] = (string) trim(
            $this->getPost()->getPostVar("power")
        );

        $this->number["spiritual"] = (string) trim(
            $this->getPost()->getPostVar("spiritual")
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

        $number = ModelFactory::getModel("Number")->readData(
            $this->getGet()->getGetVar("id")
        );

        if (!empty($this->getPost()->getPostArray())) {
            $this->setNumberData();

            ModelFactory::getModel("Number")->updateData(
                $this->getGet()->getGetVar("id"), $this->number
            );

            $this->getSession()->createAlert(
                "Nombre sélectionné modifié !", "blue"
            );

            $this->redirect("admin");
        }

        return $this->render("back/number/updateNumber.twig", [
            "number" => $number
        ]);
    }

    public function deleteMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Number")->deleteData(
            $this->getGet()->getGetVar("id")
        );

        $this->getSession()->createAlert(
            "Nombre sélectionné supprimé !", "red"
        );

        $this->redirect("admin");
    }
}
