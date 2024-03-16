<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('/login', 'Login::login_action');
$routes->get('/admin/home', 'Admin\Home::index');
$routes->get('/pegawai/home', 'Pegawai\Home::index');
