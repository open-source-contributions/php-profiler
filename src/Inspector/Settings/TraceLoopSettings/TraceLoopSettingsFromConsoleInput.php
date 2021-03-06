<?php

/**
 * This file is part of the sj-i/php-profiler package.
 *
 * (c) sji <sji@sj-i.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpProfiler\Inspector\Settings\TraceLoopSettings;

use PhpProfiler\Inspector\Settings\InspectorSettingsException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

final class TraceLoopSettingsFromConsoleInput
{
    /**
     * @codeCoverageIgnore
     */
    public function setOptions(Command $command): void
    {
        $command
            ->addOption(
                'sleep-ns',
                's',
                InputOption::VALUE_OPTIONAL,
                'nanoseconds between traces (default: 1000 * 1000 * 10)'
            )
            ->addOption(
                'max-retries',
                'r',
                InputOption::VALUE_OPTIONAL,
                'max retries on contiguous errors of read (default: 10)'
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @return TraceLoopSettings
     * @throws InspectorSettingsException
     */
    public function createSettings(InputInterface $input): TraceLoopSettings
    {
        $sleep_nano_seconds = $input->getOption('sleep-ns');
        if (is_null($sleep_nano_seconds)) {
            $sleep_nano_seconds = TraceLoopSettings::SLEEP_NANO_SECONDS_DEFAULT;
        }
        $sleep_nano_seconds = filter_var($sleep_nano_seconds, FILTER_VALIDATE_INT);
        if ($sleep_nano_seconds === false) {
            throw TraceLoopSettingsException::create(
                TraceLoopSettingsException::SLEEP_NS_IS_NOT_INTEGER
            );
        }

        $max_retries = $input->getOption('max-retries');
        if (is_null($max_retries)) {
            $max_retries = TraceLoopSettings::MAX_RETRY_DEFAULT;
        }
        $max_retries = filter_var($max_retries, FILTER_VALIDATE_INT);
        if ($max_retries === false) {
            throw TraceLoopSettingsException::create(
                TraceLoopSettingsException::MAX_RETRY_IS_NOT_INTEGER
            );
        }

        return new TraceLoopSettings($sleep_nano_seconds, TraceLoopSettings::CANCEL_KEY_DEFAULT, $max_retries);
    }
}
