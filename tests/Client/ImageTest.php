<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/9
 * Time: 15:07
 */

namespace Test\Client;

use Ming\Bundles\AliyunOSSBundle\Client\Image;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageTest extends TestCase
{
    public function testCase()
    {
        $filePath = __DIR__ . '/test.jpeg';
        $file     = new UploadedFile($filePath, 'test.jpeg', 'jpeg');
        $image    = new Image('http://baidu/1.jpg', $file);

        $this->assertSame($image->getUrl(), 'http://baidu/1.jpg');
        $this->assertSame($image->getFile(), $file);
        $this->assertSame($image->getMd5Value(), md5_file($filePath));
        $this->assertSame(1, $image->getWidth());
        $this->assertSame(1, $image->getHeight());

        $image = new Image('http://baidu/1.jpg', $file);
        $this->assertSame(1, $image->getHeight());
        $image = new Image('http://baidu/1.jpg');
        $image->setMd5Value(123);

        $image->setWidth(2)->setHeight(3);

        $this->assertSame('123', $image->getMd5Value());
        $this->assertSame(2, $image->getWidth());
        $this->assertSame(3, $image->getHeight());

    }
}