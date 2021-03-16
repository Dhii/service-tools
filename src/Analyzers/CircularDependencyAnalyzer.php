<?php

declare(strict_types=1);

namespace Dhii\Services\Tools\Analyzers;

use Dhii\Services\Tools\AnalyzerInterface;
use Dhii\Services\Tools\Issue;
use Dhii\Services\Tools\Issues\CircularDepIssue;
use Dhii\Services\Tools\Utils\GetServiceDepsCapableTrait;
use Dhii\Services\Tools\Utils\ResolveServicesCapableTrait;

/**
 * Detects circular dependencies.
 */
class CircularDependencyAnalyzer implements AnalyzerInterface
{
    use GetServiceDepsCapableTrait;
    use ResolveServicesCapableTrait;

    /** @inheritDoc */
    public function analyze(array $factories, array $extensions): iterable
    {
        yield from $this->walk($factories, $factories);
        yield from $this->walk($factories, $extensions);
    }

    /**
     * Walks a list of services, recursively walking their dependencies while keeping track of what services have
     * already been visited. If a service is visited twice, an {@link Issue} is yielded.
     *
     * @param array $factories The entire list of factories. Used to resolve service/dependency keys.
     * @param array $toWalk    The list of services to walk.
     * @param array $visited   A dictionary of keys for the services that have been "walked". This acts as a buffer
     *                         stack and is used to detect when the walk re-visits an already visited service.
     * @param array $skip      A dictionary of keys for services that should be skipped. Services that were detected as
     *                         being a part of a circular dependency are added to this list to prevent reporting the
     *                         same circular chain multiple times.
     *
     * @return iterable<Issue>
     */
    protected function walk(array $factories, array $toWalk, array &$visited = [], array &$skip = []): iterable
    {
        foreach ($toWalk as $key => $service) {
            if (array_key_exists($key, $skip)) {
                continue;
            }

            if (array_key_exists($key, $visited)) {
                $skip = array_merge($skip, $visited);
                yield new CircularDepIssue(array_values($visited));
            } else {
                $visited[$key] = $key;

                $depKeys = $this->getServiceDeps($service);
                $depServices = $this->resolveServices($factories, $depKeys);

                yield from $this->walk($factories, $depServices, $visited, $skip);

                unset($visited[$key]);
            }
        }
    }
}
