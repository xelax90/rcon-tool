<?php
namespace RconManager\Utils;

class intervalToString
{
    public static function compute(int $inputSeconds)
    {
        $hours = floor($inputSeconds/60/60);
        $minutes = floor(($inputSeconds % (60 * 60)) /60);
        $seconds = $inputSeconds % 60;

        if ($hours) {
            return sprintf('%d:%d:%d Hours', $hours, $minutes, $seconds);
        }
        $result = '';
        if ($minutes) {
            $result .= sprintf('%d Minutes ', $minutes);
        }
        if ($seconds) {
            $result .= sprintf('%d Seconds ', $seconds);
        }
        return $result;
    }
}