<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Components\Wait;

use Geomagilles\FlowGraph\Components\Task\Task;
use Geomagilles\FlowGraph\Point\InputPoint\InputPointInterface;
use Geomagilles\FlowGraph\Point\OutputPoint\OutputPointInterface;

/**
 * Class representing an wait box.
 */
class Wait extends Task implements WaitInterface
{
    /**
     * The trigger points.
     * @var TriggerInterface[]
     */
    protected $triggerPoints = array();

    public function addInputPoint(InputPointInterface $point)
    {
        if (count($this->getInputPoints()) == 1) {
            throw new \LogicException(sprintf('You can NOT add a new input to a wait box "%s"', $this->getName()));
        }
        return parent::addInputPoint($point);
    }

    public function addOutputPoint(OutputPointInterface $point)
    {
        if (count($this->getOutputPoints()) == 2) {
            throw new \LogicException(sprintf('You can NOT add a new output to a wait box "%s"', $this->getName()));
        }
        return parent::addOutputPoint($point);
    }

    public function withTrigger($name = '', $transient = true)
    {
        // new trigger point
        $this->createTriggerPoint($name)->setSettings(array(WaitInterface::TRIGGER_TRANSIENT=>$transient));

        return $this;
    }
}
