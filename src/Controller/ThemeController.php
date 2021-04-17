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

    private function setLifePathData()
    {
        $lifePathNumbers = $this->getLifePathNumbers();

        $this->numbers["lifePathDigit"]     = $lifePathNumbers[2];
        $this->numbers["lifePathNumber"]    = $lifePathNumbers[0];

        $this->numbers["lifePathMainText"] = 
        $this->allNumbers[$lifePathNumbers[2] - 1]["lifePath"];

        if ($this->numbers["lifePathNumber"] < 79) {
            if (
                $this->numbers["lifePathNumber"] === 11
                ||
                $this->numbers["lifePathNumber"] === 22
                ||
                $this->numbers["lifePathNumber"] === 33
                ||
                $this->numbers["lifePathNumber"] === 44
            ) {
                $this->numbers["lifePathSecondText"] = 
                $this->allNumbers[$lifePathNumbers[0] - 1]["lifePath"];

            } else {
                $this->numbers["lifePathSecondText"] = 
                $this->allNumbers[$lifePathNumbers[0] - 1]["description"];
            }
        }
    }

    private function setExpressionData()
    {
        $expressionNumbers = $this->getExpressionNumbers();

        $this->numbers["expressionDigit"]   = $expressionNumbers[1];
        $this->numbers["expressionNumber"]  = $expressionNumbers[0];

        $this->numbers["expressionMainText"] = 
        $this->allNumbers[$expressionNumbers[1] - 1]["expression"];

        if ($expressionNumbers[0] < 79) {
            if (
                $this->numbers["expressionNumber"] === 11
                ||
                $this->numbers["expressionNumber"] === 22
            ) {
                $this->numbers["expressionSecondText"] = 
                $this->allNumbers[$expressionNumbers[0] - 1]["expression"];

            } else {
                $this->numbers["expressionSecondText"] = 
                $this->allNumbers[$expressionNumbers[0] - 1]["description"];
            }
        }
    }

    private function setIntimateData()
    {
        $intimateNumbers = $this->getIntimateNumbers();

        $this->numbers["intimateDigit"]     = $intimateNumbers[1];
        $this->numbers["intimateNumber"]    = $intimateNumbers[0];

        $this->numbers["intimateMainText"] = 
        $this->allNumbers[$intimateNumbers[1] - 1]["intimate"];

        if ($this->numbers["intimateNumber"] < 79) {
            if (
                $this->numbers["intimateNumber"] === 11
                ||
                $this->numbers["intimateNumber"] === 22
            ) {
                $this->numbers["intimateSecondText"] = 
                $this->allNumbers[$intimateNumbers[0] - 1]["intimate"];

            } else {
                $this->numbers["intimateSecondText"] = 
                $this->allNumbers[$intimateNumbers[0] - 1]["description"];
            }
        }
    }

    private function setRealizationData()
    {
        $realizationNumbers = $this->getRealizationNumbers();

        $this->numbers["realizationDigit"]  = $realizationNumbers[1];
        $this->numbers["realizationNumber"] = $realizationNumbers[0];

        $this->numbers["realizationMainText"] = 
        $this->allNumbers[$realizationNumbers[1] - 1]["realization"];

        if ($this->numbers["realizationNumber"] < 79) {
            if (
                $this->numbers["realizationNumber"] === 11
                ||
                $this->numbers["realizationNumber"] === 22
            ) {
                $this->numbers["realizationSecondText"] = 
                $this->allNumbers[$realizationNumbers[0] - 1]["realization"];

            } else {
                $this->numbers["realizationSecondText"] = 
                $this->allNumbers[$realizationNumbers[0] - 1]["description"];
            }
        }
    }

    private function setDayData()
    {
        $dayNumber = $this->getDayNumber();

        $this->numbers["dayNumber"] = 
        $this->allNumbers[$dayNumber - 1]["number"];
        
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

        if ($this->numbers["goalNumber"] < 79) {
            if (
                $this->numbers["goalNumber"] === 11
                ||
                $this->numbers["goalNumber"] === 22
                ||
                $this->numbers["goalNumber"] === 33
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

        if ($this->numbers["personalNumber"] < 79) {

            $this->numbers["personalSecondText"] = 
            $this->allNumbers[$personalNumbers[0] - 1]["description"];
        }        
    }

    private function setHereditaryData()
    {
        $hereditaryNumbers = $this->getHereditaryNumbers();

        $this->numbers["hereditaryDigit"]   = $hereditaryNumbers[1];
        $this->numbers["hereditaryNumber"]  = $hereditaryNumbers[0];

        $this->numbers["hereditaryMainText"] = 
        $this->allNumbers[$hereditaryNumbers[1] - 1]["hereditary"];

        if ($this->numbers["hereditaryNumber"] < 79) {

            $this->numbers["hereditarySecondText"] = 
            $this->allNumbers[$hereditaryNumbers[0] - 1]["description"];
        } 
    }

    private function setPowerData()
    {
        $powerNumbers = $this->getPowerNumbers();

        $this->numbers["powerDigit"]    = $powerNumbers[1];
        $this->numbers["powerNumber"]   = $powerNumbers[0];

        $this->numbers["powerMainText"] = 
        $this->allNumbers[$powerNumbers[1] - 1]["power"];

        if ($this->numbers["powerNumber"] < 79) {
            if (
                $this->numbers["powerNumber"] === 11
                ||
                $this->numbers["powerNumber"] === 22
            ) {
                $this->numbers["powerSecondText"] = 
                $this->allNumbers[$powerNumbers[0] - 1]["power"];

            } else {
                $this->numbers["powerSecondText"] = 
                $this->allNumbers[$powerNumbers[0] - 1]["description"];
            }
        }
    }

    private function setSpiritualData()
    {
        $spiritualNumbers = $this->getSpiritualNumbers();

        $this->numbers["spiritualDigit"]    = $spiritualNumbers[1];
        $this->numbers["spiritualNumber"]   = $spiritualNumbers[0];

        $this->numbers["spiritualMainText"] = 
        $this->allNumbers[$spiritualNumbers[1] - 1]["spiritual"];

        if ($this->numbers["spiritualNumber"] < 79) {
            if (
                $this->numbers["spiritualNumber"] === 11
                ||
                $this->numbers["spiritualNumber"] === 22
                ||
                $this->numbers["spiritualNumber"] === 33
                ||
                $this->numbers["spiritualNumber"] === 44
            ) {
                $this->numbers["spiritualSecondText"] = 
                $this->allNumbers[$spiritualNumbers[0] - 1]["spiritual"];

            } else {
                $this->numbers["spiritualSecondText"] = 
                $this->allNumbers[$spiritualNumbers[0] - 1]["description"];
            }
        }
    }
}
