<?php

namespace App\Helpers;

use DateTime;

class DatetimeHelper
{
    public const DATETIME_FORMAT = 'Y-m-d H:i:s';

    public static function convertTimestamp($timestamp)
    {
        $date = new DateTime();
        $date->setTimestamp($timestamp);

        return $date->format(self::DATETIME_FORMAT);
    }

    public static function formatDatetime($format, $time = 0)
    {
        if (! $time) {
            $time = time();
        }
        $lang = trans('datetime');
        $format = str_replace('r', 'D, d M Y H:i:s O', $format);
        $format = str_replace(['D', 'M'], ['[D]', '[M]'], $format);
        $return = date($format, $time);
        $replaces = [
            '/\[Sun\](\W|$)/' => $lang['sun'].'$1',
            '/\[Mon\](\W|$)/' => $lang['mon'].'$1',
            '/\[Tue\](\W|$)/' => $lang['tue'].'$1',
            '/\[Wed\](\W|$)/' => $lang['wed'].'$1',
            '/\[Thu\](\W|$)/' => $lang['thu'].'$1',
            '/\[Fri\](\W|$)/' => $lang['fri'].'$1',
            '/\[Sat\](\W|$)/' => $lang['sat'].'$1',
            '/\[Jan\](\W|$)/' => $lang['jan'].'$1',
            '/\[Feb\](\W|$)/' => $lang['feb'].'$1',
            '/\[Mar\](\W|$)/' => $lang['mar'].'$1',
            '/\[Apr\](\W|$)/' => $lang['apr'].'$1',
            '/\[May\](\W|$)/' => $lang['may2'].'$1',
            '/\[Jun\](\W|$)/' => $lang['jun'].'$1',
            '/\[Jul\](\W|$)/' => $lang['jul'].'$1',
            '/\[Aug\](\W|$)/' => $lang['aug'].'$1',
            '/\[Sep\](\W|$)/' => $lang['sep'].'$1',
            '/\[Oct\](\W|$)/' => $lang['oct'].'$1',
            '/\[Nov\](\W|$)/' => $lang['nov'].'$1',
            '/\[Dec\](\W|$)/' => $lang['dec'].'$1',
            '/Sunday(\W|$)/' => $lang['sunday'].'$1',
            '/Monday(\W|$)/' => $lang['monday'].'$1',
            '/Tuesday(\W|$)/' => $lang['tuesday'].'$1',
            '/Wednesday(\W|$)/' => $lang['wednesday'].'$1',
            '/Thursday(\W|$)/' => $lang['thursday'].'$1',
            '/Friday(\W|$)/' => $lang['friday'].'$1',
            '/Saturday(\W|$)/' => $lang['saturday'].'$1',
            '/January(\W|$)/' => $lang['january'].'$1',
            '/February(\W|$)/' => $lang['february'].'$1',
            '/March(\W|$)/' => $lang['march'].'$1',
            '/April(\W|$)/' => $lang['april'].'$1',
            '/May(\W|$)/' => $lang['may'].'$1',
            '/June(\W|$)/' => $lang['june'].'$1',
            '/July(\W|$)/' => $lang['july'].'$1',
            '/August(\W|$)/' => $lang['august'].'$1',
            '/September(\W|$)/' => $lang['september'].'$1',
            '/October(\W|$)/' => $lang['october'].'$1',
            '/November(\W|$)/' => $lang['november'].'$1',
            '/December(\W|$)/' => $lang['december'].'$1',
        ];

        return preg_replace(array_keys($replaces), array_values($replaces), $return);
    }
}
