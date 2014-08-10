<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Tests\Boxes\Synchronizer;

use Geomagilles\FlowGraph\Tests\BaseTest;
use Geomagilles\FlowGraph\Components\Units\Synchronizer\Synchronizer;

/**
 * Test class for a simple synchronous task.
 */
class SynchronizerTest extends BaseTest
{
    public function testConstructor()
    {
        $synchronizer = new Synchronizer('sync');
        $this->assertInstanceOf('Geomagilles\FlowGraph\Box\BoxInterface', $synchronizer);
        $this->assertSame('sync', $synchronizer->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface', $synchronizer->getFlow\GraphFactory());
    }

    public function testConstructorPointsCreation()
    {
        $point = $this->getMock('Geomagilles\FlowGraph\Points\PointInterface');
        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $factory
            ->expects($this->once())
            ->method('createPoint')
            ->will($this->returnValue($point));
        
        $synchronizer = new Synchronizer('', $factory);
        $this->assertSame($factory, $synchronizer->getFlow\GraphFactory());
        $this->assertCount(0, $synchronizer->getInputPoints());
        $this->assertCount(1, $synchronizer->getOutputPoints());
        $this->assertSame($point, $synchronizer->getOutputPoint());
    }

    public function testGetPetriBuilder()
    {
        $synchronizer = new Synchronizer('sync');
        $this->assertInstanceOf('Geomagilles\FlowGraph\Petri\Builder\PetriBuilderInterface', $synchronizer->getPetriBuilder());
    }
}
