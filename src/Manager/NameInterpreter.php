<?php

namespace App\Manager;

/**
 * Class NameInterpreter
 * @package App\Manager
 */
class NameInterpreter extends InterpretationManager
{
    /**
     * @var NameCalculator $nameCalculator
     */
    private $nameCalculator = null;

    /**
     * @var array $nameData
     */
    private $nameData = [];

    /**
     * Set all Interpretation Data from Name
     */
    public function __construct()
    {
        $this->nameCalculator = new NameCalculator();

        if (
            $this->checkArray($this->getPost(), "firstName")
            && $this->checkArray($this->getPost(), "lastName")
        ) {
            $this->setExpressionData();
            $this->setIntimateData();
            $this->setRealizationData();
            $this->setPersonalData();       
            $this->setHereditaryData();
        } 
    }

    /**
     * Return all Interpretation Data from Name
     * @return array
     */
    public function getNameData()
    {
        return $this->nameData;
    }

     // *********************************************** \\
    // ******************** SETTERS ******************** \\

    /**
     * Set Interpretation of Expression Numbers to Name Data
     */
    private function setExpressionData()
    {
        $expressionNumbers = $this->nameCalculator->getExpressionNumbers();

        $this->nameData["expressionDigit"] = $this->getDigitData(
            $expressionNumbers, 
            "expression", 
            "Nombre d'Expression"
        );

        $this->nameData["expressionNumber"] = $this->getDoubleNumber(
            $expressionNumbers[1], 
            "expression"
        );
    }

    /**
     * Set Interpretation of Intimate Numbers to Name Data
     */
    private function setIntimateData()
    {
        $intimateNumbers = $this->nameCalculator->getIntimateNumbers();

        $this->nameData["intimateDigit"] = $this->getDigitData(
            $intimateNumbers, 
            "intimate",
            "Nombre Intime"
        );

        $this->nameData["intimateNumber"] = $this->getDoubleNumber(
            $intimateNumbers[1], 
            "intimate"
        );
    }

    /**
     * Set Interpretation of Realization Numbers to Name Data
     */
    private function setRealizationData()
    {
        $realizationNumbers = $this->nameCalculator->getRealizationNumbers();

        $this->nameData["realizationDigit"] = $this->getDigitData(
            $realizationNumbers, 
            "realization",
            "Nombre de Réalisation"
        );

        $this->nameData["realizationNumber"] = $this->getDoubleNumber(
            $realizationNumbers[1], 
            "realization"
        );
    }

    /**
     * Set Interpretation of Personal Numbers to Name Data
     */
    private function setPersonalData()
    {
        $personalNumbers = $this->nameCalculator->getPersonalNumbers();

        $this->nameData["personalDigit"] = $this->getDigitData(
            $personalNumbers, 
            "personal",
            "Nombre Personnel"
        );

        $this->nameData["personalNumber"] = $this->getSimpleNumber(
            $personalNumbers[1], 
            "personal"
        );        
    }

    /**
     * Set Interpretation of Hereditary Numbers to Name Data
     */
    private function setHereditaryData()
    {
        $hereditaryNumbers = $this->nameCalculator->getHereditaryNumbers();

        $this->nameData["hereditaryDigit"] = $this->getDigitData(
            $hereditaryNumbers, 
            "hereditary",
            "Nombre Héréditaire"
        );

        $this->nameData["hereditaryNumber"] = $this->getSimpleNumber(
            $hereditaryNumbers[1], 
            "hereditary"
        );
    }
}
