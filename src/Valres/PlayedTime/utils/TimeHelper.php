<?php

namespace Valres\PlayedTime\utils;

class TimeHelper
{
    public static function convertToString($secondes): string {
        $hours = floor($secondes / 3600);
        $secondes %= 3600;
        $minutes = floor($secondes / 60);
        $secondes %= 60;

        $tempsDeJeu = '';
        if($hours > 0) $tempsDeJeu .= $hours . ' H. ';
        if($minutes > 0) $tempsDeJeu .= $minutes . ' m. ';
        if($secondes > 0 || $tempsDeJeu === '') $tempsDeJeu .= $secondes . ' s.';

        return trim($tempsDeJeu);
    }
}
