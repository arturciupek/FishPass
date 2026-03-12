<?php
namespace app\controllers;

use core\App;

class TermsCtrl {

    public function action_termsView() {
        
        App::getSmarty()->assign('page_title', 'FishPass — Terminy');

        // wyświetlamy terminy od dzisiaj
        $start = new \DateTime(); 
        $days = 90;

        // pojemność = liczba aktywnych stanowisk
        $stanowiska = App::getDB()->select("stanowisko", ["id_stanowiska"], ["aktywne" => 1]);
        $pojemnosc = count($stanowiska);

        // pobierz rezerwacje w zakresie (pomijamy anulowane)
        $end = clone $start;
        $end->modify('+' . ($days - 1) . ' days');

        $rezerwacje = App::getDB()->select("rezerwacja", [
            "data_rezerwacji"
        ], [
            "data_rezerwacji[<>]" => [$start->format('Y-m-d'), $end->format('Y-m-d')],
            "status[!]" => "ANULOWANA"
        ]);

        // zliczanie zajętych miejsca w danym dniu
        $zajete = [];
        foreach ($rezerwacje as $r) {
            $d = $r["data_rezerwacji"];
            if (!isset($zajete[$d])) $zajete[$d] = 0;
            $zajete[$d]++;
        }

        // budowanie listy terminów
        $terminy = [];
        $tmp = clone $start;
        for ($i = 0; $i < $days; $i++) {
            $d = $tmp->format('Y-m-d');
            $zarezerwowane = $zajete[$d] ?? 0;
            $wolneMiejsca = max(0, $pojemnosc - $zarezerwowane);

            $terminy[] = [
                "data" => $d,
                "wolne" => $wolneMiejsca
            ];

            $tmp->modify('+1 day');
        }

        App::getSmarty()->assign('terminy', $terminy);
        App::getSmarty()->display('TermsView.tpl');
    }
}
