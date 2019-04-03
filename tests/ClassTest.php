<?php
/**
 *
 * ClassTest class
 *
 * @copyright Apereo
 * @category Test
 * @package  OpenLRW
 * @author   Xavier Chopin <bonjour@xavierchop.in>
 * @license  http://www.osedu.org/licenses/ECL-2.0 ECL-2.0 License
 */

declare(strict_types=1);

namespace Tests;

use OpenLRW\OpenLRW;
use OpenLRW\Model\Klass;
use PHPUnit\Framework\TestCase;

class ClassTest extends TestCase
{

    public function testClassShouldNotBeNull()
    {
        new OpenLRW(OpenLRWTest::URL, OpenLRWTest::KEY, OpenLRWTest::PASSWORD);
        OpenLRW::generateJwt();
        $class = Klass::find('1');
        $this->assertNotNull($class);
    }

    public function testAttributeShouldNotBeNull()
    {
        new OpenLRW(OpenLRWTest::URL, OpenLRWTest::KEY, OpenLRWTest::PASSWORD);
        OpenLRW::generateJwt();
        $class = Klass::find('1');
        $sourcedId = $class->sourcedId;
        $this->assertEquals('1', $sourcedId);
    }

}