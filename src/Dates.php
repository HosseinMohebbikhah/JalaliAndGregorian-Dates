<?php

class Dates
{
    public function getJalaliTime()
    {
        return self::Gregorian2Jalali(date("y-m-d H:i:s"));
    }

    public function getGregorianTime()
    {
        return date("Y-m-d H:i:s");
    }

    public function Gregorian2Jalali($time)
    {
        $now = new DateTime($time);
        $formatter = new IntlDateFormatter(
            "fa_IR@calendar=persian",
            IntlDateFormatter::FULL,
            IntlDateFormatter::FULL,
            'Asia/Tehran',
            IntlDateFormatter::TRADITIONAL,
            "yyyy-MM-dd HH:mm:ss"
        );


        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $formatter->format($now));
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }

    public function diff_Jalali($baseTime, $targetTime)
    {
        $date1 = (self::Jalali2Gregorian($baseTime));
        $date2 = (self::Jalali2Gregorian($targetTime));
        $diff = date_diff(date_create($date1), date_create($date2));
        return $diff->format("%Y-%M-%D %H:%I:%S");
    }

    public function diff_Gregorian($baseTime, $targetTime)
    {
        $diff = date_diff(date_create($baseTime), date_create($targetTime));
        return $diff->format("%Y-%M-%D %H:%I:%S");
    }

    public function Jalali2Gregorian($time)
    {
        $array = explode(' ', $time);
        $date = explode('-', $array[0]);
        $time = explode(':', $array[1]);

        $year = $date[0];
        $mounth = $date[1] / 1;
        $day = $date[2] / 1;
        $hour = $time[0] / 1;
        $minute = $time[1] / 1;
        $secound = $time[2] / 1;
        $isKabise = (bool)floor($year % 4) == 3;
        $arrayDaysShamsi =   [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, (($isKabise) ? 30 : 29)];

        //
        $dayLeft = 0;
        for ($i = 0; $i < ($mounth - 1); $i++) {
            $dayLeft += $arrayDaysShamsi[$i];
        }
        $dayLeft += $day;
        //

        $addYear = ($mounth < 10 || ($mounth == 10 && $day <= ($isKabise ? 11 : 10))) ? 621 : 622;
        $yearMiladi = $year + $addYear;

        //
        $isKabise = ($yearMiladi % 4 == 00 && $yearMiladi % 400 == 0);
        if ($yearMiladi % 4 == 0) {
            if ($yearMiladi % 100 == 0)
                $isKabise = false;
            else
                $isKabise = true;
        } else
            $isKabise = false;
        $arrayDays  = [31, (($isKabise) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        //

        //
        $counterKabise = 0;
        for ($i = $addYear; $i > 0; $i--) {
            if (floor($i % 4) == 3) {
                $counterKabise++;
            }
        }
        //

        $dayLeftMiladi = ($dayLeft + 226899) - (($addYear * 365) + $counterKabise);

        $mounthMiladi = 0;
        $dayMiladi = 0;
        for ($i = 0; $i < 12; $i++) {
            if ($arrayDays[$i] < $dayLeftMiladi) {
                $dayLeftMiladi -= $arrayDays[$i];
            } else {
                $mounthMiladi = $i + 1;
                $dayMiladi = $dayLeftMiladi;
                break;
            }
        }

        $date = new DateTime("$yearMiladi-$mounthMiladi-$dayMiladi $hour:$minute:$secound", new DateTimeZone('Asia/Tehran'));
        $date->setTimezone(new DateTimeZone('Europe/London'));
        return $date->format('Y-m-d H:i:s');
    }
}
