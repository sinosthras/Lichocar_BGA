<?php
/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * Lichocar implementation : © <Your Name> <Your Email>
 *
 * states.inc.php
 */

$machinestates = array(

    // Počáteční stav výchozího nastavení hry
    1 => array(
        "name" => "gameSetup",
        "description" => "",
        "type" => "manager",
        "action" => "stGameSetup",
        "transitions" => array( "" => 10 )
    ),

    // Hlavní stav: Tah hráče (zahrání karty / akce)
    10 => array(
        "name" => "playerTurn",
        "description" => clienttranslate('${actplayer} musí zahrát kartu'),
        "descriptionmyturn" => clienttranslate('${you} musíš zahrát kartu'),
        "type" => "activeplayer",
        "possibleactions" => array( "playCard" ),
        "transitions" => array( "playCard" => 11, "zombiePass" => 11 )
    ),

    // Přechodový stav: Vyhodnocení tahu a posun na dalšího hráče
    11 => array(
        "name" => "nextPlayer",
        "type" => "game",
        "action" => "stNextPlayer",
        "transitions" => array( "nextPlayer" => 10, "endGame" => 99 )
    ),

    // Konec hry
    99 => array(
        "name" => "gameEnd",
        "description" => clienttranslate("Konec hry"),
        "type" => "manager",
        "action" => "stGameEnd",
        "args" => "argGameEnd"
    )

);