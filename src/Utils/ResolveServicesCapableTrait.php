<?php

declare(strict_types=1);

namespace Dhii\Services\Tools\Utils;

use Dhii\Services\ServiceInterface;

trait ResolveServicesCapableTrait
{
    /**
     * Resolves a list of keys into services.
     *
     * Keys that do not correspond to an existing service will be ignored.
     *
     * @param array<callable|ServiceInterface> $services The list of services to resolve from.
     * @param string[]                         $keys     The list of keys to resolve.
     *
     * @return array<callable|ServiceInterface> A mapping of keys to resolved services.
     */
    public function resolveServices(array $services, array $keys): array
    {
        $result = [];

        foreach ($keys as $key) {
            if (array_key_exists($key, $services)) {
                $result[$key] = $services[$key];
            }
        }

        return $result;
    }
}
