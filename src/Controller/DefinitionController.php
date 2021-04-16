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
     * @var array
     */
    private array $definition = [];

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
            $this->setDefinitionData();

            ModelFactory::getModel("Definition")->createData(
                $this->definition
            );

            $this->getSession()->createAlert(
                "Nouvelle Définition créée !", "green"
            );

            $this->redirect("admin");
        }

        return $this->render("back/definition/createDefinition.twig");
    }

    private function setDefinitionData()
    {
        $this->definition["name"] = (string) trim(
            $this->getPost()->getPostVar("name")
        );

        $this->definition["description"] = (string) trim(
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

        $definition = ModelFactory::getModel("Definition")->readData(
            $this->getGet()->getGetVar("id")
        );

        if (!empty($this->getPost()->getPostArray())) {
            $this->setDefinitionData();

            ModelFactory::getModel("Definition")->updateData(
                $this->getGet()->getGetVar("id"), $this->definition
            );

            $this->getSession()->createAlert(
                "Définition sélectionnée modifiée !", "blue"
            );

            $this->redirect("admin");
        }

        return $this->render("back/definition/updateDefinition.twig", [
            "definition" => $definition
        ]);
    }

    public function deleteMethod()
    {
        if ($this->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Definition")->deleteData(
            $this->getGet()->getGetVar("id")
        );

        $this->getSession()->createAlert(
            "Définition sélectionnée supprimée !", "red"
        );

        $this->redirect("admin");
    }
}
