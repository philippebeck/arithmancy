<?php

namespace App\Manager;

/**
 * Class ForecastCalculator
 * @package App\Manager
 */
class ForecastCalculator extends MainCalculator
{
    /**
     * @param int $year
     * @return array
     */
    public function getPersonalYearNumbers(int $year)
    {
        $personalYearNumber = $this->getBirthDate("day") + $this->getBirthDate("month") + $year;
        $personalYearDigit  = $this->getDigitFromNumber($personalYearNumber);

        return [$personalYearDigit, $personalYearNumber];
    }

    /**
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getPersonalMonthNumbers(int $month, int $year)
    {
        $personalMonthNumber    = $this->getPersonalYearNumbers($year) + $month;
        $personalMonthDigit     = $this->getDigitFromNumber($personalMonthNumber);

        return [$personalMonthDigit, $personalMonthNumber];
    }

    /**
     * @param int $day
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getPersonalDayNumbers(int $day, int $month, int $year)
    {
        $personalDayNumber  = $this->getPersonalMonthNumbers($month, $year) + $day;
        $personalDayDigit   = $this->getDigitFromNumber($personalDayNumber);

        return [$personalDayDigit, $personalDayNumber];
    }
}
