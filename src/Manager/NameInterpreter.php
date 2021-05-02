<?php

namespace App\Manager;

/**
 * Class NameInterpreter
 * @package App\Manager
 */
class NameInterpreter extends MainInterpreter
{
    /**
     * @var NameCalculator $nameCalculator
     */
    private $nameCalculator = null;

    /**
     * @var array $nameData
     */
    private $nameData = [];

    public function __construct()
    {
        parent::__construct();
       
        if (
            $this->checkArray($this->getPost(), "firstName")
            && $this->checkArray($this->getPost(), "lastName")
        ) {
            $this->nameCalculator = new NameCalculator();
            
            $this->setExpressionData();
            $this->setIntimateData();
            $this->setRealizationData();
            $this->setPersonalData();       
            $this->setHereditaryData();
        } 
    }

    /**
     * @return array
     */
    public function getNameData()
    {
        return $this->nameData;
    }

     // *********************************************** \\
    // ******************** SETTERS ******************** \\

    private function setExpressionData()
    {
        $expressionNumbers = $this->nameCalculator->getNameNumbers("expression");

        $this->nameData["expressionDigit"] = $this->getDigitData(
            $expressionNumbers[0], 
            "expression", 
            "Nombre d'Expression"
        );

        $this->nameData["expressionNumber"] = $this->getDoubleNumber(
            $expressionNumbers[1], 
            "expression"
        );
    }

    private function setIntimateData()
    {
        $intimateNumbers = $this->nameCalculator->getNameNumbers("intimate");

        $this->nameData["intimateDigit"] = $this->getDigitData(
            $intimateNumbers[0], 
            "intimate",
            "Nombre Intime"
        );

        $this->nameData["intimateNumber"] = $this->getDoubleNumber(
            $intimateNumbers[1], 
            "intimate"
        );
    }

    private function setRealizationData()
    {
        $realizationNumbers = $this->nameCalculator->getNameNumbers("realization");

        $this->nameData["realizationDigit"] = $this->getDigitData(
            $realizationNumbers[0], 
            "realization",
            "Nombre de Réalisation"
        );

        $this->nameData["realizationNumber"] = $this->getDoubleNumber(
            $realizationNumbers[1], 
            "realization"
        );
    }

    private function setPersonalData()
    {
        $personalNumbers = $this->nameCalculator->getNameNumbers("personal");

        $this->nameData["personalDigit"] = $this->getDigitData(
            $personalNumbers[0], 
            "personal",
            "Nombre Personnel"
        );

        $this->nameData["personalNumber"] = $this->getSimpleNumber(
            $personalNumbers[1], 
            "personal"
        );        
    }

    private function setHereditaryData()
    {
        $hereditaryNumbers = $this->nameCalculator->getNameNumbers("hereditary");

        $this->nameData["hereditaryDigit"] = $this->getDigitData(
            $hereditaryNumbers[0], 
            "hereditary",
            "Nombre Héréditaire"
        );

        $this->nameData["hereditaryNumber"] = $this->getSimpleNumber(
            $hereditaryNumbers[1], 
            "hereditary"
        );
    }
}
