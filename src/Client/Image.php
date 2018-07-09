<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/9
 * Time: 11:09
 */

namespace Ming\Bundles\AliyunOSSBundle\Client;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Image
{
    /**
     * @var int
     */
    private $width;
    /**
     * @var int
     */
    private $height;
    /**
     * @var string
     */
    private $md5Value;
    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @var string
     */
    private $url = '';

    public function __construct(string $url, UploadedFile $file = null)
    {
        $this->url  = $url;
        $this->file = $file;
    }

    private function calculateWidthAndHeight()
    {
        $this->width = $this->height = 0;
        $this->file && list($this->width, $this->height) = getimagesize($this->file->getRealPath());
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        if ($this->width === null) {
            $this->calculateWidthAndHeight();
        }

        return $this->width;
    }

    /**
     * @param int $width
     *
     * @return Image
     */
    public function setWidth(int $width): Image
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        if ($this->height === null) {
            $this->calculateWidthAndHeight();
        }

        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return Image
     */
    public function setHeight(int $height): Image
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return string
     */
    public function getMd5Value(): string
    {
        if ($this->md5Value === null) {
            $this->md5Value = '';
            if ($this->file) {
                $this->md5Value = md5_file($this->file->getRealPath());
            }
        }

        return $this->md5Value;
    }

    /**
     * @param string $md5Value
     *
     * @return Image
     */
    public function setMd5Value(string $md5Value): Image
    {
        $this->md5Value = $md5Value;

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

}