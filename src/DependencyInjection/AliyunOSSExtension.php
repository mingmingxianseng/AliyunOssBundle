<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/8
 * Time: 21:38
 */

namespace Ming\Bundles\AliyunOSSBundle\DependencyInjection;

use OSS\OssClient;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AliyunOSSExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $rootConfig    = $this->processConfiguration($configuration, $configs);

        $this->loadClient($rootConfig['clients'], $container);
    }

    /**
     * loadClient
     * @author chenmingming
     * @param array            $clients
     * @param ContainerBuilder $container
     */
    private function loadClient(array $clients, ContainerBuilder $container)
    {

        foreach ($clients as $key => $config) {
            $ossDefinition = new Definition(OssClient::class);
            $ossDefinition->setArgument(0, $config['access_key'])
                ->setPublic(false)
                ->addArgument($config['access_key_secret'])
                ->addArgument($config['end_point']);

            $container->setDefinition('aliyun.oss.connection.' . $key, $ossDefinition);

            $definition = new Definition($config['class']);
            $definition->setPublic(false)
                ->addArgument(new Reference('aliyun.oss.connection.' . $key))
                ->addArgument($config['budget'])
                ->addArgument($config['domain'])
                ->addArgument($config['scheme']);
            $container->setDefinition('aliyun.oss.client.' . $key, $definition);
        }
    }

}