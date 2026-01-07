<?php
namespace app\controllers;

use core\App;

class AdminCtrl {

    public function action_AdminView() {
        App::getSmarty()->assign('page_title', 'FishPass — Panel administratora');
        App::getSmarty()->display('AdminView.tpl');
    }

    public function action_adminUsersView() {
        App::getSmarty()->assign('page_title', 'FishPass — Użytkownicy i role');

        // pobranie użytkowników
        $users = App::getDB()->select("uzytkownik", [
            "id_uzytkownika",
            "email"
        ], [
            "ORDER" => ["id_uzytkownika" => "ASC"]
        ]);

        // dopisanie aktywnej roli do użytkownika
        foreach ($users as &$u) {
            $roles = App::getDB()->select("uzytkownik_rola", [
                "[>]rola" => ["rola_id_roli" => "id_roli"]
            ], "rola.nazwa", [
                "uzytkownik_rola.uzytkownik_id_uzytkownika" => $u["id_uzytkownika"],
                "uzytkownik_rola.odebrano" => null
            ]);

            if (in_array("admin", $roles)) {
                $u["role"] = "admin";
            } elseif (in_array("worker", $roles)) {
                $u["role"] = "worker";
            } else {
                $u["role"] = "user";
            }
        }
        unset($u);

        App::getSmarty()->assign('users', $users);
        App::getSmarty()->display('AdminUsersView.tpl');
    }

    public function action_adminChangeRole() {

    $id   = $_POST['id_uzytkownika'];
    $rola = $_POST['rola'];

    if (!$id || !$rola) {
        App::getRouter()->redirectTo('adminUsersView');
        return;
    }

    $roleId = App::getDB()->get("rola", "id_roli", ["nazwa" => $rola]);

    // zamknięcie aktywnej roli
    App::getDB()->update("uzytkownik_rola", [
        "odebrano" => date('Y-m-d')
    ], [
        "uzytkownik_id_uzytkownika" => $id,
        "odebrano" => null
    ]);

    // reaktywacja pary jeśli para już kiedyś wystąpiła (zapobieganie duplikatom)
    // insert w przypadku nowej pary
    $existsPair = App::getDB()->has("uzytkownik_rola", [
        "uzytkownik_id_uzytkownika" => $id,
        "rola_id_roli" => $roleId
    ]);

    if ($existsPair) {
        App::getDB()->update("uzytkownik_rola", [
            "nadano" => date('Y-m-d'),
            "odebrano" => null
        ], [
            "uzytkownik_id_uzytkownika" => $id,
            "rola_id_roli" => $roleId
        ]);
    } else {
        App::getDB()->insert("uzytkownik_rola", [
            "uzytkownik_id_uzytkownika" => $id,
            "rola_id_roli" => $roleId,
            "nadano" => date('Y-m-d'),
            "odebrano" => null
        ]);
    }

    App::getRouter()->redirectTo('adminUsersView');
}

}
