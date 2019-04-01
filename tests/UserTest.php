<?php
/**
 *
 * API client test class
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
use OpenLRW\Entity\User;
use OpenLRW\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testUserShouldNotBeNull()
    {
        new OpenLRW(OpenLRWTest::URL, OpenLRWTest::KEY, OpenLRWTest::PASSWORD);
        OpenLRW::generateJwt();
        $user = User::find('test2u');
        $this->assertNotNull($user);
    }

    public function testUserShouldThrowException()
    {
        $this->expectException(NotFoundException::class);

        new OpenLRW(OpenLRWTest::URL, OpenLRWTest::KEY, OpenLRWTest::PASSWORD);
        OpenLRW::generateJwt();
        User::find('this_user_does_not_exist');
    }

}