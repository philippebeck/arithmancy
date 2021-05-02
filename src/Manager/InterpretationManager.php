<?php

namespace App\Manager;

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
     * InterpretationManager constructor
     */
    public function __construct()
    {
        parent::__construct();

        if ($this->checkArray($this->getPost())) {
            
            $this->numbers = ModelFactory::getModel("Number")->listData();
        }
    }

    /**
     * @param array $numbers
     * @param string $category
     */
    protected function getDigitData(array $numbers, string $category, string $name)
    {
        return $name . " " . $numbers[0] . " : " . $this->numbers[$numbers[0] - 1][$category];
    }

    /**
     * @param int $number
     */
    protected function getSimpleNumber(int $number)
    {
        if ($number < 79) {

            return $number . " : " . $this->numbers[$number - 1]["description"];
        }  
    }

    /**
     * @param int $number
     * @param string $category
     */
    protected function getDoubleNumber(int $number, string $category)
    {
        if ($number < 79) {
            if ($number === 11 || $number === 22) {

                return $number . " : " . $this->numbers[$number - 1][$category];
            }
                
            return $number . " : " . $this->numbers[$number - 1]["description"];
        }
    }

    /**
     * @param int $number
     * @param string $category
     */
    protected function getTripleNumber(int $number, string $category)
    {
        if ($number < 79) {
            if ($number === 11 || $number === 22 || $number === 33) {

                return $number . " : " . $this->numbers[$number - 1][$category];
            }
                
            return $number . " : " . $this->numbers[$number - 1]["description"];
        }
    }

    /**
     * @param int $number
     * @param string $category
     */
    protected function getQuadrupleNumber(int $number, string $category)
    {
        if ($number < 79) {
            if ($number === 11 || $number === 22 || $number === 33 || $number === 44) {

                return $number . " : " . $this->numbers[$number - 1][$category];
            }
                
            return $number . " : " . $this->numbers[$number - 1]["description"];
        }
    }
}
