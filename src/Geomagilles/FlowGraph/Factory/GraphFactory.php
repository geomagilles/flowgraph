<?php

/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Factory;

use Illuminate\Support\Str;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Geomagilles\FlowGraph\Points\PointInterface;

class GraphFactory implements GraphFactoryInterface
{
    /**
     * The Input Point type
     * @var string
     */
    const INPUT_POINT = 'INPUT';

    /**
     * The Output Point type
     * @var string
     */
    const OUTPUT_POINT = 'OUTPUT';

    /**
     * The Arc type
     * @var string
     */
    const ARC = 'ARC';

    /**
     * The Graph type
     * @var string
     */
    const GRAPH = 'GRAPH';

    /**
     * The Begin type
     * @var string
     */
    const BEGIN = 'BEGIN';

    /**
     * The End type
     * @var string
     */
    const END = 'END';

    /**
     * The Task type
     * @var string
     */
    const TASK = 'TASK';

    /**
     * The Wait type
     * @var string
     */
    const WAIT = 'WAIT';

    /**
     * The Synchronizer type
     * @var string
     */
    const SYNCHRONIZER = 'SYNCHRONIZER';

    /**
     * The event Dispatcher 
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher = null)
    {
        $this->eventDispatcher = is_null($eventDispatcher) ? new EventDispatcher() : $eventDispatcher;

        $this->typeClass = array(
            self::INPUT_POINT   => 'Geomagilles\FlowGraph\Points\InputPoint',
            self::OUTPUT_POINT  => 'Geomagilles\FlowGraph\Points\OutputPoint',
            self::ARC           => 'Geomagilles\FlowGraph\Arc\Arc',
            self::GRAPH         => 'Geomagilles\FlowGraph\Graph',
            self::BEGIN         => 'Geomagilles\FlowGraph\Components\Begin\Begin',
            self::END           => 'Geomagilles\FlowGraph\Components\End\End',
            self::TASK          => 'Geomagilles\FlowGraph\Components\Task\Task',
            self::WAIT          => 'Geomagilles\FlowGraph\Components\Wait\Wait',
            self::SYNCHRONIZER  => 'Geomagilles\FlowGraph\Components\Synchronizer\Synchronizer');
    }

    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    public function newObject($type, $name = '')
    {
        $class = $this->getClass($type);
        return new $class($this, $name);
    }

    public function createObject($type, $name = '')
    {
        $object = $this->newObject($type, $name);
        if (method_exists($object, 'createIO')) {
            $object->createIO();
        }
        return $object;
    }
    
    /**
     * Dynamically pass calls to the default connection.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    //public function __call($method, $parameters)
    //{
    //    if (Str::startsWith($method, 'is')) {
    //        $var = $this->getConstantName(substr($method, -2));
    //        $obj = $parameters[0];
    //        return $this->getType($obj) === self::$var;
    //    } elseif (Str::startsWith($method, 'new')) {
    //        $var = $this->getConstantName(substr($method, -3));
    //        $name = count($parameters)==0 ? '' : $parameters[0];
    //        return $this->newObject(self::$var, $name);
    //    } elseif (Str::startsWith($method, 'create')) {
    //        $var = $this->getConstantName(substr($method, -6));
    //        $name = count($parameters)==0 ? '' : $parameters[0];
    //        return $this->createObject(self::$var, $name);
    //    } else {
    //        throw new \Exception("Unknown method \"$method\" in ".__CLASS__);
    //    }
    //}

    private function getConstantName($string)
    {
        $var = Str::upper(Str::snake($string));
        if (isset($this->typeClass[$var])) {
            return $var;
        } else {
            throw new \Exception("Unknown variable \"$var\" in ".__CLASS__);
        }
    }

    public function isArc($obj)
    {
        return $this->getType($obj) === self::ARC;
    }

    public function newArc($name = '')
    {
        return $this->newObject(self::ARC, $name);
    }

    public function createArc(PointInterface $beginPoint, PointInterface $endPoint, $name = '')
    {
        $arc = $this->newArc($name);
        $arc->setBeginPoint($beginPoint);
        $arc->setEndPoint($endPoint);
        return $arc;
    }

    public function isInputPoint($obj)
    {
        return $this->getType($obj) === self::INPUT_POINT;
    }

    public function newInputPoint($name = '')
    {
        return $this->newObject(self::INPUT_POINT, $name);
    }

    public function createInputPoint($name = '')
    {
        return $this->createObject(self::INPUT_POINT, $name);
    }

    public function isOutputPoint($obj)
    {
        return $this->getType($obj) === self::OUTPUT_POINT;
    }

    public function newOutputPoint($name = '')
    {
        return $this->newObject(self::OUTPUT_POINT, $name);
    }

    public function createOutputPoint($name = '')
    {
        return $this->createObject(self::OUTPUT_POINT, $name);
    }

    public function isGraph($obj)
    {
        return $this->getType($obj) === self::GRAPH;
    }

    public function newGraph($name = '')
    {
        return $this->newObject(self::GRAPH, $name);
    }

    public function createGraph($name = '')
    {
        return $this->createObject(self::GRAPH, $name);
    }

    public function isBegin($obj)
    {
        return $this->getType($obj) === self::BEGIN;
    }

    public function newBegin($name = '')
    {
        return $this->newObject(self::BEGIN, $name);
    }

    public function createBegin($name = '')
    {
        return $this->createObject(self::BEGIN, $name);
    }

    public function isEnd($obj)
    {
        return $this->getType($obj) === self::END;
    }

    public function newEnd($name = '')
    {
        return $this->newObject(self::END, $name);
    }

    public function createEnd($name = '')
    {
        return $this->createObject(self::END, $name);
    }

    public function isTask($obj)
    {
        return $this->getType($obj) === self::TASK;
    }

    public function newTask($name = '')
    {
        return $this->newObject(self::TASK, $name);
    }

    public function createTask($name = '')
    {
        return $this->createObject(self::TASK, $name);
    }

    public function isWait($obj)
    {
        return $this->getType($obj) === self::WAIT;
    }

    public function newWait($name = '')
    {
        return $this->newObject(self::WAIT, $name);
    }

    public function createWait($name = '')
    {
        return $this->createObject(self::WAIT, $name);
    }

    public function isSynchronizer($obj)
    {
        return $this->getType($obj) === self::SYNCHRONIZER;
    }

    public function newSynchronizer($name = '')
    {
        return $this->newObject(self::SYNCHRONIZER, $name);
    }

    public function createSynchronizer($name = '')
    {
        return $this->createObject(self::SYNCHRONIZER, $name);
    }

    public function getType($obj)
    {
        $type = array_search(get_class($obj), $this->typeClass, true);
        if ($type) {
            return $type;
        } else {
            return null;
        }
    }

    private function getClass($type)
    {
        if (isset($this->typeClass[$type])) {
            return $this->typeClass[$type];
        } else {
            throw new \LogicException(
                sprintf('unknown type : %s', $type)
            );
        }
    }
}
