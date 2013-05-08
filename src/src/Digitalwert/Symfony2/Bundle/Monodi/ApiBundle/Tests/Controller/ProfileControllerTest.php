<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileControllerTest extends WebTestCase
{
//    public function testGetprofiles()
//    {
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/profile');
//    }

    public function testGetprofile()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/profile/tester.json');
    }

//    public function testPostprofile()
//    {
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/profile/{slug}');
//    }

    public function testPutprofile() {
        $client = static::createClient();

        $crawler = $client->request(
            'PUT',
            '/api/v1/profile/tester1.json',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"lastname":"Tester","firstname":"Test","salutation":"Herr"}'
        );
    }

//    public function testPatchprofile()
//    {
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/profile/{slug}');
//    }

}
