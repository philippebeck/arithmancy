<?php

namespace App\Controller;

use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ThemeController
 * @package App\Controller
 */
class ThemeController extends CalculationController
{
    /**
     * @var array
     */
    private $numbers = [];

    /**
     * @var array
     */
    private $allNumbers = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if (!empty($this->getPost()->getPostArray())) {
            $this->allNumbers = ModelFactory::getModel("Number")->listData();

            $this->setLifePathData();
            $this->setExpressionData();
            $this->setIntimateData();
            $this->setRealizationData();       
            $this->setDayData();       
            $this->setGoalData();       
            $this->setPersonalData();       
            $this->setHereditaryData();       
            $this->setPowerData();       
            $this->setSpiritualData();

            return $this->render("front/theme.twig", [
                "numbers" => $this->numbers
            ]);
        }

        return $this->render("front/theme.twig");
    }

    /**
     * @param array $numbers
     * @param string $category
     */
    private function setNumberData(
        array $numbers,
        string $category)
    {
        $this->numbers[$category . "Digit"]   = $numbers[0];
        $this->numbers[$category . "Number"]  = $numbers[1];

        $this->numbers[$category . "MainText"] = 
        $this->allNumbers[$numbers[0] - 1][$category];
    }

    /**
     * @param int $number
     * @param string $category
     * @param string $order
     */
    private function checkSimpleNumber(
        int $number, 
        string $category,
        string $order = "Second")
    {
        if ($number < 79) {

            $this->numbers[$category . $order . "Text"] = 
            $this->allNumbers[$number - 1]["description"];
        }  
    }

    /**
     * @param int $number
     * @param string $category
     * @param string $order
     */
    private function checkDoubleNumber(
        int $number, 
        string $category,
        string $order = "Second")
    {
        if ($number < 79) {
            if ($number === 11 || $number === 22) {

                $this->numbers[$category . $order . "Text"] = 
                $this->allNumbers[$number - 1][$category];

            } else {
                $this->numbers[$category . $order . "Text"] = 
                $this->allNumbers[$number - 1]["description"];
            }
        }
    }

    /**
     * @param int $number
     * @param string $category
     * @param string $order
     */
    private function checkTripleNumber(
        int $number, 
        string $category,
        string $order = "Second")
    {
        if ($number < 79) {
            if ($number === 11 || $number === 22 || $number === 33) {

                $this->numbers[$category . $order . "Text"] = 
                $this->allNumbers[$number - 1][$category];

            } else {
                $this->numbers[$category . $order . "Text"] = 
                $this->allNumbers[$number - 1]["description"];
            }
        }
    }

    /**
     * @param int $number
     * @param string $category
     */
    private function checkQuadrupleNumber(
        int $number, 
        string $category,
        string $order = "Second")
    {
        if ($number < 79) {
            if ($number === 11 || $number === 22 || $number === 33 || $number === 44) {

                $this->numbers[$category . $order . "Text"] = 
                $this->allNumbers[$number - 1][$category];

            } else {
                $this->numbers[$category . $order . "Text"] = 
                $this->allNumbers[$number - 1]["description"];
            }
        }
    }

    private function setLifePathData()
    {
        $lifePathNumbers = $this->getLifePathNumbers();

        $this->numbers["lifePathSecondNumber"] = $lifePathNumbers[2];

        $this->setNumberData($lifePathNumbers, "lifePath");
        $this->checkQuadrupleNumber($lifePathNumbers[1], "lifePath");
        $this->checkQuadrupleNumber($lifePathNumbers[2], "lifePath", "Third");
    }

    private function setExpressionData()
    {
        $expressionNumbers = $this->getExpressionNumbers();

        $this->setNumberData($expressionNumbers, "expression");
        $this->checkDoubleNumber($expressionNumbers[1], "expression");
    }

    private function setIntimateData()
    {
        $intimateNumbers = $this->getIntimateNumbers();

        $this->setNumberData($intimateNumbers, "intimate");
        $this->checkDoubleNumber($intimateNumbers[1], "intimate");
    }

    private function setRealizationData()
    {
        $realizationNumbers = $this->getRealizationNumbers();

        $this->setNumberData($realizationNumbers, "realization");
        $this->checkDoubleNumber($realizationNumbers[1], "realization");
    }

    private function setDayData()
    {
        $dayNumber = $this->getDayNumber();

        $this->numbers["dayNumber"] = $dayNumber;
        
        $this->numbers["dayText"] = 
        $this->allNumbers[$dayNumber - 1]["day"];
    }

    private function setGoalData()
    {
        $goalNumbers = $this->getGoalNumbers();

        $this->setNumberData($goalNumbers, "goal");
        $this->checkTripleNumber($goalNumbers[1], "goal");
    }

    private function setPersonalData()
    {
        $personalNumbers = $this->getPersonalNumbers();

        $this->setNumberData($personalNumbers, "personal");
        $this->checkSimpleNumber($personalNumbers[1], "personal");        
    }

    private function setHereditaryData()
    {
        $hereditaryNumbers = $this->getHereditaryNumbers();

        $this->setNumberData($hereditaryNumbers, "hereditary");
        $this->checkSimpleNumber($hereditaryNumbers[1], "hereditary");
    }

    private function setPowerData()
    {
        $powerNumbers = $this->getPowerNumbers();

        $this->setNumberData($powerNumbers, "power");
        $this->checkDoubleNumber($powerNumbers[1], "power");
    }

    private function setSpiritualData()
    {
        $spiritualNumbers = $this->getSpiritualNumbers();

        $this->setNumberData($spiritualNumbers, "spiritual");
        $this->checkQuadrupleNumber($spiritualNumbers[1], "spiritual");
    }
}
