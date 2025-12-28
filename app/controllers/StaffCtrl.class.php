<?php
namespace app\controllers;

use core\App;
use core\Utils;
use core\SessionUtils;

class StaffCtrl {

    public function action_staffDayView() {

        $data = $_GET['data'] ?? date('Y-m-d');

        $rezerwacje = App::getDB()->select("rezerwacja", [
            "[>]rodzaj_wkladki" => ["rodzaj_wkladki_id_rodzaju_wkladki" => "id_rodzaju_wkladki"],
            "[>]stanowisko"     => ["stanowisko_id_stanowiska" => "id_stanowiska"]
        ], [
            "rezerwacja.id_rezerwacji",
            "rezerwacja.data_rezerwacji",
            "rezerwacja.status",
            "rezerwacja.oplacona",
            "rodzaj_wkladki.nazwa(rodzaj_wkladki)",
            "rodzaj_wkladki.cena(cena)",
            "stanowisko.kod(stanowisko)"
        ], [
            "rezerwacja.data_rezerwacji" => $data,
            "ORDER" => ["rezerwacja.id_rezerwacji" => "ASC"]
        ]);

        App::getSmarty()->assign('page_title', 'FishPass — Rezerwacje na dzień');
        App::getSmarty()->assign('data', $data);
        App::getSmarty()->assign('rezerwacje', $rezerwacje);
        App::getSmarty()->display('StaffDayView.tpl');
    }

    public function action_staffChangeStatus() {

        $id = $_POST['id_rezerwacji'] ?? null;
        $status = $_POST['status'] ?? null;
        $data = $_POST['data'] ?? date('Y-m-d');

        if (!$id || !$status) {
            Utils::addErrorMessage("Brak danych do zmiany statusu.");
            SessionUtils::storeMessages();
            App::getRouter()->redirectTo('StaffDayView?data='.$data);
            return;
        }

        App::getDB()->update("rezerwacja", [
            "status" => $status
        ], [
            "id_rezerwacji" => (int)$id
        ]);

        Utils::addInfoMessage("Zmieniono status rezerwacji #$id na $status.");
        SessionUtils::storeMessages();
        App::getRouter()->redirectTo('StaffDayView?data='.$data);
    }
}
