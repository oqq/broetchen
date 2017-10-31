<?php

declare(strict_types=1);

return [

    'dependencies' => [
        'factories' => [
            \MongoDB\Client::class => \Oqq\Broetchen\Container\MongoClientFactory::class,

            'collection.users' => [\Oqq\Broetchen\Container\MongoCollectionFactory::class, 'users'],
            'collection.services' => [\Oqq\Broetchen\Container\MongoCollectionFactory::class, 'services'],
            'collection.orders' => [\Oqq\Broetchen\Container\MongoCollectionFactory::class, 'orders'],
        ],
    ],

    'mongodb' => [
        'server' => 'mongodb://mongo',
        'database' => 'broetchen',
        'driverOptions' => [
            'typeMap' => [
                'root' => 'array',
                'document' => 'array',
                'array' => 'array',
            ],
        ],
    ],
];
