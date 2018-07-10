<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/9
 * Time: 14:02
 */

namespace Ming\Bundles\AliyunOSSBundle\Client;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Md5SplitClient extends AbstractClient
{
    /**
     * parseObjectPath
     *
     * @author chenmingming
     *
     * @param string       $dir
     * @param UploadedFile $file
     * @param array|null   $options
     *
     * @return string
     */
    public function buildObjectPath(string $dir, UploadedFile $file, ?array $options = null): string
    {
        if (substr($dir, -1) !== '/') {
            $dir .= '/';
        }
        $md5Value = md5_file($file->getRealPath());

        return sprintf(
            "%s%s/%s/%s.%s",
            $dir,
            substr($md5Value, 0, 2),
            substr($md5Value, 2, 2),
            $options[self::OPT_FILE_NAME] ?? $md5Value,
            $file->guessClientExtension() ?: 'jpg'
        );
    }

}