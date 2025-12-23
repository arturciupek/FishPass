<?php
namespace app\controllers;

use core\App;

class AuthCtrl {
    public function action_loginView() {
        App::getSmarty()->display("LoginView.tpl");
    }

    public function action_registerView() {
        App::getSmarty()->display("RegisterView.tpl");
    }
}
