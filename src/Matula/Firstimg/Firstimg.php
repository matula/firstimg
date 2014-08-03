<?php namespace Matula\Firstimg;

use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Firstimg
 *
 * @package Matula\Firstimg
 */
class Firstimg
{

    /**
     * @var null
     */
    protected $url;

    /**
     * @var string
     */
    protected $html;

    /**
     * @var
     */
    protected $folder;

    /**
     * @var
     */
    protected $image_uri;

    /**
     * @param null $url
     * @throws \Exception
     */
    public function __construct($url = null)
    {
        if (!$url) {
            throw new \InvalidArgumentException('Class requires a URL');
        }
        $this->url  = $url;
        $this->html = $this->retreiveHtml();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function retreiveHtml()
    {
        try {
            $html = trim(file_get_contents($this->url));
        } catch (\Exception $e) {
            throw new \Exception('Url not found');
        }

        return $html;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @return mixed
     */
    public function getImageUri()
    {
        return $this->image_uri;
    }

    /**
     * @return string
     */
    public function downloadImage()
    {
        $this->findImage();
        $this->setFolder();
        $img       = Image::make($this->image_uri)->fit(100);
        $extention = 'jpg';
        $filename  = $this->folder . '/' . 'image_' . md5(microtime()) . '.' . $extention;
        $img->save($filename, 60);

        return $filename;
    }

    /**
     * @return $this|null
     */
    public function findImage()
    {
        $crawler = new Crawler($this->html);
        $images  = $crawler->filterXpath('//img')->extract(['src']);
        if (empty($images)) {
            return null;
        }

        $this->image_uri = $this->getUri($images[0]);

        return $this;
    }

    /**
     * @param $image
     * @return string
     */
    public function getUri($image)
    {
        return Phpuri::parse($this->url)->join($image);
    }

    /**
     * @param string $folder
     * @return $this
     */
    public function setFolder($folder = 'firstimg')
    {
        if (!file_exists($folder)) {
            mkdir($folder);
        }
        $this->folder = $folder;

        return $this;
    }
} 