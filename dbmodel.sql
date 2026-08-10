-- Standardní tabulka pro BGA Deck modul
CREATE TABLE IF NOT EXISTS `card` (
  `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `card_type` varchar(16) NOT NULL, -- 'creature' nebo 'lichocar'
  `card_type_arg` int(11) NOT NULL, -- barva: 1=červená, 2=modrá, 3=zelená, 4=žlutá, 0=Lichočár
  `card_location` varchar(16) NOT NULL, -- 'deck', 'hand', 'offer', 'melded', 'discard'
  `card_location_arg` int(11) NOT NULL, -- player_id nebo pořadí
  PRIMARY KEY (`card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- Globální proměěnné pro stav daného tahu/nabídky
-- (BGA doporučuje používat systémové klesající ID v týmu nebo příslušné stavové proměnné v game.php)