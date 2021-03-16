<?php

declare(strict_types=1);

namespace Dhii\Services\Tools;

use Dhii\Services\ServiceInterface;

interface AnalyzerInterface
{
    /**
     * Analyzes a set of factories and extensions.
     *
     * @param array<callable|ServiceInterface> $factories  The list of factories to analyze.
     * @param array<callable|ServiceInterface> $extensions The list of extensions to analyze.
     *
     * @return iterable<Issue> A list of issues found during analysis.
     */
    public function analyze(array $factories, array $extensions): iterable;
}
