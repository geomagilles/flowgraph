<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Tests\Flow\GraphFactory;

use Geomagilles\FlowGraph\Tests\BaseTest;
use Geomagilles\FlowGraph\Factory\Flow\GraphFactory;

/**
 * Test class for FlowGraphFactory.
 */
class FlowGraphFactoryTest extends BaseTest
{
    public function testCreateFlow\Graph()
    {
        $factory = new FlowGraphFactory();
        $element = $factory->CreateFlow\Graph();
        $this->assertSame('', $element->getName());
        $this->assertSame($factory, $element->getFlow\GraphFactory());
        $element = $factory->CreateFlow\Graph('new');
        $this->assertSame('new', $element->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Components\Graph\Flow\GraphInterface', $element);
    }

    public function testCreateArc()
    {
        $p1 = $this->getMock('Geomagilles\FlowGraph\Points\PointInterface');
        $p2 = $this->getMock('Geomagilles\FlowGraph\Points\PointInterface');
        $factory = new FlowGraphFactory();
        $element = $factory->createArc($p1, $p2);
        $this->assertSame('', $element->getName());
        $element = $factory->createArc($p1, $p2, 'new');
        $this->assertSame('new', $element->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Arc\ArcInterface', $element);
    }

    public function testCreatePoint()
    {
        $factory = new FlowGraphFactory();
        $element = $factory->createPoint();
        $this->assertSame('', $element->getName());
        $element = $factory->createPoint('new');
        $this->assertSame('new', $element->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Points\PointInterface', $element);
    }

    public function testCreateGraph()
    {
        $factory = new FlowGraphFactory();
        $element = $factory->createGraph();
        $this->assertSame('', $element->getName());
        $this->assertSame($factory, $element->getFlow\GraphFactory());
        $element = $factory->createGraph('new');
        $this->assertSame('new', $element->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Components\Graph\GraphInterface', $element);
    }

    public function testCreateTask()
    {
        $factory = new FlowGraphFactory();
        $element = $factory->createTask();
        $this->assertSame('', $element->getName());
        $this->assertSame($factory, $element->getFlow\GraphFactory());
        $element = $factory->createTask('new');
        $this->assertSame('new', $element->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Components\Units\Task\TaskInterface', $element);
    }

    public function testCreateComplexTask()
    {
        $factory = new FlowGraphFactory();
        $element = $factory->createDecision();
        $this->assertSame('', $element->getName());
        $this->assertSame($factory, $element->getFlow\GraphFactory());
        $element = $factory->createDecision('new');
        $this->assertSame('new', $element->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Components\Units\ComplexTask\ComplexTaskInterface', $element);
    }

    public function testCreateBeginTask()
    {
        $factory = new FlowGraphFactory();
        $element = $factory->createBegin();
        $this->assertSame('', $element->getName());
        $this->assertSame($factory, $element->getFlow\GraphFactory());
        $element = $factory->createBegin('new');
        $this->assertSame('new', $element->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Components\Units\Begin\BeginInterface', $element);
    }

    public function testCreateEndTask()
    {
        $factory = new FlowGraphFactory();
        $element = $factory->createEnd();
        $this->assertSame('', $element->getName());
        $this->assertSame($factory, $element->getFlow\GraphFactory());
        $element = $factory->createEnd('new');
        $this->assertSame('new', $element->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Components\Units\End\EndInterface', $element);
    }

    public function testCreateSynchronizer()
    {
        $factory = new FlowGraphFactory();
        $element = $factory->createSynchronizer();
        $this->assertSame('', $element->getName());
        $this->assertSame($factory, $element->getFlow\GraphFactory());
        $element = $factory->createSynchronizer('new');
        $this->assertSame('new', $element->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Components\Units\Synchronizer\SynchronizerInterface', $element);
    }
}
