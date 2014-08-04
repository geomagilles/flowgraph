<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Events;

use Geomagilles\FlowGraph\Box\BoxInterface;

interface BoxEventInterface
{
    /**
     * Sets unit.
     * @param array $memento
     */
    public function setBox(BoxInterface $state);

    /**
     * Gets unit.
     * @return array $state
     */
    public function getBox();

    /**
     * Sets data.
     * @param mixed $data
     */
    public function setData($data);

    /**
     * Gets data.
     * @return mixed $data
     */
    public function getData();
}
