<?php

declare(strict_types=1);

namespace MauticPlugin\MoeScaleMultiSmtpBundle\Mailer\Transport;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MultiSmtpTransport implements TransportInterface
{
    private static int $counter = 0;

    public function __construct(
        private Connection $connection,
        private LoggerInterface $logger,
    ) {
    }

    public function send(RawMessage $message, ?Envelope $envelope = null): ?SentMessage
    {
        $servers = $this->fetchServers();
        if (0 === count($servers)) {
            throw new \RuntimeException('No enabled SMTP servers found.');
        }

        $index = self::$counter % count($servers);
        self::$counter++;
        $server = $servers[$index];

        $dsn = $this->buildDsn($server);
        $transport = Transport::fromDsn($dsn);

        try {
            return $transport->send($message, $envelope);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error(sprintf('SMTP send failed for %s: %s', $server['server'], $e->getMessage()));
            throw $e;
        }
    }

    public function __toString(): string
    {
        return 'multismtp://';
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function fetchServers(): array
    {
        $sql = 'SELECT * FROM smtp_servers WHERE enabled = 1 ORDER BY id';
        try {
            return $this->connection->fetchAllAssociative($sql);
        } catch (\Throwable $e) {
            $this->logger->error('Failed fetching SMTP servers: '.$e->getMessage());

            return [];
        }
    }

    /**
     * @param array<string, mixed> $server
     */
    private function buildDsn(array $server): string
    {
        $scheme = 'smtp';
        $user = $server['user_name'];
        $pass = $server['password'] ?? '';
        $host = $server['server'];
        $port = (int) $server['port'];
        $options = [];
        if (!empty($server['encryption']) && 'none' !== $server['encryption']) {
            $options['encryption'] = $server['encryption'];
        }
        if (!empty($server['auth_mode'])) {
            $options['auth_mode'] = $server['auth_mode'];
        }

        $dsn = sprintf('%s://%s:%s@%s:%d', $scheme, urlencode((string) $user), urlencode((string) $pass), $host, $port);
        if (!empty($options)) {
            $dsn .= '?'.http_build_query($options);
        }

        return $dsn;
    }
}
