<?php

namespace App\Controller;

use DateTime;
use Pam\Controller\MainController;

/**
 * Class CalculationManager
 * @package App\Controller\Service
 */
abstract class CalculationManager extends MainController
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
    private $fullName = [];

    /**
     * @var array
     */
    private $birthDate = [];

    /**
     * @var int
     */
    private $lifePathNumber = 0;

    /**
     * @var int
     */
    private $expressionNumber = 0;

    /**
     * @var int
     */
    private $intimateNumber = 0;

    /**
     * CalculationManager constructor
     */
    public function __construct()
    {
        parent::__construct();

        if ($this->checkArray($this->getPost())) {

            if ($this->getPost("birthDate") !== "") {
                $this->setBirthDate();
    
                if (
                    $this->getGet("access") === "theme" 
                    && $this->getPost("usualFirstName") !== "" 
                    && $this->getPost("lastName") !== ""
                ) {

                    $this->setFullName();
                }
            }
        }
    }

     // ***************************************************************** \\
    // ******************** BASIC CALCULATION SETTERS ******************** \\

    private function setBirthDate()
    {
        $birthDate = DateTime::createFromFormat(
            "Y-m-d",
            $this->getPost("birthDate")
        );

        $this->birthDate["day"]     = $birthDate->format("d");
        $this->birthDate["month"]   = $birthDate->format("m");
        $this->birthDate["year"]    = $birthDate->format("Y");

        $this->setLifePathNumber();
    }

    private function setFullName()
    {
        $this->fullName["usual"] = $this->getString(
            $this->getPost("usualFirstName"), 
            "alpha"
        );

        $this->fullName["last"] = $this->getString(
            $this->getPost("lastName"), 
            "alpha"
        );

        if ($this->getPost("middleName") !== null) {
            $this->fullName["middle"] = $this->getString(
                $this->getPost("middleName"), 
                "alpha"
            );
        }

        if ($this->getPost("thirdName") !== null) {
            $this->fullName["third"] = $this->getString(
                $this->getPost("thirdName"), 
                "alpha"
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
    private function getReducedNumber(int $number)
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
    private function getDigitFromNumber(int $number)
    {
        do {
            $number = $this->getReducedNumber($number);

        } while ($number > 9);

        return $number;
    }

     // ****************************************************************** \\
    // ******************** CALCULATED NUMBERS SETTERS ******************** \\

    private function setLifePathNumber()
    {
        $this->lifePathNumber = $this->getReducedNumber(
            $this->birthDate["day"] + 
            $this->birthDate["month"] + 
            $this->birthDate["year"]
        );
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

        $this->intimateNumber = $this->getNumberFromName(
            implode($vowels)
        );
    }

     // ************************************************************ \\
    // ******************** MAIN NUMBERS GETTERS ******************** \\

    /**
     * @return array
     */
    protected function getLifePathNumbers()
    {
        $birthDate = array_merge(
            str_split($this->birthDate["day"]), 
            str_split($this->birthDate["month"]), 
            str_split($this->birthDate["year"])
        );

        $lifePathNumber = 0;

        for ($i = 0; $i < count($birthDate); $i++) {
            $lifePathNumber += (int) $birthDate[$i];
        }

        $lifePathDigit = $this->getDigitFromNumber($this->lifePathNumber);

        return [$lifePathDigit, $this->lifePathNumber, $lifePathNumber];
    }

    /**
     * @return array
     */
    protected function getExpressionNumbers()
    {
        $expressionDigit = $this->getDigitFromNumber($this->expressionNumber);

        return [$expressionDigit, $this->expressionNumber];
    }

     // ***************************************************************** \\
    // ******************** SECONDARY NUMBERS GETTERS ******************** \\

    /**
     * @return array
     */
    protected function getIntimateNumbers() 
    {
        $intimateDigit = $this->getDigitFromNumber($this->intimateNumber);

        return [$intimateDigit, $this->intimateNumber];
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

        $realizationNumber = $this->getNumberFromName(
            implode($consonants)
        );

        $realizationDigit = $this->getDigitFromNumber($realizationNumber);

        return [$realizationDigit, $realizationNumber];
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

        return [$goalDigit, $goalNumber];
    }

    /**
     * @return array
     */
    protected function getPersonalNumbers()
    {
        $personalNumber = $this->getNumberFromName(
            $this->fullName["usual"]
        );

        $personalDigit = $this->getDigitFromNumber($personalNumber);

        return [$personalDigit, $personalNumber];
    }

    /**
     * @return array
     */
    protected function getHereditaryNumbers()
    {
        $hereditaryNumber = $this->getNumberFromName(
            $this->fullName["last"]
        );

        $hereditaryDigit = $this->getDigitFromNumber($hereditaryNumber);

        return [$hereditaryDigit, $hereditaryNumber];
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

        return [$powerDigit, $powerNumber];
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

        return [$spiritualDigit, $spiritualNumber];
    }

     // ***************************************************************** \\
    // ******************** PREDICTION NUMBERS GETTERS ******************** \\

    /**
     * @param int $year
     * @return array
     */
    protected function getPersonalYearNumbers(int $year)
    {
        $personalYearNumber = 
            $this->birthDate["day"] + 
            $this->birthDate["month"] + 
            $year;

        $personalYearDigit = $this->getDigitFromNumber($personalYearNumber);

        return [$personalYearDigit, $personalYearNumber];
    }

    /**
     * @param int $month
     * @param int $year
     * @return array
     */
    protected function getPersonalMonthNumbers(int $month, int $year)
    {
        $personalMonthNumber    = $this->getPersonalYearNumbers($year) + $month;
        $personalMonthDigit     = $this->getDigitFromNumber($personalMonthNumber);

        return [$personalMonthDigit, $personalMonthNumber];
    }

    /**
     * @param int $day
     * @param int $month
     * @param int $year
     * @return array
     */
    protected function getPersonalDayNumbers(int $day, int $month, int $year)
    {
        $personalDayNumber  = $this->getPersonalMonthNumbers($month, $year) + $day;
        $personalDayDigit   = $this->getDigitFromNumber($personalDayNumber);

        return [$personalDayDigit, $personalDayNumber];
    }
}
