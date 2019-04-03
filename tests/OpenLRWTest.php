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
use OpenLRW\Model\OneRoster;
use OpenLRW\Model\User;
use PHPUnit\Framework\TestCase;

class OpenLRWTest extends TestCase
{

    const URL = 'localhost:9966';
    const KEY = '4f97aee0-2998-4bab-85e7-bf25a39a05b5';
    const PASSWORD = '3b2f42b4-7819-4527-8f09-bb721366554f';

    public function testClientShouldNotBeNull()
    {
        $client = new OpenLRW(self::URL, self::KEY, self::PASSWORD);
        $this->assertNotNull($client);
    }


    public function testServerShouldBeUp()
    {
        $client = new OpenLRW(self::URL, self::KEY, self::PASSWORD);
        $response = $client::isUp();
        $this->assertTrue($response);
    }

    public function testServerShouldBeDown()
    {
        $client = new OpenLRW('http://fake_openlrw.apero.org', self::KEY, self::PASSWORD);
        $response = $client::isUp();
        $this->assertFalse($response);
    }

    public function testJwtShouldNotBeNull()
    {
        $client = new OpenLRW(self::URL, self::KEY, self::PASSWORD);
        $client::generateJwt();
        $jwt = $client::getJwt();
        $this->assertNotNull($jwt);
    }


    public function testStaticJwtShouldNotBeNull()
    {
        $client = new OpenLRW(self::URL, self::KEY, self::PASSWORD);
        $client::generateJwt();
        $jwt = OpenLRW::getJwt();
        $this->assertNotNull($jwt);
    }


    public function testUserShouldNotBeNull()
    {
        new OpenLRW(self::URL, self::KEY, self::PASSWORD);
        OpenLRW::generateJwt();
        $user = User::find('test2u');
        $this->assertNotNull($user);
    }


    public function testOneRosterGetShouldReturnOk()
    {
        new OpenLRW(self::URL, self::KEY, self::PASSWORD);
        OpenLRW::generateJwt();
        $user = OneRoster::get('users/test2u');
        $this->assertNotNull($user);
    }


    public function testGetShouldReturnOk()
    {
        new OpenLRW(self::URL, self::KEY, self::PASSWORD);

        $jwt = OpenLRW::generateJwt();

        $header = ['X-Requested-With' => 'XMLHttpRequest', 'Authorization' => "Bearer $jwt"];

        $user = OpenLRW::httpGet('/api/users/test2u', $header);
        $this->assertNotNull($user);
    }

}