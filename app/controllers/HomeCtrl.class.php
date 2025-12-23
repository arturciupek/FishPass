<?php

namespace app\controllers;

use core\App;

class HomeCtrl {
    public function action_homeView() {
        App::getSmarty()->display("HomeView.tpl");
    }
}
