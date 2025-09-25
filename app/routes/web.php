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

$router->group(['prefix' => 'tasks'], function () use ($router) {
    $router->get('', 'TasksController@getAllTasks');
    $router->post('', 'TasksController@createTask');
    $router->get('{uuid}', 'TasksController@getTasksByUuid');
    $router->put('{uuid}', 'TasksController@updateTask');
    $router->delete('{uuid}', 'TasksController@deleteTask');
});