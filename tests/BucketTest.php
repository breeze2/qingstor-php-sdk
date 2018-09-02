<?php
namespace BL\Tests;

use BL\QingStor\Bucket;
use BL\QingStor\Service;
use PHPUnit\Framework\TestCase;

/**
 * @covers Bucket
 */

final class BucketTest extends TestCase
{
    public function testListObjects()
    {
        $config   = new ConfigTest();
        $service  = new Service($config);
        $bucket   = $service->makeBucket('bl-test', 'pek3b');
        $response = $bucket->listObjects(['query' => ['delimiter' => '/']]);
        print_r(json_decode($response->getBody()->getContents()));
        $this->assertEquals(1, 1);
    }

    public function testDeleteObjects()
    {
        $config   = new ConfigTest();
        $service  = new Service($config);
        $bucket   = $service->makeBucket('bl-test', 'pek3b');
        $response = $bucket->deleteObjects(['json' => ['objects' => [['key' => 'favicon.png']]]]);
        print_r(json_decode($response->getBody()->getContents()));
        $this->assertEquals(1, 1);
    }

    public function testHead()
    {
        $config   = new ConfigTest();
        $service  = new Service($config);
        $bucket   = $service->makeBucket('bl-test1', 'pek3b');
        $response = $bucket->head();
        print_r($response->getStatusCode());
        $this->assertEquals(1, 1);
    }

    // public function testCreate()
    // {
    //     $config   = new ConfigTest();
    //     $service  = new Service($config);
    //     $bucket   = $service->makeBucket('bl-test1', 'pek3b');
    //     $response = $bucket->create();
    //     print_r($response->getBody()->getContents());
    //     $this->assertEquals(1, 1);
    // }

    // public function testDelete()
    // {
    //     $config   = new ConfigTest();
    //     $service  = new Service($config);
    //     $bucket   = $service->makeBucket('bl-test1', 'pek3b');
    //     $response = $bucket->delete();
    //     print_r($response->getBody()->getContents());
    //     $this->assertEquals(1, 1);
    // }

}