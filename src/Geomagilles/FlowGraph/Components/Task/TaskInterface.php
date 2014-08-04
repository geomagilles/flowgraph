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
     * Name for failed output 
     * @var string
     */
    const OUTPUT_FAILED = '__failed';

   /**
     * Name for timed out output 
     * @var string
     */
    const OUTPUT_TIMEDOUT = '__timedout';

    /**
     * Name for retry output 
     * @var string
     */
    const OUTPUT_RETRY = '__retry';

    /**
     * Keyword for transient trigger 
     * @var string
     */
    const TRIGGER_TRANSIENT = 'transient';

    /**
     * Keyword for final trigger 
     * @var string
     */
    const TRIGGER_FINAL = 'final';

    /**
     * Add case.
     * @param string  $name
     * @param boolean $transient
     * @param boolean $final
     * @throws \LogicException
     */
    public function addCase($name = '', $transient = true, $final = true);

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
}
