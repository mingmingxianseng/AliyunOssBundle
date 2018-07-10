<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/9
 * Time: 20:09
 */

namespace Ming\Bundles\AliyunOSSBundle\Client;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ClientInterface
{
    /**
     * upload
     *
     * @author chenmingming
     *
     * @param string       $dir
     * @param UploadedFile $file
     * @param array|null   $options
     *
     * @return Image
     */
    public function upload(string $dir, UploadedFile $file, ?array $options = null): Image;

    /**
     * buildObjectPath
     *
     * @author chenmingming
     *
     * @param string       $dir
     * @param UploadedFile $file
     * @param array|null   $options
     *
     * @return string
     */
    public function buildObjectPath(string $dir, UploadedFile $file, ?array $options = null): string;

    /**
     * buildUrl
     * @author chenmingming
     * @param string $objectPath
     *
     * @return string
     */
    public function buildUrl(string $objectPath): string;
}