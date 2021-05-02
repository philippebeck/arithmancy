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
    private $dateNumbers =  [];

    /**
     * @var array
     */
    private $nameNumbers =  [];

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
            $dateCalculator    = new DateCalculator();
            $nameCalculator    = new NameCalculator();

            $this->dateNumbers = $dateCalculator->getDateNumbers();
            $this->nameNumbers = $nameCalculator->getNameNumbers();

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

    /**
     * @return array
     */
    public function setPowerNumbers()
    {
        $this->synthesisNumbers["power"][1] = $this->dateNumbers["lifePath"][1] + $this->nameNumbers["expression"][1];
        $this->synthesisNumbers["power"][0] = $this->getDigitFromNumber($this->synthesisNumbers["power"][1]);
    }

    /**
     * @return array
     */
    public function setSpiritualNumbers()
    {
        $this->synthesisNumbers["spiritual"][1] = $this->dateNumbers["lifePath"][1] + $this->nameNumbers["expression"][1] + $this->nameNumbers["intimate"][1] + $this->dateNumbers["day"];
        $this->synthesisNumbers["spiritual"][0] = $this->getDigitFromNumber($this->synthesisNumbers["spiritual"][1]);
    }
}
