<?php
namespace app\controllers;

use core\App;

class TermsCtrl {

    public function action_termsView() {
        App::getSmarty()->assign('page_title', 'FishPass — Terminy');

        // od jakiej daty liczyć (domyślnie dziś)
        $startStr = $_GET['data'] ?? date('Y-m-d');
        $start = new \DateTime($startStr);

        // ile dni pokazać
        $days = 30;

        // pojemność = liczba aktywnych stanowisk
        $stanowiska = App::getDB()->select("stanowisko", ["id_stanowiska"], ["aktywne" => 1]);
        $capacity = count($stanowiska);

        // pobierz rezerwacje w zakresie (pomijamy anulowane)
        $end = (clone $start)->modify('+' . ($days - 1) . ' day');

        $rez = App::getDB()->select("rezerwacja", [
            "data_rezerwacji",
            "status"
        ], [
            "data_rezerwacji[<>]" => [$start->format('Y-m-d'), $end->format('Y-m-d')],
            "status[!]" => "ANULOWANA"
        ]);

        // zlicz zajęte miejsca per dzień
        $zajete = [];
        foreach ($rez as $r) {
            $d = $r["data_rezerwacji"];
            if (!isset($zajete[$d])) $zajete[$d] = 0;
            $zajete[$d]++;
        }

        // zbuduj listę terminów
        $terminy = [];
        $tmp = clone $start;
        for ($i = 0; $i < $days; $i++) {
            $d = $tmp->format('Y-m-d');
            $used = $zajete[$d] ?? 0;
            $free = max(0, $capacity - $used);

            $terminy[] = [
                "data" => $d,
                "wolne" => $free
            ];

            $tmp->modify('+1 day');
        }

        App::getSmarty()->assign('terminy', $terminy);
        App::getSmarty()->display('TermsView.tpl');
    }
}
