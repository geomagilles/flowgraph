<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Tests\Dumper;

use Geomagilles\FlowGraph\Dumper\GraphvizDumper;
use Geomagilles\FlowGraph\Tests\BaseTest;

/**
 * Test class for GraphvizDumper.
 */
class GraphvizDumperTest extends BaseTest
{
    /**
     * @var GraphvizDumper
     */
    private $dumper;

    /**
     * @var string
     */
    private static $graphvizFixturesPath;

    public function setUp()
    {
        $this->dumper = new GraphvizDumper();
    }

    public static function setUpBeforeClass()
    {
        //self::$graphvizFixturesPath = realpath(__DIR__ . '/../Fixtures/Graphviz');
    }

    public function testDumpEmptyPetrinet()
    {
        //$petrinet = require_once self::$graphvizFixturesPath . '/empty.php';
        //
        //$this->assertEquals(
        //    @file_get_contents(self::$graphvizFixturesPath . '/empty.dot'),
        //    $this->dumper->dump($petrinet)
        //);
    }

    public function testDump()
    {
        //$petrinet = require_once self::$graphvizFixturesPath . '/petrinet_1.php';
        //
        //$this->assertEquals(
        //    @file_get_contents(self::$graphvizFixturesPath . '/petrinet_1.dot'),
        //    $this->dumper->dump($petrinet)
        //);
    }
}
