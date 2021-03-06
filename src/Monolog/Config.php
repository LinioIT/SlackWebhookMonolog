<?php

namespace Pageon\SlackWebhookMonolog\Monolog;

use Monolog\Logger;
use Pageon\SlackWebhookMonolog\Monolog\Exceptions\InvalidLoggerLevelException;
use Pageon\SlackWebhookMonolog\Monolog\Interfaces\ConfigInterface;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
class Config implements ConfigInterface
{
    /**
     * @var int The lowest level that we should listen to.
     */
    private $level;

    /**
     * @var bool Do the events need to bubble further.
     */
    private $doesBubble;

    /**
     * Config constructor.
     *
     * @param int $level
     * @param bool $doesBubble
     */
    public function __construct($level, $doesBubble = true)
    {
        $this->setLevel($level);
        $this->doesBubble = $doesBubble;
    }

    /**
     * @param int $level
     *
     * @return self
     */
    private function setLevel($level)
    {
        $availableLevels = array_flip(Logger::getLevels());

        if (!isset($availableLevels[$level])) {
            throw new InvalidLoggerLevelException(
                sprintf(
                    'The level: "%d" does not exist. The available levels are: "%s"',
                    $level,
                    implode(', ', array_keys($availableLevels))
                ),
                400
            );
        }
        $this->level = $level;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * {@inheritdoc}
     */
    public function doesBubble()
    {
        return $this->doesBubble;
    }
}
