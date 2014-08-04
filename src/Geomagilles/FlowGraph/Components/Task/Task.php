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

use Geomagilles\FlowGraph\Box\Box;

/**
 * Class representing an decision box.
 */
class Task extends Box implements TaskInterface
{
    /**
     * The job.
     * @var string
     */
    protected $job;
    
    public function createIO()
    {
        $this->createInputPoint();
        $this->addCase(TaskInterface::OUTPUT_RETRY, true, true);
    }

    public function addCase($name = '', $transient = true, $final = true)
    {
        // new branch output point
        $output = $this->createOutputPoint($name);
        // store settings on new output point
        $output->setSettings(array(TaskInterface::TRIGGER_TRANSIENT=>$transient, TaskInterface::TRIGGER_FINAL=>$final));
    }

    public function hasJob()
    {
        return ! is_null($this->job);
    }

    public function getJob()
    {
        return $this->job;
    }

    public function setJob($job)
    {
        $this->job = $job;
        return $this;
    }
}
