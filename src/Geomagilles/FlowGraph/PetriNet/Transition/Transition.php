<?php

/**
 * This file is part of the FlowGraph framejob.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriNet\Transition;

use Geomagilles\FlowGraph\Work\WorkInterface;
use Geomagilles\FlowGraph\Box\BoxInterface;
use Geomagilles\FlowGraph\Points\PointInterface;

class Transition extends \Petrinet\Transition\Transition implements TransitionInterface
{
    /**
     * The transition's name (if any)
     * @var string
     */
    protected $name = null;

    /**
     * The job (if any)
     * @var mixed
     */
    protected $job = null;

    /**
     * The input point (if any)
     * @var PointInterface
     */
    protected $input = null;

    /**
     * The output point (if any)
     * @var PointInterface
     */
    protected $output = null;

    /**
     * The trigger point (if any)
     * @var PointInterface
     */
    protected $trigger = null;

    /**
     * The box owning this transition
     * @var BoxInterface
     */
    protected $box;

    public function isInput()
    {
        return (! is_null($this->input));
    }

    public function getInput()
    {
        return $this->input;
    }

    public function setInput(PointInterface $input)
    {
        $this->input = $input;
        
        return $this;
    }

    public function isOutput()
    {
        return (! is_null($this->output));
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setOutput(PointInterface $output)
    {
        $this->output = $output;

        return $this;
    }

    public function isTrigger()
    {
        return (! is_null($this->trigger));
    }

    public function getTrigger()
    {
        return $this->trigger;
    }

    public function setTrigger(PointInterface $trigger)
    {
        $this->trigger = $trigger;

        return $this;
    }

    public function hasJob()
    {
        return (! is_null($this->job));
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

    public function getBox()
    {
        return $this->box;
    }

    public function setBox(BoxInterface $box)
    {
        $this->box = $box;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
