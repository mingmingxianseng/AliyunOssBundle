<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/8
 * Time: 21:32
 */

namespace Ming\Bundles\AliyunOSSBundle\DependencyInjection;

use Ming\Bundles\AliyunOSSBundle\Client\TimeSplitClient;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('aliyun_oss');
        $rootNode
            ->fixXmlConfig('client')
            ->children()
                ->arrayNode('clients')
                    ->useAttributeAsKey('alias',false)
                    ->prototype('array')
                        ->children()
                            ->scalarNode('alias')->isRequired()->end()
                            ->scalarNode('access_key')->isRequired()->end()
                            ->scalarNode('access_key_secret')->isRequired()->end()
                            ->scalarNode('budget')->isRequired()->end()
                            ->scalarNode('end_point')->isRequired()->end()
                            ->scalarNode('domain')->isRequired()->end()
                            ->scalarNode('scheme')->defaultValue('https')->end()
                            ->scalarNode('class')->defaultValue(TimeSplitClient::class)->end()
                        ->end()
                    ->end()
                ->end()
        ->end();

        return $treeBuilder;
    }

}