<?php
/* (c) Anton Medvedev <anton@medv.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer\Console\Output;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OutputWatcher implements OutputInterface
{
    private OutputInterface $output;
    private bool $wasWritten = false;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function write($messages, $newline = false, $options = self::OUTPUT_NORMAL): void
    {
        $this->wasWritten = true;
        $this->output->write($messages, $newline, $options);
    }

    public function writeln($messages, $options = self::OUTPUT_NORMAL): void
    {
        $this->write($messages, true, $options);
    }

    public function setVerbosity($level): void
    {
        $this->output->setVerbosity($level);
    }

    public function getVerbosity(): int
    {
        return $this->output->getVerbosity();
    }

    public function setDecorated($decorated): void
    {
        $this->output->setDecorated($decorated);
    }

    public function isDecorated(): bool
    {
        return $this->output->isDecorated();
    }

    public function setFormatter(OutputFormatterInterface $formatter): void
    {
        $this->output->setFormatter($formatter);
    }

    public function getFormatter(): OutputFormatterInterface
    {
        return $this->output->getFormatter();
    }

    /**
     * @param boolean $wasWritten
     */
    public function setWasWritten(bool $wasWritten): void
    {
        $this->wasWritten = $wasWritten;
    }

    /**
     * @return boolean
     */
    public function getWasWritten(): bool
    {
        return $this->wasWritten;
    }

    public function isQuiet(): bool
    {
        return self::VERBOSITY_QUIET === $this->getVerbosity();
    }

    public function isVerbose(): bool
    {
        return self::VERBOSITY_VERBOSE <= $this->getVerbosity();
    }

    public function isVeryVerbose(): bool
    {
        return self::VERBOSITY_VERY_VERBOSE <= $this->getVerbosity();
    }

    public function isDebug(): bool
    {
        return self::VERBOSITY_DEBUG <= $this->getVerbosity();
    }
}
