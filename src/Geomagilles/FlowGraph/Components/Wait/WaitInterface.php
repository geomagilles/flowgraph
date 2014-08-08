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

use Geomagilles\FlowGraph\Components\Task\TaskInterface;
use Geomagilles\FlowGraph\Point\PointInterface;

/**
 * Represents a Wait box.
 */
interface WaitInterface extends TaskInterface
{
    /**
     * Name of transient property
     * @var string
     */
    const TRIGGER_TRANSIENT = 'transient';

    /**
     * Add trigger.
     * @param string  $name
     * @param boolean  is transient?
     * @throws \LogicException
     * @return self
     */
    public function withTrigger($name = '', $transient = true);
}
