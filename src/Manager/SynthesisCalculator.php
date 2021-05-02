<?php

namespace App\Manager;

/**
 * Class SynthesisCalculator
 * @package App\Manager
 */
class SynthesisCalculator extends MainCalculator
{
    /**
     * @var array
     */
    private $synthesisNumbers =  [];

    public function __construct()
    {
        parent::__construct();
        
        if (
            $this->checkArray($this->getPost(), "birthDate")
            && $this->checkArray($this->getPost(), "firstName")
            && $this->checkArray($this->getPost(), "lastName")
        ) {
            $this->setPowerNumbers();
            $this->setSpiritualNumbers();
        }
    }

    /**
     * @param string $key
     * @return array|string
     */
    public function getSynthesisNumbers(string $key = "")
    {
        if ($key === "") {

            return $this->synthesisNumbers;
        }

        return $this->synthesisNumbers[$key] ?? "";
        
    }

     // *********************************************** \\
    // ******************** SETTERS ******************** \\

    // TODO -> switch old $this->properties to object usage

    /**
     * @return array
     */
    public function setPowerNumbers()
    {
        $this->synthesisNumbers["power"][1] = $this->lifePathNumber + $this->expressionNumber;
        $this->synthesisNumbers["power"][0] = $this->getDigitFromNumber($this->synthesisNumbers["power"][1]);
    }

    /**
     * @return array
     */
    public function setSpiritualNumbers()
    {
        $this->synthesisNumbers["spiritual"][1] = $this->lifePathNumber + $this->expressionNumber + $this->intimateNumber + $this->getBirthDate("day");
        $this->synthesisNumbers["spiritual"][0] = $this->getDigitFromNumber($this->synthesisNumbers["spiritual"][1]);
    }
}
