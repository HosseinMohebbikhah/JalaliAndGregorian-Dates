<?php

$dates = new Dates();

echo "<b>Time now in dates</b><br>";

$jalaliTimeNow = $dates->getJalaliTime();
echo "Jalali time now : " . $jalaliTimeNow . "<br>";

$gregorianTimeNow = $dates->getGregorianTime();
echo "Gregorian time now : " . $gregorianTimeNow . "<br>";
echo "<br>";



echo "<b>Convert together dates</b><br>";

$jalaliTime = "1401-04-26 12:05:09";
$gregorianTime = "2002-09-12 05:35:12";

echo "The Jalali time is : " . $jalaliTime . "<br>";
echo "Convert to Gregorian => " . $dates->Jalali2Gregorian($jalaliTime) . "<br><br>";

echo "The Gregorian time is : " . $gregorianTime . "<br>";
echo "Convert to Jalali => " . $dates->Gregorian2Jalali($gregorianTime). "<br>";
echo "<br>";



echo "<b>Different between to dates</b><br>";

$jalaliTime1 = "1401-04-26 12:05:09";
$jalaliTime2 = "1401-04-25 09:45:01";
echo "diff between \"$jalaliTime1\" and \"$jalaliTime2\" => " . $dates->diff_Jalali($jalaliTime1, $jalaliTime2). "<br>";

$gregorianTime1 = "2022-02-10 16:00:05";
$gregorianTime2 = "2021-09-12 05:35:12";
echo "diff between \"$gregorianTime1\" and \"$gregorianTime2\" => " . $dates->diff_Gregorian($gregorianTime1, $gregorianTime2). "<br>";
