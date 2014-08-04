<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Tests\Boxes\Begin;

use Geomagilles\FlowGraph\Tests\BaseTest;
use Geomagilles\FlowGraph\Components\Units\Begin\Begin;

/**
 * Test class for a begin task.
 */
class BeginTest extends BaseTest
{
    public function testConstructor()
    {
        $task = new Begin();
        $this->assertInstanceOf('Geomagilles\FlowGraph\Box\BoxInterface', $task);
        $this->assertSame('', $task->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface', $task->getFlow\GraphFactory());
    }

    public function testConstructorWithName()
    {
        $task = new Begin('myName');
        $this->assertSame('myName', $task->getName());
    }

    public function testConstructorPointsCreation()
    {
        $point = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $factory
            ->expects($this->once())
            ->method('createPoint')
            ->will($this->returnValue($point));
        
        $task = new Begin('', $factory);
        $this->assertSame($factory, $task->getFlow\GraphFactory());
        $this->assertCount(0, $task->getInputPoints());
        $this->assertCount(1, $task->getOutputPoints());
        $this->assertSame(null, $task->getInputPoint());
        $this->assertSame($point, $task->getOutputPoint());
    }

    public function testGetPetriBuilder()
    {
        $task = new Begin();
        $this->assertInstanceOf('Geomagilles\FlowGraph\Petri\Builder\PetriBuilderInterface', $task->getPetriBuilder());
    }
}
