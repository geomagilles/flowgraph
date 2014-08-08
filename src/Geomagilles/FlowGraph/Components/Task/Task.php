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
use Geomagilles\FlowGraph\Point\InputPoint\InputPointInterface;
use Geomagilles\FlowGraph\Point\TriggerPoint\TriggerPointInterface;

/**
 * Class representing an task box.
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
        $this->withOutput(TaskInterface::OUTPUT_RETRY);
    }

    public function addInputPoint(InputPointInterface $point)
    {
        if (count($this->getInputPoints()) == 1) {
            throw new \LogicException(sprintf('You can NOT add a new input to a task box "%s"', $this->getName()));
        }
        return parent::addInputPoint($point);
    }

    public function addTriggerPoint(TriggerPointInterface $point)
    {
        if (get_class($this) == __CLASS__) {
            throw new \LogicException(sprintf('You can NOT add a trigger to a task box "%s"', $this->getName()));
        }
        return parent::addTriggerPoint($point);
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

    public function withOutput($name = '')
    {
        // new output point
        $this->createOutputPoint($name);

        return $this;
    }
}
