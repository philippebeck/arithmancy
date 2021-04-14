<?php

namespace App\Controller;

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
        "z" => 8];

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
    private $astralNumber = null;

    /**
     * @var int
     */
    private $expressionNumber = null;

        /**
     * @var int
     */
    private $soulNumber = null;

    /**
     * CalculationController constructor
     */
    public function __construct()
    {
        parent::__construct();

        if (!empty($this->getPost()->getPostArray())) {
            $this->birthDate["day"]     = (int) trim($this->getPost()->getPostVar("day"));
            $this->birthDate["month"]   = (int) trim($this->getPost()->getPostVar("month"));
            $this->birthDate["year"]    = (int) trim($this->getPost()->getPostVar("year"));

            if ($this->getGet()->getGetVar("access") === "theme") {
                $this->fullName["usual"]    = (string) trim($this->getPost()->getPostVar("usual-first-name"));
                $this->fullName["middle"]   = (string) trim($this->getPost()->getPostVar("middle-name"));
                $this->fullName["third"]    = (string) trim($this->getPost()->getPostVar("third-name"));
                $this->fullName["last"]     = (string) trim($this->getPost()->getPostVar("last-name"));
            }
        }
    }

    // ******************** BASIC CALCULATIONS ******************** \\

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
        $digit  = 0;

        for ($i = 0; $i < count($numbers); $i++) {
            $digit += (int) $numbers[$i];            
        }

        return $digit;
    }

    /**
     * @param int $number
     * @return int
     */
    private function getDigitFromNumber($number)
    {
        do {
            $numbers = str_split((string) $number);
            $digit  = 0;
    
            for ($i = 0; $i < count($numbers); $i++) {
                $digit += (int) $numbers[$i];            
            }

            $number = $digit;

        } while ($number > 9);

        return $digit;
    }

    // ******************** MAIN NUMBERS ******************** \\

    /**
     * @return array
     */
    protected function getAstralNumbers()
    {
        $birthDate = 
            array_merge(
                str_split($this->birthDate["day"]), 
                str_split($this->birthDate["month"]), 
                str_split($this->birthDate["year"])
            );

        for ($i = 0; $i < count($birthDate); $i++) {
            $this->astralNumber += $birthDate[$i];
        }

        $astralReduceNumber = 
            $this->getReducedNumber(
                $this->birthDate["day"] + 
                $this->birthDate["month"] + 
                $this->birthDate["year"]
            );

        $astralDigit = $this->getDigitFromNumber($this->astralNumber);

        return [$this->astralNumber, $astralReduceNumber, $astralDigit];
    }

    /**
     * @return array
     */
    protected function getExpressionNumbers()
    {
        $usualFirstName = $this->getNumberFromName($this->fullName["usual"]);
        $middleName     = $this->getNumberFromName($this->fullName["middle"]);
        $thirdName      = $this->getNumberFromName($this->fullName["third"]);
        $lastName       = $this->getNumberFromName($this->fullName["last"]);

        $this->expressionNumber = $usualFirstName + $middleName + $thirdName + $lastName;
        $expressionDigit        = $this->getDigitFromNumber($this->expressionNumber);

        return [$this->expressionNumber, $expressionDigit];
    }

    /**
     * @return array
     */
    protected function getSoulNumbers() 
    {
        $fullName = 
            array_merge(
                str_split($this->fullName["usual"]), 
                str_split($this->fullName["middle"]), 
                str_split($this->fullName["third"]), 
                str_split($this->fullName["last"]), 
            );

        $vowels = [];

        for ($i = 0; $i < count($fullName); $i++) {

            if (in_array($fullName[$i], self::VOWELS)) {
                array_push($vowels, $fullName[$i]);    
            }         
        }

        $soulNumber = $this->getNumberFromName(implode($vowels));
        $soulDigit  = $this->getDigitFromNumber($soulNumber);

        return [$soulNumber, $soulDigit];
    }

    /**
     * @return int
     */
    protected function getDayNumber()
    {
        return $this->birthDate["day"];
    }

    // ******************** SECONDARY NUMBERS ******************** \\

    /**
     * @return array
     */
    protected function getRealizationNumbers()
    {
        $fullName = 
            array_merge(
                str_split($this->fullName["usual"]), 
                str_split($this->fullName["middle"]), 
                str_split($this->fullName["third"]), 
                str_split($this->fullName["last"]), 
            );

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

    /**
     * @return array
     */
    protected function getGoalNumbers()
    {
        $goalNumber = $this->birthDate["day"] + $this->birthDate["month"];
        $goalDigit  = $this->getDigitFromNumber($goalNumber);

        return [$goalNumber, $goalDigit];
    }

    // ******************** PARTICULAR NUMBERS ******************** \\

    /**
     * @return array
     */
    protected function getChallengeNumbers()
    {
        // TODO: 1 -> remove month to day 
        // TODO: 2 -> remove day to year
        // TODO: 3 -> remove 1 to 2
    }

    /**
     * @return array
     */
    protected function getKarmaNumbers()
    {
        // TODO: search missing number in the 2 first names + last name
    }

    /**
     * @return array
     */
    protected function getPassionNumbers()
    {
        // TODO: search dominant number in the 2 first names + last name
    }

    // ******************** SYNTHESIS NUMBERS ******************** \\

    /**
     * @return array
     */
    protected function getPowerNumbers()
    {
        $this->getAstralNumbers();
        $this->getExpressionNumbers();

        $powerNumber    = $this->astralNumber + $this->expressionNumber;
        $powerDigit     = $this->getDigitFromNumber($powerNumber);

        return [$powerNumber, $powerDigit];
    }

    /**
     * @return array
     */
    protected function getSpiritualNumbers()
    {
        $this->getAstralNumbers();
        $this->getExpressionNumbers();
        $this->getSoulNumbers();

        $spiritualNumber = 
            $this->astralNumber + 
            $this->expressionNumber + 
            $this->soulNumber + 
            $this->birthDate["day"];

        $spiritualDigit = $this->getDigitFromNumber($spiritualNumber);

        return [$spiritualNumber, $spiritualDigit];
    }
}
