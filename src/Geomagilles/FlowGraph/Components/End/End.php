<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Components\End;

use Geomagilles\FlowGraph\Box\Box;
use Geomagilles\FlowGraph\Point\InputPoint\InputPointInterface;
use Geomagilles\FlowGraph\Point\OutputPoint\OutputPointInterface;
use Geomagilles\FlowGraph\Point\TriggerPoint\TriggerPointInterface;

/**
 * Represents a end task in a graph.
 */
class End extends Box implements EndInterface
{
    public function createIO()
    {
        $this->createInputPoint();
    }

    public function addInputPoint(InputPointInterface $point)
    {
        if (count($this->getInputPoints()) == 1) {
            throw new \LogicException(sprintf('You can NOT add a new input to a end box "%s"', $this->getName()));
        }
        return parent::addInputPoint($point);
    }

    public function addOutputPoint(OutputPointInterface $point)
    {
        throw new \LogicException(sprintf('You can NOT add an output to a end box "%s"', $this->getName()));
    }

    public function addTriggerPoint(TriggerPointInterface $point)
    {
        throw new \LogicException(sprintf('You can NOT add an trigger to a end box "%s"', $this->getName()));
    }
}
