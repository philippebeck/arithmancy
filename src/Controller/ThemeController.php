<?php

namespace App\Controller;

use App\Controller\Service\InterpretationManager;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ThemeController
 * @package App\Controller
 */
class ThemeController extends InterpretationManager
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

            if ($this->getPost()->getPostVar("birthDate") !== "" &&
            $this->getPost()->getPostVar("usualFirstName") !== ""  &&
            $this->getPost()->getPostVar("lastName") !== "") {

                $this->createCustomerData();

                return $this->render("front/theme/theme.twig", [
                    "numbers" => $this->numbers
                ]);
            }
        }

        return $this->render("front/theme/theme.twig");
    }

    private function createCustomerData()
    {
        $customerData["visitDate"]  = date('Y-m-d H:i:s');
        $customerData["birthDate"]  = $this->getPost()->getPostVar(
            "birthDate"
        );

        $customerData["usualFirstName"] = $this->getString()->cleanString(
            $this->getPost()->getPostVar("usualFirstName"), 
            "alpha"
        );

        $customerData["middleName"] = $this->getString()->cleanString(
            $this->getPost()->getPostVar("middleName"), 
            "alpha"
        );

        $customerData["thirdName"] = $this->getString()->cleanString(
            $this->getPost()->getPostVar("thirdName"), 
            "alpha"
        );

        $customerData["lastName"] = $this->getString()->cleanString(
            $this->getPost()->getPostVar("lastName"), 
            "alpha"
        );

        ModelFactory::getModel("Customer")->createData(
            $customerData
        );
    }
}
