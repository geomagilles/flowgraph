<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Components\Begin;

use Geomagilles\FlowGraph\Box\Box;
use Geomagilles\FlowGraph\Point\InputPoint\InputPointInterface;
use Geomagilles\FlowGraph\Point\OutputPoint\OutputPointInterface;
use Geomagilles\FlowGraph\Point\TriggerPoint\TriggerPointInterface;

/**
 * Represents a begin task in a graph.
 */
class Begin extends Box implements BeginInterface
{
    public function createIO()
    {
        $this->createOutputPoint();
    }

    public function addOutputPoint(OutputPointInterface $point)
    {
        if (count($this->getOutputPoints()) == 1) {
            throw new \LogicException(sprintf('You can NOT add a new output to a begin box "%s"', $this->getName()));
        }
        return parent::addOutputPoint($point);
    }

    public function addInputPoint(InputPointInterface $point)
    {
        throw new \LogicException(sprintf('You can NOT add an input to a begin box "%s"', $this->getName()));
    }

    public function addTriggerPoint(TriggerPointInterface $point)
    {
        throw new \LogicException(sprintf('You can NOT add a trigger to a begin box "%s"', $this->getName()));
    }
}
