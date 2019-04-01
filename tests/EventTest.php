<?php
/**
 *
 * EventTest class
 *
 * @copyright Apereo
 * @category Test
 * @package  OpenLRW
 * @author   Xavier Chopin <bonjour@xavierchop.in>
 * @license  http://www.osedu.org/licenses/ECL-2.0 ECL-2.0 License
 */

declare(strict_types=1);

namespace Tests;

use OpenLRW\ApiClient;
use OpenLRW\Entity\Event;
use OpenLRW\Entity\User;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{

    public function testSendCaliperShouldReturnOK()
    {
        new ApiClient(ApiClientTest::URL, ApiClientTest::KEY, ApiClientTest::PASSWORD);
        $response = Event::caliperFactory('test_user_php', 'Test', 'this is a unit test');

        $this->assertEquals(200, $response);
    }

    public function testSendCaliperShouldNotBeNull()
    {
        new ApiClient(ApiClientTest::URL, ApiClientTest::KEY, ApiClientTest::PASSWORD);
        ApiClient::generateJwt();
        $events = User::events('test_user_php');

        $this->assertEquals('Test', $events[0]->action);
    }

}