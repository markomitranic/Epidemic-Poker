<?php

namespace App;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

final class Log {

    /** @var string  */
    private const OUTPUT_STREAM = 'php://stderr';

    /**
     * @var LoggerInterface
     */
    protected static $instance;

    public static function getLogger(): LoggerInterface
    {
        if (!self::$instance) {
            self::configureInstance();
        }
        return self::$instance;
    }

    protected static function configureInstance(): LoggerInterface
    {
        $logger = new Logger('log');
        $logger->pushHandler(new StreamHandler(self::OUTPUT_STREAM, self::getLoggingLevel()));
        self::$instance = $logger;
        return self::$instance;
    }

    public static function getLoggingLevel(): int
    {
        if (getenv('LOGGING_LEVEL') === 'debug') {
            return Logger::DEBUG;
        }
        return Logger::ERROR;
    }

    public static function debug(string $message, array $context = []): void
    {
        self::getLogger()->debug($message, $context);
    }

    public static function info(string $message, array $context = []): void
    {
        self::getLogger()->info($message, $context);
    }

    public static function notice(string $message, array $context = []): void
    {
        self::getLogger()->notice($message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::getLogger()->warning($message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::getLogger()->error($message, $context);
    }

    public static function critical(string $message, array $context = []): void
    {
        self::getLogger()->critical($message, $context);
    }

    public static function alert(string $message, array $context = []): void
    {
        self::getLogger()->alert($message, $context);
    }

    public static function emergency(string $message, array $context = []): void
    {
        self::getLogger()->emergency($message, $context);
    }

}