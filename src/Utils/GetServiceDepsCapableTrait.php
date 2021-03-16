<?php

declare(strict_types=1);

namespace Dhii\Services\Tools\Utils;

use Dhii\Services\ServiceInterface;

trait GetServiceDepsCapableTrait
{
    /**
     * Retrieves a service's dependency keys.
     *
     * @param callable|ServiceInterface $service The service whose dependencies to retrieve.
     *
     * @return string[] The keys of the service's dependencies.
     */
    public function getServiceDeps($service): array
    {
        return ($service instanceof ServiceInterface)
            ? $service->getDependencies()
            : [];
    }
}
