<?php

namespace App\Manager;

/**
 * Class DateInterpreter
 * @package App\Manager
 */
class DateInterpreter extends InterpretationManager
{
    /**
     * @var DateCalculator $dateCalculator
     */
    private $dateCalculator = null;

    /**
     * @var array $dateData
     */
    private $dateData = [];

    /**
     * Set all Interpretation Data from Date
     */
    public function __construct()
    {
        $this->dateCalculator = new DateCalculator();

        if ($this->checkArray($this->getPost(), "birthDate")) {
            
            $this->setLifePathData();       
            $this->setDayData();       
            $this->setGoalData();
        }
    }

    /**
     * Return all Interpretation Data from Date
     * @return array
     */
    public function getDateData()
    {
        return $this->dateData;
    }

     // *********************************************** \\
    // ******************** SETTERS ******************** \\

    /**
     * Set Interpretation of LifePath Numbers to Date Data
     */
    private function setLifePathData()
    {
        $lifePathNumbers = $this->dateCalculator->getLifePathNumbers();

        $this->dateData["lifePathDigit"] = $this->getDigitData(
            $lifePathNumbers, 
            "lifePath", 
            "Chemin de Vie"
        );

        $this->dateData["lifePathNumber"] = $this->getQuadrupleNumber(
            $lifePathNumbers[1], 
            "lifePath"
        );
    }

    /**
     * Set Interpretation of Day Number to Date Data
     */
    private function setDayData()
    {
        $dayNumber = $this->dateCalculator->getDayNumber();
       
        $this->dateData["dayNumber"] = 
            "Nombre du Jour " . $dayNumber . " : " .
            $this->allNumbers[$dayNumber - 1]["day"];
    }

    /**
     * Set Interpretation of Goal Numbers to Date Data
     */
    private function setGoalData()
    {
        $goalNumbers = $this->dateCalculator->getGoalNumbers();

        $this->dateData["goalDigit"] = $this->getDigitData(
            $goalNumbers, 
            "goal",
            "Nombre du But"
        );

        $this->dateData["goalNumber"] = $this->getTripleNumber(
            $goalNumbers[1], 
            "goal"
        );
    }
}
