<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

//declaration satu satu
return function (App $app) {
    $app->get('/Testt', \App\Action\Testt::class); //get/{id}
    $app->post('/create', \App\Action\staff\RegisterStaff::class);
    $app->get('/read/{id}', \App\Action\staff\ViewStaff::class);
    $app->get('/read', \App\Action\staff\ListStaffs::class);
    $app->put('/update/{id}', \App\Action\staff\UpdateStaff::class);
    $app->delete('/delete/{id}', \App\Action\staff\StaffDeleter::class);
    
//declaration group 
    $app->group('/staff', function (RouteCollectorProxy $group) {

    $group->post('/', \App\Action\staff\RegisterStaff::class);
    $group->get('/{id}', \App\Action\staff\ViewStaff::class);
    $group->get('/',\App\Action\staff\ListStaffs::class)->add(\App\Middleware\AuthMiddleware::class);
    $group->put('/{id}', \App\Action\staff\UpdateStaff::class);
    $group->delete('/{id}', \App\Action\staff\StaffDeleter::class);

      
    });

  // Account
//   $app->group('/account', function (RouteCollectorProxy $group) {

//     $group->post('/signin', \App\Action\Account\Authenticate::class);
//     $group->options('/signin', function (ServerRequestInterface $request, ResponseInterface $response) {
//       return $response;
//     });

//     $group->post('/', \App\Action\Account\Employee\RegisterEmployee::class)->add(\App\Middleware\AuthMiddleware::class);
//     $group->get('/', \App\Action\Account\Employee\ListEmployees::class)->add(\App\Middleware\AuthMiddleware::class);
//     $group->options('/', function (ServerRequestInterface $request, ResponseInterface $response) {
//       return $response;
//     });

//     $group->get('/{id}', \App\Action\Account\Employee\ViewEmployee::class)->add(\App\Middleware\AuthMiddleware::class);
//     $group->put('/{id}', \App\Action\Account\Employee\UpdateEmployee::class)->add(\App\Middleware\AuthMiddleware::class);
//     $group->options('/{id}', function (ServerRequestInterface $request, ResponseInterface $response) {
//       return $response;
//     });
//   });
};

