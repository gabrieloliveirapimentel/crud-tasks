<?php

/** @var \Laravel\Lumen\Routing\Router $router */


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'status'], function () use ($router) {
    $router->get('', 'InfTasksStatusController@getAllStatus');
    $router->post('', 'InfTasksStatusController@createStatus');
    $router->get('{id}', 'InfTasksStatusController@getStatusById');
    $router->put('{id}', 'InfTasksStatusController@updateStatus');
    $router->delete('{id}', 'InfTasksStatusController@deleteStatus');
});

$router->group(['prefix' => 'tasks'], function () use ($router) {
    $router->get('', 'TasksController@getAllTasks');
    $router->post('', 'TasksController@createTask');
    $router->get('{id}', 'TasksController@getTasksById');
    $router->put('{id}', 'TasksController@updateTask');
    $router->delete('{id}', 'TasksController@deleteTask');
});

$router->group(['prefix' => 'logs'], function () use ($router) {
    $router->get('', 'LogsController@getAll');
    $router->get('{id}', 'LogsController@getLogById');
});