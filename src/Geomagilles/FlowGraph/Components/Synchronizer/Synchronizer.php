<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Components\Synchronizer;

use Geomagilles\FlowGraph\Box\Box;
use Geomagilles\FlowGraph\Point\OutputPoint\OutputPointInterface;
use Geomagilles\FlowGraph\Point\TriggerPoint\TriggerPointInterface;

/**
 * Represents a synchronizer task in a graph.
 */
class Synchronizer extends Box implements SynchronizerInterface
{
    public function createIO()
    {
        $this->createOutputPoint();
    }

    public function input($name)
    {
        return array($this, $name);
    }

    public function addOutputPoint(OutputPointInterface $point)
    {
        if (count($this->getOutputPoints()) == 1) {
            throw new \LogicException(sprintf('You can NOT add a new output to a synchronizer box "%s"', $this->getName()));
        }
        return parent::addOutputPoint($point);
    }

    public function addTriggerPoint(TriggerPointInterface $point)
    {
        throw new \LogicException(sprintf('You can NOT add a trigger to a synchronizer box "%s"', $this->getName()));
    }
}
