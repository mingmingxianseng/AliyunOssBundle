<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/9
 * Time: 13:53
 */

namespace Ming\Bundles\AliyunOSSBundle\Client;

use OSS\OssClient;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class AbstractClient implements ClientInterface
{
    // 文件名称
    const OPT_FILE_NAME = 'opt_file_name';
    protected $ossClient;
    protected $budget;
    protected $domain;
    protected $scheme;

    public function __construct(OssClient $ossClient, $budget, $domain, $scheme = 'https')
    {
        $this->ossClient = $ossClient;
        $this->budget    = $budget;
        $this->domain    = $domain;
        $this->scheme    = $scheme;
    }

    /**
     * upload
     *
     * @author chenmingming
     *
     * @param string       $dir
     * @param UploadedFile $file
     * @param null|array   $options
     *
     * @return Image
     * @throws \OSS\Core\OssException
     */
    public function upload(string $dir, UploadedFile $file, ?array $options = null): Image
    {
        $objectPath = $this->buildObjectPath($dir, $file, $options);

        $this->ossClient->uploadFile($this->budget, $objectPath, $file->getRealPath(), $options);

        return new Image($this->buildUrl($objectPath), $file);
    }
    /**
     * buildUrl
     *
     * @author chenmingming
     *
     * @param string $objectPath
     *
     * @return string
     */
    public function buildUrl(string $objectPath): string
    {
        return $this->scheme . '://' . $this->domain . '/' . $objectPath;
    }
}