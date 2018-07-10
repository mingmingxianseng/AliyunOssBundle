<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/9
 * Time: 10:09
 */

namespace Ming\Bundles\AliyunOSSBundle\Client;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class TimeSplitClient extends AbstractClient
{
    public function buildObjectPath(string $dir, UploadedFile $file, ?array $options = null): string
    {
        if (substr($dir, -1) !== '/') {
            $dir .= '/';
        }

        return sprintf(
            "%s%s/%s/%s.%s",
            $dir,
            date('Ymd'),
            date('Hi'),
            $options[self::OPT_FILE_NAME] ?? uniqid(),
            $file->guessClientExtension() ?? 'jpg'
        );
    }

}