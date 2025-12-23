<?php

use core\App;
use core\Utils;

App::getRouter()->setDefaultRoute('homeView'); #default action
App::getRouter()->setLoginRoute('loginView'); #action to forward if no permissions

Utils::addRoute('homeView', 'HomeCtrl');
Utils::addRoute('loginView', 'AuthCtrl');
Utils::addRoute('registerView', 'AuthCtrl');

