<?php

namespace App\Manager;

use Pam\Controller\MainController;
use Pam\Model\ModelFactory;

/**
 * Class MainInterpreter
 * @package App\Controller\Service
 */
abstract class MainInterpreter extends MainController
{
    /**
     * @var array
     */
    private $numbers = [];

    /**
     * Set all Numbers Data from DB
     */
    public function __construct()
    {
        parent::__construct();
    
        $this->numbers = ModelFactory::getModel("Number")->listData();
    }

    /**
     * Get Interpretation Data for Digit
     * @param int $number
     * @param string $category
     * @param string $name
     * @return string
     */
    protected function getDigitData(int $number, string $category, string $name)
    {
        return $name . " " . $number . " : " . $this->numbers[$number - 1][$category];
    }

    /**
     * @param int $number
     * @return string
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
     * @return string
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
     * @return string
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
     * @return string
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
