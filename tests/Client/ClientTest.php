<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/9
 * Time: 15:19
 */

namespace Test\Client;

use Ming\Bundles\AliyunOSSBundle\Client\Md5SplitClient;
use Ming\Bundles\AliyunOSSBundle\Client\TimeSplitClient;
use OSS\OssClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ClientTest extends TestCase
{
    /**
     * testMd5SplitClientCase
     *
     * @author chenmingming
     * @throws \OSS\Core\OssException
     */
    public function testMd5SplitClientCase()
    {
        $dir      = 'test';
        $filePath = __DIR__ . '/test.jpeg';
        $file     = new UploadedFile($filePath, 'test.jpeg', 'jpeg');

        $client     = new Md5SplitClient(new OssClient(11, 1, '11'), '11', 'baidu.com');
        $objectPath = $client->buildObjectPath($dir, $file);

        $expected = 'test/fc/a8/fca81d1c5615209e3d1a96fc96936f6d.jpg';
        $this->assertSame($expected, $objectPath);

        $this->assertSame('https://baidu.com/' . $expected, $client->buildUrl($objectPath));
    }

    /**
     * testTimeSplitClientCase
     *
     * @author chenmingming
     * @throws \OSS\Core\OssException
     */
    public function testTimeSplitClientCase()
    {
        $dir      = 'test';
        $filePath = __DIR__ . '/test.jpeg';
        $file     = new UploadedFile($filePath, 'test.jpeg', 'jpeg');

        $client     = new TimeSplitClient(new OssClient(11, 1, '11'), '11', 'baidu.com');
        $objectPath = $client->buildObjectPath($dir, $file, [$client::OPT_FILE_NAME => 'test']);

        $expected = 'test/' . date('Ymd') . '/' . date('Hi') . '/test.jpg';
        $this->assertSame($expected, $objectPath);

        $this->assertSame('https://baidu.com/' . $expected, $client->buildUrl($objectPath));
    }

    /**
     * testUpload
     * @author chenmingming
     * @throws \OSS\Core\OssException
     */
    public function testUpload()
    {
        $dir      = 'test';
        $filePath = __DIR__ . '/test.jpeg';
        $file     = new UploadedFile($filePath, 'test.jpeg', 'application/jpeg');

        $config = include_once __DIR__ . '/config.php';

        $ossClient = new OssClient($config['access_key'], $config['access_key_secret'], $config['end_point']);
        $client    = new Md5SplitClient($ossClient, $config['budget'], $config['domain']);

        $image = $client->upload($dir, $file);

        $this->assertSame(1, $image->getWidth());
        $this->assertSame(
            'https://' . $config['domain'] . '/test/fc/a8/fca81d1c5615209e3d1a96fc96936f6d.jpg', $image->getUrl()
        );
    }
}