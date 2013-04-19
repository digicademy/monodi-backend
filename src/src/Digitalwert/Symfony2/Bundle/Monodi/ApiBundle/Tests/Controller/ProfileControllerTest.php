<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileControllerTest extends WebTestCase
{
    public function testGetprofiles()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/profile');
    }

    public function testGetprofile()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/profile/{slug}');
    }

    public function testPostprofile()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/profile/{slug}');
    }

    public function testPutprofile()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/profile');
    }

    public function testPatchprofile()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/profile/{slug}');
    }

}
