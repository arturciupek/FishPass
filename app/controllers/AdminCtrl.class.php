<?php

namespace app\controllers;

use core\App;

class AdminCtrl {

    public function action_AdminView() {
        App::getSmarty()->assign('page_title', 'FishPass — Użytkownicy i role');
        App::getSmarty()->display('AdminView.tpl');
    }
}
