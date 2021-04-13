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
     * @var string
     */
    private $usualFirstName = "";

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
     * @var int
     */
    private $day = 13;

    /**
     * @var int
     */
    private $month = 6;

    /**
     * @var int
     */
    private $year = 1977;

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
     * CalculationController constructor
     */
    public function __construct()
    {
        parent::__construct();

        if (!empty($this->getPost()->getPostArray())) {
            $this->day      = $this->getPost()->getPostVar("day");
            $this->month    = $this->getPost()->getPostVar("month");
            $this->year     = $this->getPost()->getPostVar("year");

            if ($this->getGet()->getGetVar("access") === "theme") {
                $this->usualFirstName   = $this->getPost()->getPostVar("usual-first-name");
                $this->middleName       = $this->getPost()->getPostVar("middle-name");
                $this->thirdName        = $this->getPost()->getPostVar("third-name");
                $this->lastName         = $this->getPost()->getPostVar("last-name");
            } 
        }

        var_dump($this->getAstralNumber());die;
    }

    /**
     * @param string $name
     * @return int
     */
    private function getNumberFromName(string $name)
    {
        $number = 0;
        $name   = str_split($name);

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
        $digit  = 0;
        $number = str_split($number);

        for ($i = 0; $i < count($number); $i++) {
            $digit += $number[$i];            
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
            $digit  = 0;
            $number = str_split($number);
    
            for ($i = 0; $i < count($number); $i++) {
                $digit += $number[$i];            
            }

            $number = $digit;

        } while ($number > 9);


        return $digit;
    }

    // MAIN NUMBERS

    /**
     * @return int
     */
    protected function getExpressionNumber()
    {
        // TODO: add full name
    }

    /**
     * @return int
     */
    protected function getSoulNumber() 
    {
        // TODO: add full name vowels
    }

    /**
     * @return int
     */
    protected function getAstralNumber()
    {
        $astralNumber = 
            array_merge(
                str_split($this->day), 
                str_split($this->month), 
                str_split($this->year), 
            );

        $astralSplitNumber = 0;

        for ($i = 0; $i < count($astralNumber); $i++) {
            $astralSplitNumber += $astralNumber[$i];
        }

        $astralReduceNumber = 
            $this->getReducedNumber($this->day + $this->month + $this->year);

        $astralDigit = $this->getDigitFromNumber($astralSplitNumber);

        return [$astralSplitNumber, $astralReduceNumber, $astralDigit];
    }

    /**
     * @return int
     */
    protected function getDayNumber()
    {
        return $this->day;
    }

    // SECONDARY NUMBERS

    /**
     * @return int
     */
    protected function getRealizationNumber()
    {
        // TODO: add full name consonants
    }

    /**
     * @return int
     */
    protected function getPersonalNumber()
    {
        return $this->getDigitFromNumber($this->getNumberFromName($this->usualFirstName));
    }

    /**
     * @return int
     */
    protected function getHereditaryNumber()
    {
        return $this->getDigitFromNumber($this->getNumberFromName($this->lastName));
    }

    /**
     * @return int
     */
    protected function getChallengeNumbers()
    {
        // TODO: 1 -> remove month to day 
        // TODO: 2 -> remove day to year
        // TODO: 3 -> remove 1 to 2
    }

    /**
     * @return int
     */
    protected function getGoalNumber()
    {
        return $this->day + $this->month;
    }

    /**
     * @return int
     */
    protected function getKarmaNumber()
    {
        // TODO: search missing number in the 2 first names + last name
    }

    /**
     * @return int
     */
    protected function getPassionNumber()
    {
        // TODO: search dominant number in the 2 first names + last name
    }

    // SYNTHESIS NUMBERS

    /**
     * @return int
     */
    protected function getPowerNumber()
    {
        return  $this->getAstralNumber() + 
                $this->getExpressionNumber();
    }

    /**
     * @return int
     */
    protected function getSpiritualNumber()
    {
        return  $this->getAstralNumber() + 
                $this->getExpressionNumber() + 
                $this->getSoulNumber() + 
                $this->getDayNumber();
    }
}
