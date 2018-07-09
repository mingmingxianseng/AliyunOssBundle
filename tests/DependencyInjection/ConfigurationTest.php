<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/9
 * Time: 14:33
 */

namespace Test\DependencyInjection;

use Ming\Bundles\AliyunOSSBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{

    public function testProcessSimpleCase()
    {
        $configs
            = [
            [
                'client' =>
                    [
                        'access_key'        => 'key',
                        'access_key_secret' => 'secret',
                        'alias'             => 'test',
                        'budget'            => 'budget',
                        'end_point'         => '111',
                        'domain'            => 'baidu.com'
                    ]
            ]
        ];

        $config = $this->process($configs);

        $this->assertArrayHasKey('clients', $config);

        $this->assertSame($config['clients']['test']['access_key'], $configs[0]['client']['access_key']);
    }

    /**
     * Processes an array of configurations and returns a compiled version.
     *
     * @param array $configs An array of raw configurations
     *
     * @return array A normalized array
     */
    protected function process($configs)
    {
        $processor = new Processor();

        return $processor->processConfiguration(new Configuration(), $configs);
    }
}