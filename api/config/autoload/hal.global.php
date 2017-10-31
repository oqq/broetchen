<?php

declare(strict_types=1);

return [
    \Zend\Expressive\Hal\Metadata\MetadataMap::class => [
        [
            '__class__' => \Zend\Expressive\Hal\Metadata\RouteBasedResourceMetadata::class,
            'resource_class' => \Oqq\Broetchen\Domain\Order\Order::class,
            'extractor' => \Zend\Hydrator\ArraySerializable::class,
            'route' => 'order',
            'resource_identifier' => 'order_id',
            'route_identifier_placeholder' => 'order_id',
        ],
        [
            '__class__' => \Zend\Expressive\Hal\Metadata\RouteBasedCollectionMetadata::class,
            'collection_class' => \Oqq\Broetchen\Domain\Order\OrderCollection::class,
            'collection_relation' => 'order',
            'route' => 'orders',
        ],
    ],
];
