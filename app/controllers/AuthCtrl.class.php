<?php
namespace app\controllers;

use core\App;
use core\Utils;
use core\Validator;
use core\RoleUtils;
use core\SessionUtils;

class AuthCtrl {

    public function action_loginView() {
        App::getSmarty()->display("LoginView.tpl");
    }

    public function action_registerView() {
        App::getSmarty()->display("RegisterView.tpl");
    }

    public function action_login() {
        $validate = new Validator();

        $email = $validate->validateFromPost('email', ['required'=>true, 'trim'=>true, 'email'=>true]);
        $pass  = $validate->validateFromPost('pass',  ['required'=>true, 'trim'=>true, 'escape'=>false]);

        if (App::getMessages()->isError()) {
            return $this->action_loginView();
        }

        $user = App::getDB()->get("uzytkownik", ["id_uzytkownika","email","haslo","utworzono"], ["email" => $email]);

        if (!$user || !password_verify($pass, $user["haslo"])) {
            Utils::addErrorMessage("Błędny email lub hasło.");
            return $this->action_loginView();
        }

        $role = App::getDB()->get("uzytkownik_rola", [
            "[>]rola" => ["rola_id_roli" => "id_roli"]
        ], "rola.nazwa", [
            "uzytkownik_rola.uzytkownik_id_uzytkownika" => $user["id_uzytkownika"]
        ]);

        if (!$role) $role = "user";

        RoleUtils::addRole($role);
        SessionUtils::store("user", ["id"=>$user["id_uzytkownika"], "email"=>$user["email"], "role"=>$role]);

        if ($role === "admin") {
            App::getRouter()->redirectTo('AdminView');
        } elseif ($role === "worker") { 
            App::getRouter()->redirectTo('StaffDayView');
        } else {
            App::getRouter()->redirectTo('homeView');
        }
    }

    public function action_register() {
        $validate = new Validator();

        $email = $validate->validateFromPost('email', ['required'=>true, 'trim'=>true, 'email'=>true]);
        $pass1 = $validate->validateFromPost('pass',  ['required'=>true, 'trim'=>true, 'escape'=>false]);
        $pass2 = $validate->validateFromPost('pass2', ['required'=>true, 'trim'=>true, 'escape'=>false]);

        if ($pass1 !== $pass2) {
            Utils::addErrorMessage("Hasła nie są takie same.");
        }

        if (App::getMessages()->isError()) {
            return $this->action_registerView();
        }

        if (App::getDB()->has("uzytkownik", ["email" => $email])) {
            Utils::addErrorMessage("Taki email już istnieje.");
            return $this->action_registerView();
        }

        $roleId = App::getDB()->get("rola", "id_roli", ["nazwa" => "user"]);

        App::getDB()->insert("uzytkownik", [
            "email" => $email,
            "haslo" => password_hash($pass1, PASSWORD_DEFAULT),
            "utworzono" => date('Y-m-d')
        ]);

        $userId = App::getDB()->id();

        App::getDB()->insert("uzytkownik_rola", [
            "uzytkownik_id_uzytkownika" => $userId,
            "rola_id_roli" => $roleId,
            "nadano" => date('Y-m-d'),
            "odebrano" => null
        ]);

        Utils::addInfoMessage("Konto utworzone. Zaloguj się.");
        SessionUtils::storeMessages();
        App::getRouter()->redirectTo('loginView');
    }

    public function action_logout() {
        RoleUtils::removeRole("user");
        RoleUtils::removeRole("worker");
        RoleUtils::removeRole("admin");
        SessionUtils::remove("user");

        App::getRouter()->redirectTo('loginView');
    }
}
