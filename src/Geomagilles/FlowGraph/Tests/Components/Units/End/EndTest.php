<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Tests\Boxes\End;

use Geomagilles\FlowGraph\Tests\BaseTest;
use Geomagilles\FlowGraph\Components\Units\End\End;

/**
 * Test class for an end task.
 */
class EndTest extends BaseTest
{
    public function testConstructor()
    {
        $task = new End();
        $this->assertInstanceOf('Geomagilles\FlowGraph\Box\BoxInterface', $task);
        $this->assertSame('', $task->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface', $task->getFlow\GraphFactory());
    }

    public function testConstructorWithName()
    {
        $task = new End('myName');
        $this->assertSame('myName', $task->getName());
    }

    public function testConstructorPointsCreation()
    {
        $point = $this->getMock('Geomagilles\FlowGraph\Points\PointInterface');
        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $factory
            ->expects($this->once())
            ->method('createPoint')
            ->will($this->returnValue($point));
        
        $task = new End('', $factory);
        $this->assertSame($factory, $task->getFlow\GraphFactory());
        $this->assertCount(1, $task->getInputPoints());
        $this->assertCount(0, $task->getOutputPoints());
        $this->assertSame($point, $task->getInputPoint());
        $this->assertSame(null, $task->getOutputPoint());
    }

    public function testGetPetriBuilder()
    {
        $task = new End();
        $this->assertInstanceOf('Geomagilles\FlowGraph\Petri\Builder\PetriBuilderInterface', $task->getPetriBuilder());
    }
}
