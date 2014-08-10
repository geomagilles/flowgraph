<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Tests\Graph\Arc;

use Geomagilles\FlowGraph\Tests\BaseTest;
use Geomagilles\FlowGraph\Arc\Arc;

/**
 * Test class for Arc.
 */
class ArcTest extends BaseTest
{
    public function testConstructor()
    {
        $p1 = $this->getMock('Geomagilles\FlowGraph\Points\PointInterface');
        $p2 = $this->getMock('Geomagilles\FlowGraph\Points\PointInterface');
        $p1->expects($this->once())->method('addArc');
        $p2->expects($this->once())->method('addArc');
        $arc = new Arc($p1, $p2);
        $this->assertInstanceOf('Geomagilles\FlowGraph\Element\ElementInterface', $arc);
        $this->assertSame('', $arc->getName());
        $this->assertSame($p1, $arc->getBeginPoint());
        $this->assertSame($p2, $arc->getEndPoint());
    }

    public function testConstructorWithName()
    {
        $p1 = $this->getMock('Geomagilles\FlowGraph\Points\PointInterface');
        $p2 = $this->getMock('Geomagilles\FlowGraph\Points\PointInterface');
        $arc = new Arc($p1, $p2, 'myArc');
        $this->assertSame('myArc', $arc->getName());
    }
}
