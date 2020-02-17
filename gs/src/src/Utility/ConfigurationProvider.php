<?php

namespace App\Utility;

use App\Utility\Log;
use Exception;
use Throwable;

abstract class ConfigurationProvider
{

    /** @var string  */
    public const SHARD_NAME = 'SHARD_NAME';
    /** @var string  */
    public const LISTEN_PORT = 'LISTEN_PORT';

    /**
     * @param string $key
     * @return string
     * @throws Throwable
     */
    public static function get(string $key): string
    {
        $value = getenv($key);
        if (false === $value) {
            $errorMessage = sprintf('No environment variables with name %s available.', $key);
            Log::error($errorMessage, ['key' => $key]);
            throw new Exception($errorMessage);
        }
        return $value;
    }

}