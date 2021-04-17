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
     * @param int $number
     * @param string $category
     */
    private function checkSimpleNumber(int $number, string $category)
    {
        if ($number < 79) {

            $this->numbers[$category . "SecondText"] = 
            $this->allNumbers[$number - 1]["description"];
        }  
    }

    /**
     * @param int $number
     * @param string $category
     */
    private function checkSpecialNumber(int $number, string $category)
    {
        if ($number < 79) {
            if ($number === 11 || $number === 22) {

                $this->numbers[$category . "SecondText"] = 
                $this->allNumbers[$number - 1][$category];

            } else {
                $this->numbers[$category . "SecondText"] = 
                $this->allNumbers[$number - 1]["description"];
            }
        }
    }

    /**
     * @param int $number
     * @param string $category
     */
    private function checkVerySpecialNumber(int $number, string $category)
    {
        if ($number < 79) {
            if ($number === 11 || $number === 22 || $number === 33 || $number === 44) {

                $this->numbers[$category . "SecondText"] = 
                $this->allNumbers[$number - 1][$category];

            } else {
                $this->numbers[$category . "SecondText"] = 
                $this->allNumbers[$number - 1]["description"];
            }
        }
    }

    private function setLifePathData()
    {
        $lifePathNumbers = $this->getLifePathNumbers();

        $this->numbers["lifePathDigit"]     = $lifePathNumbers[2];
        $this->numbers["lifePathNumber"]    = $lifePathNumbers[0];

        $this->numbers["lifePathMainText"] = 
        $this->allNumbers[$lifePathNumbers[2] - 1]["lifePath"];

        $this->checkVerySpecialNumber($lifePathNumbers[0], "lifePath");
    }

    private function setExpressionData()
    {
        $expressionNumbers = $this->getExpressionNumbers();

        $this->numbers["expressionDigit"]   = $expressionNumbers[1];
        $this->numbers["expressionNumber"]  = $expressionNumbers[0];

        $this->numbers["expressionMainText"] = 
        $this->allNumbers[$expressionNumbers[1] - 1]["expression"];

        $this->checkSpecialNumber($expressionNumbers[0], "expression");
    }

    private function setIntimateData()
    {
        $intimateNumbers = $this->getIntimateNumbers();

        $this->numbers["intimateDigit"]     = $intimateNumbers[1];
        $this->numbers["intimateNumber"]    = $intimateNumbers[0];

        $this->numbers["intimateMainText"] = 
        $this->allNumbers[$intimateNumbers[1] - 1]["intimate"];

        $this->checkSpecialNumber($intimateNumbers[0], "intimate");
    }

    private function setRealizationData()
    {
        $realizationNumbers = $this->getRealizationNumbers();

        $this->numbers["realizationDigit"]  = $realizationNumbers[1];
        $this->numbers["realizationNumber"] = $realizationNumbers[0];

        $this->numbers["realizationMainText"] = 
        $this->allNumbers[$realizationNumbers[1] - 1]["realization"];

        $this->checkSpecialNumber($realizationNumbers[0], "realization");
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

        $this->numbers["goalDigit"]     = $goalNumbers[1];
        $this->numbers["goalNumber"]    = $goalNumbers[0];

        $this->numbers["goalMainText"] = 
        $this->allNumbers[$goalNumbers[1] - 1]["goal"];

        if ($goalNumbers[0] < 79) {
            if (
                $goalNumbers[0] === 11
                ||
                $goalNumbers[0] === 22
                ||
                $goalNumbers[0] === 33
            ) {
                $this->numbers["goalSecondText"] = 
                $this->allNumbers[$goalNumbers[0] - 1]["goal"];

            } else {
                $this->numbers["goalSecondText"] = 
                $this->allNumbers[$goalNumbers[0] - 1]["description"];
            }
        }
    }

    private function setPersonalData()
    {
        $personalNumbers = $this->getPersonalNumbers();

        $this->numbers["personalDigit"]     = $personalNumbers[1];
        $this->numbers["personalNumber"]    = $personalNumbers[0];

        $this->numbers["personalMainText"] = 
        $this->allNumbers[$personalNumbers[1] - 1]["personal"];

        $this->checkSimpleNumber($personalNumbers[0], "personal");        
    }

    private function setHereditaryData()
    {
        $hereditaryNumbers = $this->getHereditaryNumbers();

        $this->numbers["hereditaryDigit"]   = $hereditaryNumbers[1];
        $this->numbers["hereditaryNumber"]  = $hereditaryNumbers[0];

        $this->numbers["hereditaryMainText"] = 
        $this->allNumbers[$hereditaryNumbers[1] - 1]["hereditary"];

        $this->checkSimpleNumber($hereditaryNumbers[0], "hereditary");
    }

    private function setPowerData()
    {
        $powerNumbers = $this->getPowerNumbers();

        $this->numbers["powerDigit"]    = $powerNumbers[1];
        $this->numbers["powerNumber"]   = $powerNumbers[0];

        $this->numbers["powerMainText"] = 
        $this->allNumbers[$powerNumbers[1] - 1]["power"];

        $this->checkSpecialNumber($powerNumbers[0], "power");
    }

    private function setSpiritualData()
    {
        $spiritualNumbers = $this->getSpiritualNumbers();

        $this->numbers["spiritualDigit"]    = $spiritualNumbers[1];
        $this->numbers["spiritualNumber"]   = $spiritualNumbers[0];

        $this->numbers["spiritualMainText"] = 
        $this->allNumbers[$spiritualNumbers[1] - 1]["spiritual"];

        $this->checkVerySpecialNumber($spiritualNumbers[0], "spiritual");
    }
}
