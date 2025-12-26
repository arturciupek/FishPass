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

        $user = App::getDB()->get("users", ["id","email","password_hash","role","created_at"], ["email" => $email]);

        if (!$user || !password_verify($pass, $user["password_hash"])) {
            Utils::addErrorMessage("Błędny email lub hasło.");
            return $this->action_loginView();
        }

        $role = $user["role"] ?? "user";

        RoleUtils::addRole($role);
        SessionUtils::store("user", ["id"=>$user["id"], "email"=>$user["email"], "role"=>$role]);

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

        if (App::getDB()->has("users", ["email" => $email])) {
            Utils::addErrorMessage("Taki email już istnieje.");
            return $this->action_registerView();
        }

        App::getDB()->insert("users", ["email" => $email, "password_hash" => password_hash($pass1, PASSWORD_DEFAULT), "role" => "user"]);

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
