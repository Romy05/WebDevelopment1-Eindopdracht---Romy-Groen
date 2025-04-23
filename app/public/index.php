<?php

require '../vendor/autoload.php';
session_start();

use \App\Controllers\HomeController;
use \App\Controllers\UserController;
use \App\Controllers\ServiceController;
use \App\Controllers\AppointmentController;
use \App\Api\Controllers\AppointmentApiController;
use \App\Api\Controllers\UserApiController;
use \App\Api\Controllers\ServiceApiController;


$uri = $_SERVER['REQUEST_URI'];
$homecontroller = new HomeController();
$usercontroller = new UserController();
$servicecontroller = new ServiceController();
$appointmentcontroller = new AppointmentController();
$appointmentapicontroller = new AppointmentApiController();
$userapicontroller = new UserApiController();
$serviceapicontroller = new ServiceApiController();

    switch($uri) {

        case '':
        case '/':
        case '/home': 
            $homecontroller->index();
            break;
        case '/login':
            $homecontroller->login();
            break;
        case '/settings':
            $homecontroller->settings();
            break;
        case '/settings/update':
            $userapicontroller->update();
            break;
        case '/register':
            $homecontroller->register();
            break;
        case '/logout':
            $homecontroller->logout();
            break;
        case '/user':
            $usercontroller->index();
            break;
        case preg_match('/^\/user\/create(\?.*)?$/', $uri) ? true : false:
            $usercontroller->create();
            break;
        case (preg_match('/^\/user\/delete\?id=(\d+)$/', $uri, $matches) ? true : false):
                $usercontroller->delete();
                break;
        case (preg_match('/^\/user\/edit\?id=(\d+)$/', $uri, $matches) ? true : false):
            $usercontroller->edit();
            break;
        case'/service':
            $servicecontroller->index();
            break;
        case '/service/create':
            $servicecontroller->create();
            break;
        case (preg_match('/^\/service\/delete\?id=(\d+)$/',$uri , $matches) ? true:false):
            $servicecontroller->delete();
            break;
        case (preg_match('/^\/service\/edit\?id=(\d+)$/',$uri , $matches) ? true:false):
            $servicecontroller->edit();
            break;
        
        case (preg_match('/^\/appointment(\?.*)?$/', $uri) ? true : false):
            $appointmentcontroller->index();
            break;
        case '/appointment/create/success':
            $appointmentcontroller->success();
            break;
        case '/appointment/create':
            $appointmentcontroller->create();
            break;
        case '/appointment/api':
            $appointmentapicontroller->index();
            break;
        case '/service/api':
            $serviceapicontroller->index();
            break;
        case '/user/api':
            $userapicontroller->index();
            break;
        case (preg_match('/^\/appointment\/create\/availability\?week=(\d+)$/', $uri) ? true : false):
            $appointmentapicontroller->getWeek();
            break;
        case preg_match('/^\/appointment\/create(\/service)?(\?.*)?$/', $uri) ? true : false:
            $appointmentcontroller->service();
            break;
        default:
            http_response_code(404);
            break;
    
}