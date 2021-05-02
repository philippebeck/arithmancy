<?php

namespace App\Manager;

/**
 * Class NameCalculator
 * @package App\Manager
 */
class NameCalculator extends MainCalculator
{
    /**
     * @var array
     */
    private const VOWELS = ["a", "e", "i", "o", "u", "y"];

    /**
     * @var array
     */
    private $fullLetters =  [];

    /**
     * @var array
     */
    private $nameNumbers =  [];

    public function __construct()
    {
        parent::__construct();
        
        if (
            $this->checkArray($this->getPost(), "firstName")
            && $this->checkArray($this->getPost(), "lastName")
        ) {
            $this->fullLetters = $this->getFullNameLetters();
            
            $this->setExpressionNumbers();
            $this->setIntimateNumbers();
            $this->setRealizationNumbers();
            $this->setPersonalNumbers();
            $this->setHereditaryNumbers();
        }
    }

    /**
     * @param string $key
     * @return array|string
     */
    public function getNameNumbers(string $key = "")
    {
        if ($key === "") {

            return $this->nameNumbers;
        }

        return $this->nameNumbers[$key] ?? "";
        
    }

     // *********************************************** \\
    // ******************** SETTERS ******************** \\

    private function setExpressionNumbers()
    {
        $this->nameNumbers["expression"][1] = $this->getNumberFromName(implode($this->fullLetters));
        $this->nameNumbers["expression"][0] = $this->getDigitFromNumber($this->expressionNumber[1]);
    }

    private function setIntimateNumbers() 
    {
        $vowels = [];

        for ($i = 0; $i < count($this->fullLetters); $i++) {

            if (in_array($this->fullLetters[$i], self::VOWELS)) {
                array_push($vowels, $this->fullLetters[$i]);    
            }         
        }

        $this->nameNumbers["intimate"][1]   = $this->getNumberFromName(implode($vowels));
        $this->nameNumbers["intimate"][0]   = $this->getDigitFromNumber($this->intimateNumber[1]);
    }

    private function setRealizationNumbers()
    {
        $consonants = [];

        for ($i = 0; $i < count($this->fullLetters); $i++) {

            if (!in_array($this->fullLetters[$i], self::VOWELS)) {
                array_push($consonants, $this->fullLetters[$i]);    
            }         
        }

        $this->nameNumbers["realization"][1]    = $this->getNumberFromName(implode($consonants));
        $this->nameNumbers["realization"][0]    = $this->getDigitFromNumber($this->realizationNumber[1]);
    }

    private function setPersonalNumbers()
    {
        $this->nameNumbers["personal"][1]   = $this->getNumberFromName($this->getFullName("first"));
        $this->nameNumbers["personal"][0]   = $this->getDigitFromNumber($this->personalNumber[1]);
    }

    private function setHereditaryNumbers()
    {
        $this->nameNumbers["hereditary"][1] = $this->getNumberFromName($this->getFullName("last"));
        $this->nameNumbers["hereditary"][0] = $this->getDigitFromNumber($this->hereditaryNumber[1]);
    }
}
