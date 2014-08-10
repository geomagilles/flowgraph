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

use Symfony\Component\EventDispatcher\Event;
use Geomagilles\FlowGraph\Box\BoxInterface;

class BoxEvent extends Event implements BoxEventInterface
{
    const BEFORE_JOB = 'Geomagilles\FlowGraph.BoxEvent.BEFORE_JOB';

    const AFTER_JOB = 'Geomagilles\FlowGraph.BoxEvent.AFTER_JOB';

    /**
     * The box.
     */
    protected $box;

    /**
     * The data.
     */
    protected $data;

    /**
     * Creates a new BoxEvent event.
     *
     * @param PlaceInterface $place The place
     */
    public function __construct(BoxInterface $box, $data)
    {
        $this->box = $box;
        $this->data = $data;
    }

    public function setBox(BoxInterface $box)
    {
        $this->box = $box;
    }

    public function getBox()
    {
        return $this->box;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}
