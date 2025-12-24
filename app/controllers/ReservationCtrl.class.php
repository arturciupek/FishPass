<?php

namespace app\controllers;

use core\App;

class ReservationCtrl {

    public function action_reservationView() {
        App::getSmarty()->assign('page_title', 'FishPass — Rezerwacja');
        App::getSmarty()->display('ReservationView.tpl');
    }

    public function action_reservationsView() {
        App::getSmarty()->assign('page_title', 'FishPass — Moje rezerwacje');
        App::getSmarty()->display('ReservationsView.tpl');
    }
}
