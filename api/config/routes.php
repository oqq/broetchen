<?php

declare(strict_types=1);

return function (\Zend\Expressive\Application $app): void {
    $app->route('/api/ping', \Oqq\Broetchen\Middleware\PingMiddleware::class);

    $app->post('/api/login', [
        \Oqq\Broetchen\Middleware\LoginMiddleware::class,
        \Oqq\Broetchen\Middleware\JsonCommandMiddleware::class,
    ]);

    $app->post('/api/register', [
        \Oqq\Broetchen\Middleware\RegisterMiddleware::class,
        \Oqq\Broetchen\Middleware\JsonCommandMiddleware::class,
    ]);

    $app->get('/api/user', [
        \Oqq\Broetchen\Middleware\UserDataMiddleware::class,
    ]);


    // ORDERS
    $app->post('/api/order', [
        \Oqq\Broetchen\Middleware\Order\OrderAddMiddleware::class,
        \Oqq\Broetchen\Middleware\JsonCommandMiddleware::class,
    ]);

    $app->get('/api/service/{pattern:.+}', [
        \Oqq\Broetchen\Middleware\FindServiceMiddleware::class,
        \Oqq\Broetchen\Middleware\JsonCommandMiddleware::class,
    ]);

    $app->get('/api/order/{order_id:[a-z0-9\-]{36}}', [
        \Oqq\Broetchen\Middleware\Order\OrderMiddleware::class,
    ], 'order');

    $app->get('/api/orders', [
        \Oqq\Broetchen\Middleware\Order\OrdersMiddleware::class,
    ], 'orders');
};
