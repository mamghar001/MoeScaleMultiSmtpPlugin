<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Mautic\CoreBundle\DependencyInjection\MauticCoreExtension;
use MauticPlugin\MoeScaleMultiSmtpBundle\Mailer\Transport\MultiSmtpTransportFactory;
use Mautic\EmailBundle\Mailer\Transport\TransportFactory as BaseTransportFactory;

return function (ContainerConfigurator $configurator): void {
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services->load('MauticPlugin\\MoeScaleMultiSmtpBundle\\', '../')
        ->exclude('../{'.implode(',', MauticCoreExtension::DEFAULT_EXCLUDES).'}');

    $services->set(MultiSmtpTransportFactory::class)
        ->decorate(BaseTransportFactory::class);
};
