<?php

namespace Dhii\Services\Tools;

interface AnalyzerInterface
{
    /**
     * @param array $factories
     * @param array $extensions
     *
     * @return iterable<Issue>
     */
    public function analyze(array $factories, array $extensions): iterable;
}
