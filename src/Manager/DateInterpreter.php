<?php

namespace App\Manager;

/**
 * Class DateInterpreter
 * @package App\Manager
 */
class DateInterpreter extends MainInterpreter
{
    /**
     * @var DateCalculator $dateCalculator
     */
    private $dateCalculator = null;

    /**
     * @var array $dateData
     */
    private $dateData = [];

    public function __construct()
    {
        parent::__construct();
        
        if ($this->checkArray($this->getPost(), "birthDate")) {
            $this->dateCalculator = new DateCalculator();
            
            $this->setLifePathData();       
            $this->setDayData();       
            $this->setGoalData();
        }
    }

    /**
     * @return array
     */
    public function getDateData()
    {
        return $this->dateData;
    }

     // *********************************************** \\
    // ******************** SETTERS ******************** \\

    private function setLifePathData()
    {
        $lifePathNumbers = $this->dateCalculator->getDateNumbers("lifePath");

        $this->dateData["lifePathDigit"] = $this->getDigitData(
            $lifePathNumbers[0], 
            "lifePath", 
            "Chemin de Vie"
        );

        $this->dateData["lifePathNumber"] = $this->getQuadrupleNumber(
            $lifePathNumbers[1], 
            "lifePath"
        );
    }

    private function setDayData()
    {
        $dayNumber = $this->dateCalculator->getDateNumbers("day");
      
        $this->dateData["dayNumber"] = $this->getDigitData(
            $dayNumber,
            "day",
            "Nombre du Jour"
        );
    }

    private function setGoalData()
    {
        $goalNumbers = $this->dateCalculator->getDateNumbers("goal");

        $this->dateData["goalDigit"] = $this->getDigitData(
            $goalNumbers[0], 
            "goal",
            "Nombre du But"
        );

        $this->dateData["goalNumber"] = $this->getTripleNumber(
            $goalNumbers[1], 
            "goal"
        );
    }
}
