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
     * @var string
     */
    private $firstName = "";

    /**
     * @var string
     */
    private $middleName = "";

    /**
     * @var string
     */
    private $thirdName = "";

    /**
     * @var string
     */
    private $lastName = "";

    /**
     * @var string
     */
    private $birthDate = "";

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if ($this->checkArray($this->getPost())) {
            $this->setCustomerData();

            if ($this->firstName !== "" && $this->lastName !== "" && $this->birthDate !== "") {

                $this->createCustomerData();
                $this->sendTheme();                
    
                return $this->render("front/theme.twig", [
                    "numbers" => $this->numbers
                ]);
            }
    
            $this->setSession([
                "message"   => "Prénom, Nom & Date de Naissance DOIVENT être renseignés!",
                "type"      => "red"
            ]);
        }

        return $this->render("front/theme.twig");
    }

    private function setCustomerData()
    {
        $this->firstName = $this->getString(
            $this->getPost("usualFirstName"), 
            "alpha"
        );

        $this->middleName = $this->getString(
            $this->getPost("middleName"), 
            "alpha"
        );

        $this->thirdName = $this->getString(
            $this->getPost("thirdName"), 
            "alpha"
        );

        $this->lastName = $this->getString(
            $this->getPost("lastName"), 
            "alpha"

        );

        $this->birthDate = $this->getPost("birthDate");
    }

    private function createCustomerData()
    {
        $customerData["firstName"]  = $this->firstName;
        $customerData["middleName"] = $this->middleName;
        $customerData["thirdName"]  = $this->thirdName;
        $customerData["lastName"]   = $this->lastName;
        $customerData["birthDate"]  = $this->birthDate;
        $customerData["visitDate"]  = date('Y-m-d H:i:s');

        ModelFactory::getModel("Customer")->createData($customerData);
    }

    private function sendTheme()
    {
        if ($this->checkArray($this->getPost(), "email")) {

            $mail["email"]    = $this->getPost("email");
            $mail["name"]     = $this->firstName . " " . $this->lastName;
            $mail["subject"]  = "Thème Numérologique";
            $mail["message"]  = $this->getMessage();

            $this->sendMail($mail);

            $this->setSession([
                "message"   => "Thème Envoyé avec Succès à " . $mail["name"] . " !",
                "type"      => "green"
            ]);
        }
    }

    /**
     * @return string
     */
    private function getMessage()
    {
        $theme = implode("\R", $this->numbers);

        $message = "
            Bonjour $this->firstName $this->lastName !\n
            Voici les informations fournies :\n
            Prénom(s) : $this->firstName $this->middleName $this->thirdName\n
            Nom de Famille : $this->lastName\n
            Date de Naissance : $this->birthDate\n
            Voilà votre Thème Numérologique :\n
            $theme
        ";

        return $message;
    }
}
