<?php
/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * Lichočar implementation : © Vaše Jméno <vas@email.cz>
 *
 * states.inc.php
 */

$machinestates = array(

    // Začátek hry
    1 => array(
        "name" => "gameSetup",
        "description" => "",
        "type" => "manager",
        "action" => "stGameSetup",
        "transitions" => array( "" => 10 )
    ),

    // Příprava kola (míchání, rozdávání dle počtu hráčů)
    10 => array(
        "name" => "newRound",
        "description" => "",
        "type" => "game",
        "action" => "stNewRound",
        "transitions" => array( "" => 20 )
    ),

    // KROK 1: Žádající hrác vybírá kartu a zvolí Nabízejícího
    20 => array(
        "name" => "playerTurnRequest",
        "description" => clienttranslate('${actplayer} musí vynést kartu a zvolit Nabízejícího'),
        "descriptionmyturn" => clienttranslate('${you} musíš vynést kartu ze své ruky a zvolit Nabízejícího'),
        "type" => "activeplayer",
        "possibleactions" => array( "makeRequest" ),
        "transitions" => array( "offer" => 30 )
    ),

    // KROK 2: Nabízející hráč přikládá kartu lícem dolů
    30 => array(
        "name" => "playerTurnOffer",
        "description" => clienttranslate('${actplayer} musí přidat kartu do nabídky'),
        "descriptionmyturn" => clienttranslate('${you} musíš přiložit kartu do nabídky'),
        "type" => "activeplayer",
        "possibleactions" => array( "makeOffer" ),
        "transitions" => array( "decide" => 40 )
    ),

    // KROK 3: Žádající rozhoduje (Přijmout / Odmítnout / Chci ještě jednu)
    40 => array(
        "name" => "playerTurnDecision",
        "description" => clienttranslate('${actplayer} se rozhoduje o nabídce'),
        "descriptionmyturn" => clienttranslate('${you} se musíš rozhodnout: Přijmout, Odmítnout, nebo Chtít ještě jednu'),
        "type" => "activeplayer",
        "possibleactions" => array( "acceptOffer", "rejectOffer", "requestMore" ),
        "transitions" => array( 
            "more" => 30,         // Hráč chce další kartu (zpět na stav Nabídka)
            "meld" => 50,         // Nabídka vyhodnocena, přechod na vykládání sad
            "checkEnd" => 60      // Přímá kontrola konce kola
        )
    ),

    // Vykládání sad z nabídky a ruky
    50 => array(
        "name" => "playerMeld",
        "description" => clienttranslate('${actplayer} může vyložit platné sady'),
        "descriptionmyturn" => clienttranslate('${you} můžeš přiložit karty z ruky a vytvořit sady'),
        "type" => "activeplayer",
        "possibleactions" => array( "playSets", "skipMeld" ),
        "transitions" => array( "next" => 60 )
    ),

    // Kontrola konce kola
    60 => array(
        "name" => "checkEndOfRound",
        "description" => "",
        "type" => "game",
        "action" => "stCheckEndOfRound",
        "transitions" => array( 
            "nextTurn" => 20, 
            "endRound" => 70 
        )
    ),

    // Vyhodnocení kola a bodování
    70 => array(
        "name" => "scoreRound",
        "description" => "",
        "type" => "game",
        "action" => "stScoreRound",
        "transitions" => array( 
            "newRound" => 10, 
            "endGame" => 99 
        )
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