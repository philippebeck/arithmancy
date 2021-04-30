<?php

namespace App\Controller;

use App\Controller\InterpretationManager;
use Pam\Model\ModelFactory;
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
        if ($this->checkArray($this->getPost())) {

            if (
                $this->getPost("birthDate") !== "" 
                && $this->getPost("usualFirstName") !== ""  
                && $this->getPost("lastName") !== ""
            ) {
                $this->createCustomerData();

                if ($this->getPost("email")) {
                    $mail["email"]    = $this->getPost("email");
                    $mail["name"]     = $this->getPost("usualFirstName");
                    $mail["subject"]  = "Thème Numérologique";
                    $mail["message"]  = implode("\n", $this->numbers);

                    $this->sendMail($mail);
    
                    $this->setSession([
                        "message"   => "Thème Envoyé avec Succès à " . $mail["name"] . " !",
                        "type"      => "green"
                    ]);
                }

                return $this->render("front/theme.twig", [
                    "numbers" => $this->numbers
                ]);
            }
        }

        return $this->render("front/theme.twig");
    }

    private function createCustomerData()
    {
        $customerData["visitDate"]  = date('Y-m-d H:i:s');
        $customerData["birthDate"]  = $this->getPost("birthDate");

        $customerData["usualFirstName"] = $this->getString(
            $this->getPost("usualFirstName"), 
            "alpha"
        );

        $customerData["middleName"] = $this->getString(
            $this->getPost("middleName"), 
            "alpha"
        );

        $customerData["thirdName"] = $this->getString(
            $this->getPost("thirdName"), 
            "alpha"
        );

        $customerData["lastName"] = $this->getString(
            $this->getPost("lastName"), 
            "alpha"
        );

        ModelFactory::getModel("Customer")->createData($customerData);
    }
}
