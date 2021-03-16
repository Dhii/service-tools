<?php

namespace Dhii\Services\Tools\Utils;

use Dhii\Services\ServiceInterface;

trait GetServiceDepsCapableTrait
{
    /**
     * @param callable|ServiceInterface $keys
     *
     * @return string[]
     */
    public function getServiceDeps($keys): array
    {
        return ($keys instanceof ServiceInterface)
            ? $keys->getDependencies()
            : [];
    }
}
