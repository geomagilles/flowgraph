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
use Geomagilles\FlowGraph\Points\OutputPointInterface;

/**
 * Represents a synchronizer task in a graph.
 */
class Synchronizer extends Box implements SynchronizerInterface
{
    public function createIO()
    {
        $this->addOutputPoint($this->factory->createOutputPoint());
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
}
