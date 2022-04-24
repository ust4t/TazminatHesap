<?php

class DateDifference {
    public $y;
    public $m;
    public $d;
    public $days;
    public $invert;

    function __construct($date1, $date2)
    {
        $date1 = strtotime($date1);
        $date2 = strtotime($date2);

        $date1 = array(
            'y' => (int)date('Y', $date1),
            'm' => (int)date('m', $date1),
            'd' => (int)date('d', $date1)
        );
        $date2 = array(
            'y' => (int)date('Y', $date2),
            'm' => (int)date('m', $date2),
            'd' => (int)date('d', $date2)
        );

        $days = ($date2['y']*360+$date2['m']*30+$date2['d'])-($date1['y']*360+$date1['m']*30+$date1['d']);
        $absDays = abs($days);
        $this->y = floor($absDays/360);
        $this->m = floor(($absDays%360)/30);
        $this->d = floor($absDays%30);
        $this->days = $absDays;
        $this->invert = $days < 0 ? TRUE : FALSE;
    }
}

function post($name)
{
    return htmlspecialchars(strip_tags($_POST[$name]));
}

function numberReformat($number,$type = 1) {
    $type = ($type == 1) ? $number : str_replace([".",","],[null,"."],$number);
    return number_format($type, 2, '.', '');
}

function yas_bul($dogum_tarihi) {
    $gun = explode('-', $dogum_tarihi)[0];
    $ay = explode('-', $dogum_tarihi)[1];
    $yil = explode('-', $dogum_tarihi)[2];

    $yas = date('Y') - $yil;
    if (date('m') < $ay) { $yas--;}
    elseif (date('d') < $gun) { $yas--;}
    echo $yas;
}

function login() {
    
}

function reformatter($int){
   return number_format($int,2,".",",");
}

function is6MonthsDiff($diff) {
    if($diff->y == 0 && $diff->m == 6 && $diff->d == 0 && $diff->days == 180) {
        return TRUE;
    } else {
        return FALSE;
    }
}