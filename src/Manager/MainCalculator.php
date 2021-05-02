<?php

namespace App\Manager;

use DateTime;
use Pam\Controller\MainController;

/**
 * Class MainCalculator
 * @package App\Controller\Service
 */
abstract class MainCalculator extends MainController
{
    /**
     * @var array
     */
    private $fullName = [];

    /**
     * @var array
     */
    private $birthDate = [];

    /**
     * @var array
     */
    private const TRIPOLI = [
        "a" => 1, 
        "b" => 2,
        "c" => 3,
        "d" => 4,
        "e" => 5,
        "f" => 6,
        "g" => 7,
        "h" => 8,
        "i" => 9,
        "j" => 1,
        "k" => 2,
        "l" => 3,
        "m" => 4,
        "n" => 5,
        "o" => 6,
        "p" => 7,
        "q" => 8,
        "r" => 9,
        "s" => 1,
        "t" => 2,
        "u" => 3,
        "v" => 4,
        "w" => 5,
        "x" => 6,
        "y" => 7,
        "z" => 8
    ];

    public function __construct()
    {
        parent::__construct();

        if ($this->checkArray($this->getPost(), "birthDate")) {
            $this->setBirthDate();
        }

        if (
            $this->checkArray($this->getPost(), "firstName")
            && $this->checkArray($this->getPost(), "lastName") 
        ) {
            $this->setFullName();
        }
    }

     // *********************************************** \\
    // ******************** SETTERS ******************** \\

    private function setBirthDate()
    {
        $birthDate = DateTime::createFromFormat(
            "Y-m-d",
            $this->getPost("birthDate")
        );

        $this->birthDate["day"]     = $birthDate->format("d");
        $this->birthDate["month"]   = $birthDate->format("m");
        $this->birthDate["year"]    = $birthDate->format("Y");
    }

    private function setFullName()
    {
        $this->fullName["first"] = $this->getString(
            $this->getPost("firstName"), 
            "alpha"
        );

        $this->fullName["last"] = $this->getString(
            $this->getPost("lastName"), 
            "alpha"
        );

        if ($this->getPost("middleName") !== null) {
            $this->fullName["middle"] = $this->getString(
                $this->getPost("middleName"), 
                "alpha"
            );
        }

        if ($this->getPost("thirdName") !== null) {
            $this->fullName["third"] = $this->getString(
                $this->getPost("thirdName"), 
                "alpha"
            );
        }
    }

     // *********************************************** \\
    // ******************** GETTERS ******************** \\

    /**
     * @param string $key
     * @return array|string
     */
    protected function getBirthDate(string $key = "")
    {
        if ($key === "") {

            return $this->birthDate;
        }

        return $this->birthDate[$key] ?? "";    
    }

    /**
     * @param string $key
     * @return array|string
     */
    protected function getFullName(string $key = "")
    {
        if ($key === "") {

            return $this->fullName;
        }

        return $this->fullName[$key] ?? "";
    }

    /**
     * @return array
     */
    protected function getFullNameLetters()
    {
        return array_merge(
            str_split($this->fullName["first"]), 
            str_split($this->fullName["middle"]), 
            str_split($this->fullName["third"]), 
            str_split($this->fullName["last"])
        );
    }

    /**
     * @param string $name
     * @return int
     */
    protected function getNumberFromName(string $name)
    {
        $name   = str_split($name);
        $number = 0;

        for ($i = 0; $i < count($name); $i++) {
            $number += self::TRIPOLI[$name[$i]];            
        }

        return $number;
    }

    /**
     * @param int $number
     * @return int
     */
    protected function getReducedNumber(int $number)
    {
        $numbers = str_split((string) $number);
        $number  = 0;

        for ($i = 0; $i < count($numbers); $i++) {
            $number += (int) $numbers[$i];            
        }

        return $number;
    }

    /**
     * @param int $number
     * @return int
     */
    protected function getDigitFromNumber(int $number)
    {
        do {
            $number = $this->getReducedNumber($number);

        } while ($number > 9);

        return $number;
    }
}
