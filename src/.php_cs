<?php
/**
 * PHP-CS-Fixer Konfiguration
 *
 * @see https://github.com/fabpot/PHP-CS-Fixer
 * @see http://cs.sensiolabs.org/
 */

$finder = Symfony\CS\Finder\Symfony21Finder()
//Symfony\CS\Finder\DefaultFinder::create()
//    ->exclude('somefile')
    ->in(__DIR__)
;

return Symfony\CS\Config\Config::create()
//    ->fixers(array('indentation', 'elseif'))
    ->finder($finder)
;