<?php

namespace app\controllers;

use core\App;
use core\Utils;
use core\Validator;
use core\SessionUtils;

class ReservationCtrl {

    private $rezerwacje;
    private $paginacja;
    private $filtr;
    
    public function action_reservationView() {
        App::getSmarty()->assign('page_title', 'FishPass — Rezerwacja');

        // lista rodzaju wkładek
        $wkladki = App::getDB()->select("rodzaj_wkladki",
            ["id_rodzaju_wkladki", "nazwa", "cena"],
            ["aktywna" => 1]
        );

        $stanowiska = App::getDB()->select("stanowisko",
            ["id_stanowiska", "kod"],
            ["aktywne" => 1]
        );

        App::getSmarty()->assign('wkladki', $wkladki);
        App::getSmarty()->assign('stanowiska', $stanowiska);

        $data = $_GET['data'] ?? null;
        App::getSmarty()->assign('data', $data);

        App::getSmarty()->display('ReservationView.tpl');
    }

    public function action_addReservation() {
        $validator = new Validator();

        $data = $validator->validateFromPost('data_rezerwacji', ['required'=>true, 'trim'=>true]);
        $wkladkaId = $validator->validateFromPost('rodzaj_wkladki_id_rodzaju_wkladki', ['required'=>true, 'trim'=>true]);
        $stanowiskoId = $validator->validateFromPost('stanowisko_id_stanowiska', ['required'=>true, 'trim'=>true]);

        if (App::getMessages()->isError()) {
            return $this->action_reservationView();
        }

        $user = SessionUtils::load("user", true);
        if (!$user || !isset($user["id"])) {
            Utils::addErrorMessage("Musisz być zalogowany, aby złożyć rezerwację.");
            App::getRouter()->redirectTo('loginView');
            return;
        }

        $exists = App::getDB()->has("rezerwacja", [
            "data_rezerwacji" => $data,
            "stanowisko_id_stanowiska" => (int)$stanowiskoId,
            "status[!]" => "ANULOWANA"
        ]);

        if ($exists) {
            Utils::addErrorMessage("To stanowisko jest już zajęte w tym terminie. Wybierz inne.");
            return $this->action_reservationView();
        }

        App::getDB()->insert("rezerwacja", [
            "data_rezerwacji" => $data,
            "status" => "AKTYWNA",
            "oplacona" => 0,
            "utworzono" => date('Y-m-d'),
            "uzytkownik_id_uzytkownika" => $user["id"],
            "rodzaj_wkladki_id_rodzaju_wkladki" => (int)$wkladkaId,
            "stanowisko_id_stanowiska" => (int)$stanowiskoId
        ]);

        Utils::addInfoMessage("Rezerwacja została dodana.");
        SessionUtils::storeMessages();
        App::getRouter()->redirectTo('reservationsView');
    }

    private function load_data() {

        $user = SessionUtils::load("user", true);

        if (!$user || !isset($user["id"])) {
            Utils::addErrorMessage("Musisz być zalogowany, aby zobaczyć rezerwacje.");
            App::getRouter()->redirectTo('loginView');
            return;
        }

         // panel wyszukiwania
        $status = isset($_REQUEST['status']) && $_REQUEST['status'] != '' ? $_REQUEST['status'] : null;

        // paginacja
        $naStrone = 10;
        $stronaAktualna = isset($_REQUEST['page']) ? max(1, (int)$_REQUEST['page']) : 1;
        $przesuniecie = ($stronaAktualna - 1) * $naStrone;

        // budowanie warunków
        $warunki = ["rezerwacja.uzytkownik_id_uzytkownika" => $user["id"]];
        
        if ($status) {
            $warunki["rezerwacja.status"] = $status;
        }

        $total = App::getDB()->count("rezerwacja", $warunki);

        $liczbaStron = ceil($total / $naStrone);

        $this->paginacja = [
            'stronaAktualna'  => $stronaAktualna,
            'stronaPoprzednia' => $stronaAktualna - 1,
            'stronaNastepna'  => $stronaAktualna + 1,
            'liczbaStron'     => $liczbaStron,
            'jestPoprzednia'  => $stronaAktualna > 1,
            'jestNastepna'    => $stronaAktualna < $liczbaStron
        ];

        $warunki["ORDER"] = ["rezerwacja.data_rezerwacji" => "DESC"];
        $warunki["LIMIT"] = [$przesuniecie, $naStrone];
    
        $this->rezerwacje = App::getDB()->select("rezerwacja", [
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
        ], $warunki);

        $this->filtr = ['status' => $status];
    }

    public function action_reservationCancel() {
        $v = new Validator();
        $id = $v->validateFromPost('id_rezerwacji', ['required'=>true, 'trim'=>true]);

        if (App::getMessages()->isError()) {
            App::getRouter()->redirectTo('reservationsView');
            return;
        }

        $user = SessionUtils::load("user", true);
        if (!$user || !isset($user["id"])) {
            Utils::addErrorMessage("Musisz być zalogowany.");
            App::getRouter()->redirectTo('loginView');
            return;
        }

        App::getDB()->update("rezerwacja", [
            "status" => "ANULOWANA"
        ], [
            "id_rezerwacji" => (int)$id,
            "uzytkownik_id_uzytkownika" => $user["id"]
        ]);

        Utils::addInfoMessage("Rezerwacja została anulowana.");
        SessionUtils::storeMessages();
        App::getRouter()->redirectTo('reservationsView');
    }

    public function action_reservationsList() {
        App::getSmarty()->assign('page_title', 'FishPass — Moje rezerwacje');
        $this->load_data();
        App::getSmarty()->assign('rezerwacje', $this->rezerwacje);
        App::getSmarty()->assign('paginacja', $this->paginacja);
        App::getSmarty()->assign('filtr', $this->filtr);
        App::getSmarty()->display('ReservationsViewFullPage.tpl');
    }

    public function action_reservationsListPart(){
        $this->load_data();
        App::getSmarty()->assign('rezerwacje', $this->rezerwacje);
        App::getSmarty()->assign('paginacja', $this->paginacja);
        App::getSmarty()->assign('filtr', $this->filtr);
        App::getSmarty()->display('ReservationsViewTable.tpl');
    }

}
