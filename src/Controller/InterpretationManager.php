<?php

namespace App\Controller;

use Pam\Model\ModelFactory;

/**
 * Class InterpretationManager
 * @package App\Controller\Service
 */
abstract class InterpretationManager extends CalculationManager
{
    /**
     * @var array
     */
    protected $numbers = [];

    /**
     * @var array
     */
    private $allNumbers = [];

    /**
     * InterpretationManager constructor
     */
    public function __construct()
    {
        parent::__construct();

        if ($this->checkArray($this->getPost())) {

            if ($this->getPost("birthDate") !== "") {
                $this->allNumbers = ModelFactory::getModel("Number")->listData();

                $this->setLifePathData();

                if (
                    $this->getGet("access") === "theme"
                    && $this->getPost("usualFirstName") !== ""
                    && $this->getPost("lastName") !== ""
                ) {
                    $this->setExpressionData();
                    $this->setIntimateData();
                    $this->setRealizationData();       
                    $this->setDayData();       
                    $this->setGoalData();       
                    $this->setPersonalData();       
                    $this->setHereditaryData();       
                    $this->setPowerData();       
                    $this->setSpiritualData();
                }
            }
        }
    }

    /**
     * @param array $numbers
     * @param string $category
     */
    private function setNumberData(
        array $numbers,
        string $category,
        string $name)
    {
        $this->numbers[$category . "Digit"] = 
            $name . " " . $numbers[0] . " : " .
            $this->allNumbers[$numbers[0] - 1][$category];
    }

     // ******************************************************* \\
    // ******************** NUMBER CHECKERS ******************** \\

    /**
     * @param int $number
     * @param string $category
     * @param string $suffix
     */
    private function checkSimpleNumber(
        int $number, 
        string $category,
        string $suffix = "Number")
    {
        if ($number < 79) {

            $this->numbers[$category . $suffix] = 
                $number . " : " .
                $this->allNumbers[$number - 1]["description"];
        }  
    }

    /**
     * @param int $number
     * @param string $category
     * @param string $suffix
     */
    private function checkDoubleNumber(
        int $number, 
        string $category,
        string $suffix = "Number")
    {
        if ($number < 79) {
            if ($number === 11 || $number === 22) {

                $this->numbers[$category . $suffix] = 
                    $number . " : " .
                    $this->allNumbers[$number - 1][$category];

            } else {
                $this->numbers[$category . $suffix] = 
                    $number . " : " .
                    $this->allNumbers[$number - 1]["description"];
            }
        }
    }

    /**
     * @param int $number
     * @param string $category
     * @param string $suffix
     */
    private function checkTripleNumber(
        int $number, 
        string $category,
        string $suffix = "Number")
    {
        if ($number < 79) {
            if ($number === 11 || $number === 22 || $number === 33) {

                $this->numbers[$category . $suffix] = 
                    $number . " : " .
                    $this->allNumbers[$number - 1][$category];

            } else {
                $this->numbers[$category . $suffix] = 
                    $number . " : " .
                    $this->allNumbers[$number - 1]["description"];
            }
        }
    }

    /**
     * @param int $number
     * @param string $category
     * @param string $suffix
     */
    private function checkQuadrupleNumber(
        int $number, 
        string $category,
        string $suffix = "Number")
    {
        if ($number < 79) {
            if ($number === 11 || $number === 22 || $number === 33 || $number === 44) {

                $this->numbers[$category . $suffix] = 
                    $number . " : " .
                    $this->allNumbers[$number - 1][$category];

            } else {
                $this->numbers[$category . $suffix] = 
                    $number . " : " .
                    $this->allNumbers[$number - 1]["description"];
            }
        }
    }

     // *********************************************************** \\
    // ******************** NUMBER DATA SETTERS ******************** \\

    protected function setLifePathData()
    {
        $lifePathNumbers = $this->getLifePathNumbers();

        $this->setNumberData(
            $lifePathNumbers, 
            "lifePath", 
            "Chemin de Vie"
        );

        $this->checkQuadrupleNumber(
            $lifePathNumbers[1], 
            "lifePath"
        );

        if ($lifePathNumbers[1] !== $lifePathNumbers[2]) {
            $this->checkQuadrupleNumber(
                $lifePathNumbers[2], 
                "lifePath", 
                "SecondNumber"
            );
        }
    }

    protected function setExpressionData()
    {
        $expressionNumbers = $this->getExpressionNumbers();

        $this->setNumberData(
            $expressionNumbers, 
            "expression", 
            "Nombre d'Expression"
        );

        $this->checkDoubleNumber(
            $expressionNumbers[1], 
            "expression"
        );
    }

    protected function setIntimateData()
    {
        $intimateNumbers = $this->getIntimateNumbers();

        $this->setNumberData(
            $intimateNumbers, 
            "intimate",
            "Nombre Intime"
        );

        $this->checkDoubleNumber(
            $intimateNumbers[1], 
            "intimate"
        );
    }

    protected function setRealizationData()
    {
        $realizationNumbers = $this->getRealizationNumbers();

        $this->setNumberData(
            $realizationNumbers, 
            "realization",
            "Nombre de Réalisation"
        );

        $this->checkDoubleNumber(
            $realizationNumbers[1], 
            "realization"
        );
    }

    protected function setDayData()
    {
        $dayNumber = $this->getDayNumber();
       
        $this->numbers["dayNumber"] = 
            "Nombre du Jour " . $dayNumber . " : " .
            $this->allNumbers[$dayNumber - 1]["day"];
    }

    protected function setGoalData()
    {
        $goalNumbers = $this->getGoalNumbers();

        $this->setNumberData(
            $goalNumbers, 
            "goal",
            "Nombre du But"
        );

        $this->checkTripleNumber(
            $goalNumbers[1], 
            "goal"
        );
    }

    protected function setPersonalData()
    {
        $personalNumbers = $this->getPersonalNumbers();

        $this->setNumberData(
            $personalNumbers, 
            "personal",
            "Nombre Personnel"
        );

        $this->checkSimpleNumber(
            $personalNumbers[1], 
            "personal"
        );        
    }

    protected function setHereditaryData()
    {
        $hereditaryNumbers = $this->getHereditaryNumbers();

        $this->setNumberData(
            $hereditaryNumbers, 
            "hereditary",
            "Nombre Héréditaire"
        );

        $this->checkSimpleNumber(
            $hereditaryNumbers[1], 
            "hereditary"
        );
    }

    protected function setPowerData()
    {
        $powerNumbers = $this->getPowerNumbers();

        $this->setNumberData(
            $powerNumbers, 
            "power",
            "Nombre de Pouvoir"
        );

        $this->checkDoubleNumber(
            $powerNumbers[1], 
            "power"
        );
    }

    protected function setSpiritualData()
    {
        $spiritualNumbers = $this->getSpiritualNumbers();

        $this->setNumberData(
            $spiritualNumbers, 
            "spiritual",
            "Nombre Spirituel"
        );

        $this->checkQuadrupleNumber(
            $spiritualNumbers[1], 
            "spiritual"
        );
    }
}
