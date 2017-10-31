<?php

declare(strict_types=1);

return [
    'debug' => false,
    \Zend\ConfigAggregator\ConfigAggregator::ENABLE_CACHE => true,

    'application' => [
        'name' => 'broetchen',
        'version' => 'dev',
    ],

    'dependencies' => [
        'aliases' => [
            \Oqq\Broetchen\Service\PasswordHashService::class => \Oqq\Broetchen\Service\NativePasswordHashService::class,
            \Oqq\Broetchen\Service\UserServiceInterface::class => \Oqq\Broetchen\Service\MongoUserService::class,
            \Oqq\Broetchen\Service\ServiceServiceInterface::class => \Oqq\Broetchen\Service\MongoServiceService::class,

            // Order Domain
            \Oqq\Broetchen\Domain\Order\OrderRepository::class => \Oqq\Broetchen\Repository\Order\MongoOrderRepository::class,
            \Oqq\Broetchen\Domain\Order\OrderService::class => \Oqq\Broetchen\Service\RepositoryOrderService::class,
        ],
        'factories' => [
            \Oqq\Broetchen\Middleware\JsonCommandMiddleware::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \Oqq\Broetchen\Service\NativePasswordHashService::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],

    \Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory::class => [

        \Oqq\Broetchen\Service\MongoUserService::class => [
            'collection.users',
            \Oqq\Broetchen\Service\PasswordHashService::class,
        ],
        \Oqq\Broetchen\Service\MongoServiceService::class => [
            'collection.services',
            \Oqq\Broetchen\Service\MongoUserService::class
        ],

        \Oqq\Broetchen\Middleware\PingMiddleware::class => [
            \Zend\Expressive\Hal\ResourceGenerator::class,
            \Zend\Expressive\Hal\HalResponseFactory::class,
        ],
        \Oqq\Broetchen\Middleware\LoginMiddleware::class => [
            \Oqq\Broetchen\Service\UserServiceInterface::class,
        ],
        \Oqq\Broetchen\Middleware\AuthenticationMiddleware::class => [
            \Oqq\Broetchen\Service\UserServiceInterface::class,
        ],
        \Oqq\Broetchen\Middleware\UserDataMiddleware::class => [
            \Oqq\Broetchen\Service\UserServiceInterface::class,
            \Zend\Expressive\Hal\ResourceGenerator::class,
            \Zend\Expressive\Hal\HalResponseFactory::class,
        ],
        \Oqq\Broetchen\Middleware\RegisterMiddleware::class => [
            \Oqq\Broetchen\Service\UserServiceInterface::class
        ],
        \Oqq\Broetchen\Middleware\FindServiceMiddleware::class => [
            \Oqq\Broetchen\Service\UserServiceInterface::class,
            \Oqq\Broetchen\Service\MongoServiceService::class,
            \Zend\Expressive\Hal\ResourceGenerator::class,
            \Zend\Expressive\Hal\HalResponseFactory::class,
        ],

        // Order Domain
        \Oqq\Broetchen\Repository\Order\MongoOrderRepository::class => [
            'collection.orders',
        ],

        \Oqq\Broetchen\Service\RepositoryOrderService::class => [
            \Oqq\Broetchen\Domain\Order\OrderRepository::class,
        ],

        \Oqq\Broetchen\Middleware\Order\OrderAddMiddleware::class => [
            \Oqq\Broetchen\Domain\Order\OrderService::class,
        ],
        \Oqq\Broetchen\Middleware\Order\OrderMiddleware::class => [
            \Oqq\Broetchen\Domain\Order\OrderService::class,
            \Zend\Expressive\Hal\ResourceGenerator::class,
            \Zend\Expressive\Hal\HalResponseFactory::class,
        ],
        \Oqq\Broetchen\Middleware\Order\OrdersMiddleware::class => [
            \Oqq\Broetchen\Domain\Order\OrderService::class,
            \Zend\Expressive\Hal\ResourceGenerator::class,
            \Zend\Expressive\Hal\HalResponseFactory::class,
        ],
    ],
];
