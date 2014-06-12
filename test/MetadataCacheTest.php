<?php
/**
 * Created by PhpStorm.
 * User: digitalwert
 * Date: 03.06.14
 * Time: 09:06
 */

namespace Digitalwert\Monodi\Test\Performance;

use Guzzle\Http\Client;
use PHP_Timer;

/**
 * Class MetadataCacheTest
 * @package Digitalwert\Monodi\Test\Performance
 */
class MetadataCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Guzzle\Http\ClientInterface
     */
    protected $client;

    public function setUp()
    {
        $this->client = new Client();
        $this->client->setBaseUrl('http://192.168.33.100');
    }

    /**
     * Read Meta-Data
     */
    public function testGetWithCache()
    {
        /*
         * cache Warming
         */
        //$request = $this->client->get('/api/v1/metadata.json?access_token=test1234');
        //$response = $request->send();

        $timer = new PHP_Timer();
        $timer->start();

        $request = $this->client->get('/api/v1/metadata.json?access_token=test1234');
        $response = $request->send();

        $time = $timer->stop();

        var_dump(PHP_Timer::secondsToTimeString($time));
        var_dump(PHP_Timer::resourceUsage());
    }

    public function testMetaDataEdit()
    {
        /*
        $request = $this->client->createRequest('PURGE', '/api/v1/metadata.json?access_token=test1234');
        $response = $request->send();

        var_dump($response);
        */

        $request = $this->client->get('/api/v1/metadata.json?access_token=test1234');
        $response = $request->send();
    }
} 