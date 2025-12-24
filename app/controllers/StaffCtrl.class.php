<?php

namespace app\controllers;

use core\App;

class StaffCtrl {

    public function action_staffDayView() {
        App::getSmarty()->assign('page_title', 'FishPass — Rezerwacje na dzień');
        App::getSmarty()->display('StaffDayView.tpl');
    }
}
