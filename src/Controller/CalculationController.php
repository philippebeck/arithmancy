<?php

namespace App\Controller;

use DateTime;
use Pam\Controller\MainController;

/**
 * Class CalculationController
 * @package App\Controller
 */
abstract class CalculationController extends MainController
{
    /**
     * @var array
     */
    private const VOWELS = ["a", "e", "i", "o", "u", "y"];

    /**
     * @var array
     */
    private const TRIPOLI = [
        "a" => 1, 
        "b" => 2,
        "c" => 3,
        "d" => 4,
        "e" => 5,
        "f" => 6,
        "g" => 7,
        "h" => 8,
        "i" => 9,
        "j" => 1,
        "k" => 2,
        "l" => 3,
        "m" => 4,
        "n" => 5,
        "o" => 6,
        "p" => 7,
        "q" => 8,
        "r" => 9,
        "s" => 1,
        "t" => 2,
        "u" => 3,
        "v" => 4,
        "w" => 5,
        "x" => 6,
        "y" => 7,
        "z" => 8
    ];

    /**
     * @var array
     */
    private array $fullName = [];

    /**
     * @var array
     */
    private array $birthDate = [];

    /**
     * @var int
     */
    private int $lifePathNumber = 0;

    /**
     * @var int
     */
    private int $expressionNumber = 0;

    /**
     * @var int
     */
    private int $intimateNumber = 0;

    /**
     * CalculationController constructor
     */
    public function __construct()
    {
        parent::__construct();

        if (!empty($this->getPost()->getPostArray())) {
            $this->setBirthDate();

            if ($this->getGet()->getGetVar("access") === "theme") {
                $this->setFullName();
            }
        }
    }

    private function setBirthDate()
    {
        $birthDate = DateTime::createFromFormat(
            "Y-m-d",
            $this->getPost()->getPostVar("birthdate")
        );

        $this->birthDate["day"]     = $birthDate->format("d");
        $this->birthDate["month"]   = $birthDate->format("m");
        $this->birthDate["year"]    = $birthDate->format("Y");

        $this->setLifePathNumber();
    }

    private function setFullName()
    {
        $this->fullName["usual"] = $this->getString()->cleanString(
            $this->getPost()->getPostVar("usual-first-name"), "alpha"
        );

        $this->fullName["last"] = $this->getString()->cleanString(
            $this->getPost()->getPostVar("last-name"), "alpha"
        );

        if ($this->getPost()->getPostVar("middle-name") !== null) {
            $this->fullName["middle"] = $this->getString()->cleanString(
                $this->getPost()->getPostVar("middle-name"), "alpha"
            );
        }

        if ($this->getPost()->getPostVar("third-name") !== null) {
            $this->fullName["third"] = $this->getString()->cleanString(
                $this->getPost()->getPostVar("third-name"), "alpha"
            );
        }

        $this->setExpressionNumber();
        $this->setIntimateNumber();
    }

     // ****************************************************************** \\
    // ******************** BASIC CALCULATIONS GETTERS ******************** \\

    /**
     * @return array
     */
    private function getFullNameLetters()
    {
        return array_merge(
            str_split($this->fullName["usual"]), 
            str_split($this->fullName["middle"]), 
            str_split($this->fullName["third"]), 
            str_split($this->fullName["last"])
        );
    }

    /**
     * @param string $name
     * @return int
     */
    private function getNumberFromName(string $name)
    {
        $name   = str_split($name);
        $number = 0;

        for ($i = 0; $i < count($name); $i++) {
            $number += self::TRIPOLI[$name[$i]];            
        }

        return $number;
    }

    /**
     * @param int $number
     * @return int
     */
    private function getReducedNumber($number)
    {
        $numbers = str_split((string) $number);
        $number  = 0;

        for ($i = 0; $i < count($numbers); $i++) {
            $number += (int) $numbers[$i];            
        }

        return $number;
    }

    /**
     * @param int $number
     * @return int
     */
    private function getDigitFromNumber($number)
    {
        do {
            $number = $this->getReducedNumber($number);

        } while ($number > 9);

        return $number;
    }

     // ******************************************************************* \\
    // ****************************** SETTERS ****************************** \\

    private function setLifePathNumber()
    {
        $birthDate = array_merge(
            str_split($this->birthDate["day"]), 
            str_split($this->birthDate["month"]), 
            str_split($this->birthDate["year"])
        );

        for ($i = 0; $i < count($birthDate); $i++) {
            $this->lifePathNumber += (int) $birthDate[$i];
        }
    }

    private function setExpressionNumber()
    {
        $this->expressionNumber = $this->getNumberFromName(
            implode($this->getFullNameLetters())
        );
    }

    private function setIntimateNumber()
    {
        $fullName   = $this->getFullNameLetters();
        $vowels     = [];

        for ($i = 0; $i < count($fullName); $i++) {

            if (in_array($fullName[$i], self::VOWELS)) {
                array_push($vowels, $fullName[$i]);    
            }         
        }

        $this->intimateNumber = $this->getNumberFromName(implode($vowels));
    }

     // ************************************************************ \\
    // ******************** MAIN NUMBERS GETTERS ******************** \\

    /**
     * @return array
     */
    protected function getLifePathNumbers()
    {
        $lifePathReduceNumber = $this->getReducedNumber(
            $this->birthDate["day"] + 
            $this->birthDate["month"] + 
            $this->birthDate["year"]
        );

        $lifePathDigit = $this->getDigitFromNumber($this->lifePathNumber);

        return [$this->lifePathNumber, $lifePathReduceNumber, $lifePathDigit];
    }

    /**
     * @return array
     */
    protected function getExpressionNumbers()
    {
        $expressionDigit = $this->getDigitFromNumber($this->expressionNumber);

        return [$this->expressionNumber, $expressionDigit];
    }

     // ***************************************************************** \\
    // ******************** SECONDARY NUMBERS GETTERS ******************** \\

    /**
     * @return array
     */
    protected function getIntimateNumbers() 
    {
        $intimateDigit = $this->getDigitFromNumber($this->intimateNumber);

        return [$this->intimateNumber, $intimateDigit];
    }

    /**
     * @return array
     */
    protected function getRealizationNumbers()
    {
        $fullName   = $this->getFullNameLetters();
        $consonants = [];

        for ($i = 0; $i < count($fullName); $i++) {

            if (!in_array($fullName[$i], self::VOWELS)) {
                array_push($consonants, $fullName[$i]);    
            }         
        }

        $realizationNumber  = $this->getNumberFromName(implode($consonants));
        $realizationDigit   = $this->getDigitFromNumber($realizationNumber);

        return [$realizationNumber, $realizationDigit];
    }

    /**
     * @return int
     */
    protected function getDayNumber()
    {
        return $this->birthDate["day"];
    }

    /**
     * @return array
     */
    protected function getGoalNumbers()
    {
        $goalNumber = $this->birthDate["day"] + $this->birthDate["month"];
        $goalDigit  = $this->getDigitFromNumber($goalNumber);

        return [$goalNumber, $goalDigit];
    }

    /**
     * @return array
     */
    protected function getPersonalNumbers()
    {
        $personalNumber = $this->getNumberFromName($this->fullName["usual"]);
        $personalDigit  = $this->getDigitFromNumber($personalNumber);

        return [$personalNumber, $personalDigit];
    }

    /**
     * @return array
     */
    protected function getHereditaryNumbers()
    {
        $hereditaryNumber   = $this->getNumberFromName($this->fullName["last"]);
        $hereditaryDigit    = $this->getDigitFromNumber($hereditaryNumber);

        return [$hereditaryNumber, $hereditaryDigit];
    }

     // ***************************************************************** \\
    // ******************** SYNTHESIS NUMBERS GETTERS ******************** \\

    /**
     * @return array
     */
    protected function getPowerNumbers()
    {
        $powerNumber    = $this->lifePathNumber + $this->expressionNumber;
        $powerDigit     = $this->getDigitFromNumber($powerNumber);

        return [$powerNumber, $powerDigit];
    }

    /**
     * @return array
     */
    protected function getSpiritualNumbers()
    {
        $spiritualNumber = 
            $this->lifePathNumber + 
            $this->expressionNumber + 
            $this->intimateNumber + 
            $this->birthDate["day"];

        $spiritualDigit = $this->getDigitFromNumber($spiritualNumber);

        return [$spiritualNumber, $spiritualDigit];
    }
}
