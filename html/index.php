<?php

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

// Init.
$app = new Proton\Application();
$app['debug'] = true;
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Account routes.
$app->post('/login', function($request, $response) {
    $result = App\Api\AccountApi::login($request->get('email'), $request->get('password'));
    if ($result['success'] === true) {
        setcookie('token', serialize($result['data']));
    }
    $response->setContent(json_encode($result));
    return $response;
});

$app->get('/user/{id}', function($request, $response, $args) {
    $api = new App\Api\AccountApi();
    $response->setContent(json_encode($api->getUser($args['id'])));
    return $response;
});

$app->get('/employees', function($request, $response) {
    $api = new App\Api\UserApi();
    $response->setContent(json_encode($api->getAllEmployees()));
    return $response;
});

// Shift routes.
$app->get('/shifts', function($request, $response) {
    $api = new App\Api\ShiftApi();
    $response->setContent(json_encode($api->getAll()));
    return $response;
});

$app->get('/my-shifts', function($request, $response) use ($app) {
    $api = new App\Api\ShiftApi();
    $response->setContent(json_encode($api->getMyShifts($app->user->getId())));
    return $response;
});

$app->get('/shifts-by-date-range/{start}/{end}', function($request, $response, $args) {
    $api = new App\Api\ShiftApi();
    $response->setContent(json_encode($api->getByDateRange(
        new \DateTime(urldecode($args['start'])), new \DateTime(urldecode($args['end']))
    )));
    return $response;
});

$app->get('/shift/{id}', function($request, $response, $args) {
    $api = new App\Api\ShiftApi();
    $response->setContent(json_encode($api->get($args['id'])));
    return $response;
});

$app->get('/weekly-summary', function($request, $response) use ($app) {
    $api = new App\Api\ShiftApi();
    $response->setContent(json_encode($api->getWeeklySummary($app->user->getId())));
    return $response;
});

$app->post('/shift', function($request, $response) use ($app) {
    $api = new App\Api\ShiftApi();
    $response->setContent(json_encode($api->save([
        'manager_id' => $app->user->getId(),
        'employee_id' => $request->get('employee_id'),
        'break' => $request->get('break'),
        'start_time' => new DateTime($request->get('start_time')),
        'end_time' => new DateTime($request->get('end_time')),
        'created_at' => new DateTime(),
    ])));
    return $response;
});

$app->put('/shift', function($request, $response) use ($app) {
    $api = new App\Api\ShiftApi();
    $response->setContent(json_encode($api->save([
        'id' => $request->get('id'),
        'manager_id' => $request->get('manager_id'),
        'employee_id' => $request->get('employee_id'),
        'break' => $request->get('break'),
        'start_time' => new DateTime($request->get('start_time')),
        'end_time' => new DateTime($request->get('end_time'))
    ])));
    return $response;
});

// Main routes.
$app->get('/', function($request, $response) {
    $response->setContent(file_get_contents('view/index.html'));
    return $response;
});

// Middleware
$stack = (new Stack\Builder())
    ->push('App\Middleware\Auth');

// Resolve and run.
$app = $stack->resolve($app);
Stack\Run($app);