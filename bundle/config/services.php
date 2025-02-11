<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container): void {
    $services = $container->services();
    // load all files as services
    $services->load('Hyvor\\Internal\\Bundle\\', '../src');
};