<?php

/** @var \Laravel\Lumen\Routing\Router $router */


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'status'], function () use ($router) {
    $router->get('', 'InfTasksStatusController@getAllStatus');
    $router->post('', 'InfTasksStatusController@createStatus');
    $router->get('{uuid}', 'InfTasksStatusController@getStatusByUuid');
    $router->put('{uuid}', 'InfTasksStatusController@updateStatus');
    $router->delete('{uuid}', 'InfTasksStatusController@deleteStatus');
});