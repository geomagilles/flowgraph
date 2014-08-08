<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Components\Task;

use Geomagilles\FlowGraph\Box\BoxInterface;

/**
 * Represents a Task box.
 */
interface TaskInterface extends BoxInterface
{
    /**
     * Name for retry output 
     * @var string
     */
    const OUTPUT_RETRY = '__retry';

    /**
     * Has a job?
     * @return boolean 
     */
    public function hasJob();

    /**
     * Get job.
     * @return string 
     */
    public function getJob();

    /**
     * Set job.
     * @param string $job
     * @return self
     */
    public function setJob($job);

    /**
     * Add output.
     * @param string  $name
     * @throws \LogicException
     */
    public function withOutput($name = '');
}
