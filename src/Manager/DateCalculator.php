<?php

namespace App\Manager;

use DateTime;

/**
 * Class DateCalculator
 * @package App\Manager
 */
class DateCalculator extends MainCalculator
{
    /**
     * @var array
     */
    private $dateNumbers =  [];

    public function __construct()
    {
        parent::__construct();
        
        if ($this->checkArray($this->getPost(), "birthDate")) {
    
            $this->setLifePathNumbers();
            $this->setDayNumber();
            $this->setGoalNumbers();
        }
    }

    /**
     * @param string $key
     * @return array|string
     */
    public function getDateNumbers(string $key = "")
    {
        if ($key === "") {

            return $this->dateNumbers;
        }

        return $this->dateNumbers[$key] ?? "";
        
    }

     // *********************************************** \\
    // ******************** SETTERS ******************** \\

    /**
     * @return array
     */
    private function setLifePathNumbers()
    {
        $this->dateNumbers["lifePath"][1] = $this->getReducedNumber(
            $this->getBirthDate("day") + $this->getBirthDate("month") + $this->getBirthDate("year")
        );

        $this->dateNumbers["lifePath"][0] = $this->getDigitFromNumber($this->dateNumbers["lifePath"][1]);
    }

    /**
     * @return int
     */
    private function setDayNumber()
    {
        $this->dateNumbers["day"] = $this->getBirthDate("day");
    }

    /**
     * @return array
     */
    private function setGoalNumbers()
    {
        $this->dateNumbers["goal"][1] = $this->getBirthDate("day") + $this->getBirthDate("month");
        $this->dateNumbers["goal"][0] = $this->getDigitFromNumber($this->dateNumbers["goal"][1]);
    }
}
