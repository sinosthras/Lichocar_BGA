<?php
require_once( APP_GAMEMODULE_PATH.'module/table/table.game.php' );

class Lichocar extends Table {
    function __construct() {
        parent::__construct();
        
        $this->cards = $this->getNew( "module.common.deck" );
        $this->cards->init( "card" );
    }

    protected function setupNewGame( $players, $options = array() ) {
        // Inicializace hráčů...
        
        // Vytvoření balíčku karet
        $cards = array();
        
        // 4 barvy (1=červená, 2=modrá, 3=zelená, 4=žlutá), hodnoty 1-13
        for ($color = 1; $color <= 4; $color++) {
            for ($value = 1; $value <= 13; $value++) {
                $cards[] = array('type' => 'creature', 'type_arg' => $color, 'nbr' => 1, 'value' => $value);
            }
        }
        // 5 Lichočárů
        for ($i = 0; $i < 5; $i++) {
            $cards[] = array('type' => 'lichocar', 'type_arg' => 0, 'nbr' => 1, 'value' => 0);
        }

        $this->cards->createCards($cards, 'deck');
    }

    public function stNewRound() {
        $players = $this->loadPlayersBasicInfos();
        $player_count = count($players);

        // Obnovení všech karet do balíčku
        $this->cards->moveAllCardsInHandler('deck', 'deck');

        // Úprava balíčku podle počtu hráčů
        if ($player_count == 4) {
            // Odstranit všechny 2
            // $this->cards->moveCards(...) 
        } else if ($player_count == 3) {
            // Odstranit všechny 2 a 3
        }

        $this->cards->shuffle('deck');

        // Rozdání karet podle počtu hráčů
        $cards_to_deal = ($player_count == 5) ? 11 : 13;
        foreach ($players as $player_id => $player) {
            $this->cards->pickCards($cards_to_deal, 'deck', $player_id);
        }

        $this->gamestate->nextState("");
    }

    // Pomocná metoda pro kontrolu konce kola
    public function stCheckEndOfRound() {
        $players = $this->loadPlayersBasicInfos();
        
        foreach ($players as $player_id => $player) {
            // Spočítat karty bytostí v ruce
            $hand = $this->cards->getCardsInLocation('hand', $player_id);
            $creature_cards = array_filter($hand, function($card) {
                return $card['type'] === 'creature';
            });

            if (count($creature_cards) === 0) {
                $this->gamestate->nextState("endRound");
                return;
            }
        }

        $this->gamestate->nextState("nextTurn");
    }
}