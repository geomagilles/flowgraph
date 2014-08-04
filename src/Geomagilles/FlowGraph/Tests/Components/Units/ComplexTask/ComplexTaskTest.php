<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Tests\Boxes\ComplexTask;

use Geomagilles\FlowGraph\Tests\BaseTest;
use Geomagilles\FlowGraph\Components\Units\Decision\Decision;

/**
 * Test class for a complex  task.
 */
class ComplexTaskTest extends BaseTest
{
    public function testConstructor()
    {
        $task = new Decision();
        $this->assertInstanceOf('Geomagilles\FlowGraph\Box\BoxInterface', $task);
        $this->assertSame('', $task->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface', $task->getFlow\GraphFactory());
    }

    public function testConstructorWithName()
    {
        $task = new Decision('myName');
        $this->assertSame('myName', $task->getName());
    }

    public function testConstructorPointsCreation()
    {
        $input           = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $onTaskCompleted = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $onTaskCompleted
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(Decision::TASK_COMPLETED));
        $onTaskFailed    = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $onTaskFailed
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(Decision::TASK_FAILED));
        $onTaskTimeOut   = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $onTaskTimeOut
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(Decision::TASK_TIMEOUT));

        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $factory
            ->expects($this->at(0))
            ->method('createPoint')
            ->will($this->returnValue($input));
        $factory
            ->expects($this->at(1))
            ->method('createPoint')
            ->with(Decision::TASK_COMPLETED)
            ->will($this->returnValue($onTaskCompleted));
        $factory
            ->expects($this->at(2))
            ->method('createPoint')
            ->with(Decision::TASK_FAILED)
            ->will($this->returnValue($onTaskFailed));
        $factory
            ->expects($this->at(3))
            ->method('createPoint')
            ->with(Decision::TASK_TIMEOUT)
            ->will($this->returnValue($onTaskTimeOut));

        $task = new Decision('', $factory);
        $this->assertSame($factory, $task->getFlow\GraphFactory());
        $this->assertCount(1, $task->getInputPoints());
        $this->assertCount(3, $task->getOutputPoints());
        $this->assertSame($input, $task->getInputPoint());
        $this->assertSame($onTaskCompleted, $task->getOutputPoint(Decision::TASK_COMPLETED));
        $this->assertSame($onTaskFailed, $task->getOutputPoint(Decision::TASK_FAILED));
        $this->assertSame($onTaskTimeOut, $task->getOutputPoint(Decision::TASK_TIMEOUT));

    }

    public function testGetPetriBuilder()
    {
        $task = new Decision();
        $this->assertInstanceOf('Geomagilles\FlowGraph\Petri\Builder\PetriBuilderInterface', $task->getPetriBuilder());
    }
}
