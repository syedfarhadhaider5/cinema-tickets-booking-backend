<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/register', 'UserController@register');
$router->post('/login', 'UserController@login');
$router->post('/logout', 'UserController@logout');
$router->get('/get-user-ticket/{id}', 'TicketController@getUserTicket');
$router->get('/get-user-tickets/{id}', 'TicketController@getUserTickets');

$router->group(['middleware' => 'token'], function () use ($router) {
    // Admin routes
    $router->group(['prefix' => 'admin', 'middleware' => 'admin'], function () use ($router) {
        // Define admin routes here
        $router->post('/movie/create', 'MovieController@create');
        $router->delete('/movie/remove/{id}', 'MovieController@remove');
        $router->get('/movie/{id}', 'MovieController@show');
        $router->get('/movies', 'MovieController@getMovies');
        $router->post('/movie/update/{id}', 'MovieController@update');

        // time slot
        $router->post('/timeslot/create', 'TimeSlotController@create');
        $router->post('/timeslot/update/{id}', 'TimeSlotController@update');
        $router->get('/timeslot/{id}', 'TimeSlotController@show');
        $router->get('/get-single-time-slot/{id}', 'TimeSlotController@singleSlotbyId');
    });

    // Normal user routes
    $router->group(['middleware' => 'normal'], function () use ($router) {
        // Define normal routes here
        // tickets
        $router->post('/ticket/book-ticket', 'TicketController@create');
        $router->delete('/ticket/remove/{id}', 'TicketController@remove');
        $router->get('/normal/movies', 'MovieController@getMovies');
        $router->get('/normal/movie/{id}', 'MovieController@show');
        $router->get('/get-single-time-slot/{id}', 'TimeSlotController@singleSlotbyId');

    });
});
