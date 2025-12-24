<?php

namespace app\controllers;

use core\App;

class TermsCtrl {

    public function action_termsView() {
        App::getSmarty()->assign('page_title', 'FishPass — Terminy');
        App::getSmarty()->display('TermsView.tpl');
    }
}
