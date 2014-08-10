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
use Geomagilles\FlowGraph\Points\InputPointInterface;
use Geomagilles\FlowGraph\Points\OutputPointInterface;

/**
 * Represents a begin task in a graph.
 */
class Begin extends Box implements BeginInterface
{
    public function createIO()
    {
        $this->addOutputPoint($this->factory->createOutputPoint());
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
}
