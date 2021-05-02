<?php

namespace App\Manager;

/**
 * Class SynthesisInterpreter
 * @package App\Manager
 */
class SynthesisInterpreter extends MainInterpreter
{
    /**
     * @var SynthesisCalculator $synthesisCalculator
     */
    private $synthesisCalculator = null;

    /**
     * @var array $synthesisData
     */
    private $synthesisData = [];

    public function __construct()
    {
        parent::__construct();
        
        if (
            $this->checkArray($this->getPost(), "birthDate")
            && $this->checkArray($this->getPost(), "firstName")
            && $this->checkArray($this->getPost(), "lastName")
        ) {
            $this->synthesisCalculator = new SynthesisCalculator();

            $this->setPowerData();
            $this->setSpiritualData();
        }
    }

    /**
     * @return array
     */
    public function getSynthesisData()
    {
        return $this->synthesisData;
    }

     // *********************************************** \\
    // ******************** SETTERS ******************** \\

    private function setPowerData()
    {
        $powerNumbers = $this->synthesisCalculator->getSynthesisNumbers("power");

        $this->synthesisData["powerDigit"] = $this->getDigitData(
            $powerNumbers[0], 
            "power",
            "Nombre de Pouvoir"
        );

        $this->synthesisData["powerNumber"] = $this->getDoubleNumber(
            $powerNumbers[1], 
            "power"
        );
    }

    private function setSpiritualData()
    {
        $spiritualNumbers = $this->synthesisCalculator->getSynthesisNumbers("spiritual");

        $this->synthesisData["spiritualDigit"] = $this->getDigitData(
            $spiritualNumbers[0], 
            "spiritual",
            "Nombre Spirituel"
        );

        $this->synthesisData["spiritualNumber"] = $this->getQuadrupleNumber(
            $spiritualNumbers[1], 
            "spiritual"
        );
    }
}
