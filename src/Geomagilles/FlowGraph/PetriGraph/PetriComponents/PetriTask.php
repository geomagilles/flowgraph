<?php

/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriGraph\PetriComponents;

use Geomagilles\FlowGraph\Components\Task\TaskInterface;
use Geomagilles\FlowGraph\PetriGraph\factory\PetriBoxFactoryInterface;
use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBox;

class PetriTask extends PetriBox implements PetriTaskInterface
{
    /**
     * The job transition
     * @var TransitionInterface
     */
    protected $jobTransition;

    /**
     * The name of 'before' place
     * @var string
     */
    const PLACE_BEFORE = 'before';

    /**
     * The name of 'after' place
     * @var string
     */
    const PLACE_AFTER = 'after';

    /**
     * The name of 'idle' place
     * @var string
     */
    const PLACE_IDLE = 'idle';

    /**
     * The name of 'retry' place
     * @var string
     */
    const PLACE_RETRY = 'retry_';

    public function __construct(TaskInterface $task, PetriBoxFactoryInterface $petriBoxFactory)
    {
        parent::__construct($task, $petriBoxFactory);

        // job transition
        $work  = $this->createJobTransition();

        // input transition
        $input = $this->getInputTransition();

        // places
        $before = $this->addPlace(self::PLACE_BEFORE);
        $after  = $this->addPlace(self::PLACE_AFTER);
        $idle   = $this->addPlace(self::PLACE_IDLE);

        // arcs
        $this->addArc($idle, $input);
        $this->addArc($input, $before);
        $this->addArc($before, $work);
        $this->addArc($work, $after);

        foreach ($task->getOutputPoints() as $name => $point) {

            $output = $this->getOutputTransition($name);
            $trigger = $this->addTriggerPlace($name);
            $this->addArc($after, $output);
            $this->addArc($trigger, $output);

            $settings = $point->getSettings();
            if ($settings[TaskInterface::TRIGGER_TRANSIENT]) {
                    $transiant = $this->addTransition();
                    $this->addArc($trigger, $transiant);
                    $this->addArc($transiant, $idle);
                    $this->addArc($idle, $transiant);
            }

            if ($name == TaskInterface::OUTPUT_RETRY) {
                $this->addArc($output, $before);
            } else {
                if ($settings[TaskInterface::TRIGGER_FINAL]) {
                    // done
                    $this->addArc($output, $idle);
                } else {
                    // still wainting
                    $this->addArc($output, $after);
                }
            }
        }

        // reset state
        $this->resetState();
    }


    public function resetState()
    {
        // reset all tokens
        parent::resetState();

        // add a token to idle place
        $this->addTokenToPlace(self::PLACE_IDLE);
    }

    public function fireTrigger($name)
    {
        $place = $this->getPlace($name);

        if ($place->isTrigger()) {
            $this->petri->addTokenToPlace($place);
        } else {
            throw new \LogicException(
                sprintf(
                    'Place "%s" in box "%s" is not a trigger',
                    $name,
                    $this->box->getName()
                )
            );
        }
    }

    /**
     * Create a retry arc between an output and 
     * $param string $name
     * @return placeInterface;
     */
    protected function addRetryArc($name)
    {
        $input  = $this->getInputTransition();
        $output = $this->getOutputTransition($name);
        if (! $output->hasAnyOutputArc()) {
            $retry = $this->addPlace(self::PLACE_RETRY.$name);
            $this->addArc($output, $retry);
            $this->addArc($retry, $input);
        }
    }

    /**
     * Create a place used as a trigger
     * $param string $name
     * @return placeInterface;
     */
    protected function addTriggerPlace($name = '')
    {
        return $this->addPlace($name)->setTrigger(true);
    }

    /**
     * Create job as Petri transition.
     * @return transitionInterface;
     */
    protected function createJobTransition()
    {
        $this->jobTransition = $this->addTransition();
        
        if ($this->box->hasJob()) {
            $this->jobTransition->setJob($this->box->getJob());
        }

        return $this->jobTransition;
    }

    /**
     * Get job Petri transition
     * @return transitionInterface;
     */
    protected function getJobTransition()
    {
        return $this->jobTransition;
    }
}
