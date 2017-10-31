<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Container;

use Interop\Config\ConfigurationTrait;
use Interop\Config\RequiresConfig;
use Interop\Config\RequiresMandatoryOptions;
use MongoDB\Client;
use Psr\Container\ContainerInterface;

final class MongoClientFactory implements RequiresConfig, RequiresMandatoryOptions
{
    use ConfigurationTrait;

    public function __invoke(ContainerInterface $container): Client
    {
        $config = $container->get('config');
        $options = $this->options($config);

        return new Client(
            $options['server'],
            $options['uriOptions'] ?? [],
            $options['driverOptions'] ?? []
        );
    }

    public function dimensions(): iterable
    {
        return ['mongodb'];
    }

    public function mandatoryOptions(): iterable
    {
        return ['server'];
    }
}
