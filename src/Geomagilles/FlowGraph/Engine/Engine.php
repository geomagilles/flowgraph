<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

 namespace Geomagilles\FlowGraph\Engine;

use Geomagilles\FlowGraph\GraphInterface;
use Geomagilles\FlowGraph\PetriGraph\Factory\PetriBoxFactory;
use Geomagilles\FlowGraph\PetriGraph\Factory\PetriBoxFactoryInterface;
use Geomagilles\FlowGraph\Events\GraphEvent;
use Geomagilles\FlowGraph\Events\BoxEvent;

use Petrinet\Engine\Engine as PetrinetEngine;
use Petrinet\Engine\EngineInterface as PetrinetEngineInterface;
use Petrinet\PetrinetEvents;
use Petrinet\Petrinet;
use Petrinet\Event\PlaceEvent;
use Petrinet\Event\TransitionEvent;
use Petrinet\Event\EngineEvent;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Engine implements EngineInterface
{
    /**
     * The graph.
     * @var GraphInterface
     */
    protected $graph;

    /**
     * The petri graph.
     * @var PetriBoxInterface
     */
    protected $petriGraph;

    /**
     * The data.
     * @var array
     */
    protected $data = array();

   /**
     * The petrinet engine.
     * @var PetrinetEngineInterface
     */
    protected $engine;

   /**
     * The petri factory.
     * @var PetriBoxFactoryInterface
     */
    protected $factory;

    /**
     * This engine dispatcher.
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    public function __construct(
        PetrinetEngineInterface $engine = null,
        PetriBoxFactoryInterface $factory = null
    ) {
        // PetriBox factory
        $this->factory = is_null($factory) ? new PetriBoxFactory() : $factory;

        // Petrinet engine
        $this->engine = is_null($engine) ? new PetrinetEngine(new Petrinet(null)) : $engine;

        // Adding the listeners to the petrinet engine dispatcher
        $dispatcher = $this->engine->getDispatcher();
        $dispatcher->addListener(PetrinetEvents::AFTER_TOKEN_INSERT, array($this, 'afterTokenInsert'));
        $dispatcher->addListener(PetrinetEvents::BEFORE_TOKEN_CONSUME, array($this, 'beforeTokenConsume'));
        $dispatcher->addListener(PetrinetEvents::BEFORE_TRANSITION_FIRE, array($this, 'beforeTransitionFire'));
        $dispatcher->addListener(PetrinetEvents::AFTER_TRANSITION_FIRE, array($this, 'afterTransitionFire'));
        $dispatcher->addListener(PetrinetEvents::AFTER_ENGINE_STOP, array($this, 'engineStop'));
    }

    public function setGraph(GraphInterface $graph)
    {
        $this->graph = $graph;
        // Petri graph
        $this->petriGraph = $this->factory->create($graph);
        // Petrinet engine
        $this->engine->setPetrinet($this->petriGraph->getPetrinet());
        // Event dispatcher
        $this->dispatcher = $graph->getEventDispatcher();
    }

    public function getPetriGraph()
    {
        return $this->petriGraph;
    }
    
    public function resetState()
    {
        $this->petriGraph->resetState();

        return $this;
    }

    public function setState($state)
    {
        $this->petriGraph->setState($state);

        return $this;
    }

    public function getState()
    {
        return  $this->petriGraph->getState();
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function getData()
    {
        return  $this->data;
    }

    public function fireOutput($boxId, $name)
    {
        $petriBox = $this->petriGraph->getPetriBoxById($boxId);
        $petriBox->fireOutput($name);
    }
    
    public function run()
    {
        // dispatch ENGINE_START event
        $this->engineStart()
        // run engine
        $this->engine->setMode(PetrinetEngine::MODE_CONTINUOUS);
        $this->engine->start();
    }

    public function beforeTokenConsume(PlaceEvent $event)
    {
        // begin case
        if ($event->getPlace()->isBegin()) {
            $graphEvent = new GraphEvent($this->graph, $this->petriGraph->getState(), $this->data);
            $this->dispatcher->dispatch(GraphEvent::BEGIN, $graphEvent);
        }
    }

    public function afterTokenInsert(PlaceEvent $event)
    {
        // end case
        if ($event->getPlace()->isEnd()) {
            $graphEvent = new GraphEvent($this->graph, $this->petriGraph->getState(), $this->data);
            $this->dispatcher->dispatch(GraphEvent::END, $graphEvent);
        }
    }

    public function beforeTransitionFire(TransitionEvent $event)
    {
        $transition = $event->getTransition();

        // input case
        if ($transition->isInput()) {
            $boxEvent = new BoxEvent($transition->getBox(), $this->data);
            $this->dispatcher->dispatch(BoxEvent::BEFORE_BOX, $boxEvent);
        }

        // job case
        if ($transition->hasJob()) {
            $boxEvent = new BoxEvent($transition->getBox(), $this->data);
            $this->dispatcher->dispatch(BoxEvent::BEFORE_JOB, $boxEvent);
        }
    }

    public function afterTransitionFire(TransitionEvent $event)
    {
        $transition = $event->getTransition();
        
        // output case
        if ($transition->isOutput()) {
            $boxEvent = new BoxEvent($transition->getBox(), $this->data);
            $this->dispatcher->dispatch(BoxEvent::AFTER_BOX, $boxEvent);
        }

        // job case
        if ($transition->hasJob()) {
            $boxEvent = new BoxEvent($transition->getBox(), $this->data);
            $this->dispatcher->dispatch(BoxEvent::AFTER_JOB, $boxEvent);
        }
    }

    public function engineStart()
    {
        $graphEvent = new GraphEvent($this->graph, $this->petriGraph->getState(), $this->data);
        $this->dispatcher->dispatch(GraphEvent::ENGINE_START, $graphEvent);
    }

    public function engineStop(EngineEvent $event)
    {
        $graphEvent = new GraphEvent($this->graph, $this->petriGraph->getState(), $this->data);
        $this->dispatcher->dispatch(GraphEvent::ENGINE_STOP, $graphEvent);
    }
}
