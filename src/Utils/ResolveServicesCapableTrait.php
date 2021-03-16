<?php

declare(strict_types=1);

namespace Dhii\Services\Tools\Utils;

trait ResolveServicesCapableTrait
{
    /**
     * @param array $services
     * @param array $keys
     *
     * @return string[]
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
