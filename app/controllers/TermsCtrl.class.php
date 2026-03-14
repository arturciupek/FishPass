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

        // panel wyszukiwania
        $dataOd = isset($_GET['data_od']) && $_GET['data_od'] != '' ? $_GET['data_od'] : null;

        if ($dataOd) {
            $terminy = array_filter($terminy, fn($t) => $t['data'] >= $dataOd);
            $terminy = array_values($terminy); // resetuj klucze
        }

        $filtr = [
            'data_od'     => $dataOd
        ];

        // paginacja
        $naStrone = 10;
        $stronaAktualna = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $przesuniecie = ($stronaAktualna - 1) * $naStrone;

        // pobieramy +1 aby wiedzieć czy jest następna strona
        $terminyStrona = array_slice($terminy, $przesuniecie, $naStrone + 1);
        $jestNastepna = count($terminyStrona) > $naStrone;
        if ($jestNastepna) array_pop($terminyStrona);

        $liczbaStron = ceil(count($terminy) / $naStrone);

        $paginacja = [
            'stronaAktualna'  => $stronaAktualna,
            'stronaPoprzednia' => $stronaAktualna - 1,
            'stronaNastepna'  => $stronaAktualna + 1,
            'liczbaStron'     => $liczbaStron,
            'jestPoprzednia'  => $stronaAktualna > 1,
            'jestNastepna'    => $jestNastepna,
        ];

        App::getSmarty()->assign('terminy', $terminyStrona);
        App::getSmarty()->assign('paginacja', $paginacja);
        App::getSmarty()->assign('filtr', $filtr);
        App::getSmarty()->display('TermsView.tpl');
    }
}
