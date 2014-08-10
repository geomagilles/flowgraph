<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Tests\Boxes\Task;

use Geomagilles\FlowGraph\Tests\BaseTest;
use Geomagilles\FlowGraph\Components\Units\Task\Task;

/**
 * Test class for a simple synchronous task.
 */
class TaskTest extends BaseTest
{
    public function testConstructor()
    {
        $task = new Task();
        $this->assertInstanceOf('Geomagilles\FlowGraph\Box\BoxInterface', $task);
        $this->assertSame('', $task->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface', $task->getFlow\GraphFactory());
    }

    public function testConstructorWithName()
    {
        $task = new Task('myName');
        $this->assertSame('myName', $task->getName());
    }

    public function testConstructorPointsCreation()
    {
        $point1 = $this->getMock('Geomagilles\FlowGraph\Points\PointInterface');
        $point2 = $this->getMock('Geomagilles\FlowGraph\Points\PointInterface');
        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $factory
            ->expects($this->at(0))
            ->method('createPoint')
            ->will($this->returnValue($point1));
        $factory
            ->expects($this->at(1))
            ->method('createPoint')
            ->will($this->returnValue($point2));
        
        $task = new Task('', $factory);
        $this->assertSame($factory, $task->getFlow\GraphFactory());
        $this->assertCount(1, $task->getInputPoints());
        $this->assertCount(1, $task->getOutputPoints());
        $this->assertSame($point1, $task->getInputPoint());
        $this->assertSame($point2, $task->getOutputPoint());
    }

    public function testGetPetriBuilder()
    {
        $task = new Task();
        $this->assertInstanceOf('Geomagilles\FlowGraph\Petri\Builder\PetriBuilderInterface', $task->getPetriBuilder());
    }
}
