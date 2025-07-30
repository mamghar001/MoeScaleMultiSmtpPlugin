<?php

declare(strict_types=1);

namespace MauticPlugin\MoeScaleMultiSmtpBundle\Mailer\Transport;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mailer\Transport\Transports;
use Mautic\EmailBundle\Mailer\Transport\TransportFactory as BaseTransportFactory;

class MultiSmtpTransportFactory
{
    public function __construct(
        private BaseTransportFactory $inner,
        private Connection $connection,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @param array<string, string> $dsns
     */
    public function fromStrings(array $dsns): Transports
    {
        return $this->inner->fromStrings($dsns);
    }

    public function fromString(string $dsn): TransportInterface
    {
        $dsnObj = Dsn::fromString($dsn);
        if ('multismtp' === $dsnObj->getScheme()) {
            return new MultiSmtpTransport($this->connection, $this->logger);
        }

        return $this->inner->fromString($dsn);
    }

    public function fromDsnObject(Dsn $dsn): TransportInterface
    {
        if ('multismtp' === $dsn->getScheme()) {
            return new MultiSmtpTransport($this->connection, $this->logger);
        }

        return $this->inner->fromDsnObject($dsn);
    }
}
