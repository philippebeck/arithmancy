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

            $this->setAstralData();
            $this->setExpressionData();
            $this->setSoulData();
            $this->setDayData();       
            $this->setRealizationData();       
            $this->setPersonalData();       
            $this->setHereditaryData();       
            $this->setGoalData();       
            $this->setPowerData();       
            $this->setSpiritualData();       

            return $this->render("front/theme.twig", [
                "numbers" => $this->numbers,
            ]);
        }

        return $this->render("front/theme.twig");
    }

    private function setAstralData()
    {
        $astralNumbers = $this->getAstralNumbers();

        $this->numbers["astralNumber"]  = $this->allNumbers[$astralNumbers[2] - 1]["number"];
        $this->numbers["astralText"]    = $this->allNumbers[$astralNumbers[2] - 1]["astral"];
    }

    private function setExpressionData()
    {
        $expressionNumbers = $this->getExpressionNumbers();

        $this->numbers["expressionNumber"]  = $this->allNumbers[$expressionNumbers[1] - 1]["number"];
        $this->numbers["expressionText"]    = $this->allNumbers[$expressionNumbers[1] - 1]["expression"];
    }

    private function setSoulData()
    {
        $soulNumbers = $this->getSoulNumbers();

        $this->numbers["soulNumber"]    = $this->allNumbers[$soulNumbers[1] - 1]["number"];
        $this->numbers["soulText"]      = $this->allNumbers[$soulNumbers[1] - 1]["soul"];
    }

    private function setDayData()
    {
        $dayNumber = $this->getDayNumber();

        $this->numbers["dayNumber"] = $this->allNumbers[$dayNumber - 1]["number"];
        $this->numbers["dayText"]   = $this->allNumbers[$dayNumber - 1]["day"];
    }

    private function setRealizationData()
    {
        $realizationNumbers = $this->getRealizationNumbers();

        $this->numbers["realizationNumber"] = $this->allNumbers[$realizationNumbers[1] - 1]["number"];
        $this->numbers["realizationText"]   = $this->allNumbers[$realizationNumbers[1] - 1]["realization"];
    }

    private function setPersonalData()
    {
        $personalNumbers = $this->getPersonalNumbers();

        $this->numbers["personalNumber"]    = $this->allNumbers[$personalNumbers[1] - 1]["number"];
        $this->numbers["personalText"]      = $this->allNumbers[$personalNumbers[1] - 1]["personal"];
    }

    private function setHereditaryData()
    {
        $hereditaryNumbers = $this->getHereditaryNumbers();

        $this->numbers["hereditaryNumber"]  = $this->allNumbers[$hereditaryNumbers[1] - 1]["number"];
        $this->numbers["hereditaryText"]    = $this->allNumbers[$hereditaryNumbers[1] - 1]["hereditary"];
    }

    private function setGoalData()
    {
        $goalNumbers = $this->getGoalNumbers();

        $this->numbers["goalNumber"]    = $this->allNumbers[$goalNumbers[1] - 1]["number"];
        $this->numbers["goalText"]      = $this->allNumbers[$goalNumbers[1] - 1]["goal"];
    }

    private function setPowerData()
    {
        $powerNumbers = $this->getPowerNumbers();

        $this->numbers["powerNumber"]   = $this->allNumbers[$powerNumbers[1] - 1]["number"];
        $this->numbers["powerText"]     = $this->allNumbers[$powerNumbers[1] - 1]["power"];
    }

    private function setSpiritualData()
    {
        $spiritualNumbers = $this->getSpiritualNumbers();

        $this->numbers["spiritualNumber"]   = $this->allNumbers[$spiritualNumbers[1] - 1]["number"];
        $this->numbers["spiritualText"]     = $this->allNumbers[$spiritualNumbers[1] - 1]["spiritual"];
    }
}
