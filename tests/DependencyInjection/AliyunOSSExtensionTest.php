<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/9
 * Time: 15:00
 */

namespace Test\DependencyInjection;

use Ming\Bundles\AliyunOSSBundle\Client\ClientInterface;
use Ming\Bundles\AliyunOSSBundle\Client\TimeSplitClient;
use Ming\Bundles\AliyunOSSBundle\DependencyInjection\AliyunOSSExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AliyunOSSExtensionTest extends TestCase
{
    public function testLoad()
    {
        $container = new ContainerBuilder();
        $loader    = new AliyunOSSExtension();
        $config    = [
            'aliyun_oss' => [
                'client' => [
                    'access_key'        => 'key',
                    'access_key_secret' => 'secret',
                    'alias'             => 'test',
                    'budget'            => 'budget',
                    'end_point'         => 'end.point',
                    'domain'            => 'baidu.com'
                ]
            ]
        ];
        $loader->load($config, $container);

        $definition = $container->getDefinition('aliyun.oss.client.test');
        $this->assertSame($definition->getArgument(1), 'budget');
        $this->assertSame($definition->getArgument(2), 'baidu.com');

        $aaa = $container->get(ClientInterface::class);
        $this->assertInstanceOf(TimeSplitClient::class, $aaa);

        $bbb = $container->get('oss.test');

        $this->assertSame($aaa, $bbb);
    }
}