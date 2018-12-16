<?php
/**
 * FileCache Model Class
 *
 * @copyright   Copyright (c) 2018 (https://github.com/fatihcapak/Localization-Manager)
 * @author      Fatih ÇAPAK
 */

namespace App\Models\Cache;

class FileCache extends \App\Models\Cache\Base\CacheAbstract
{
    const DEFAULT_CACHE_TTL = 3600;

    protected $cacheTtl;
    protected $cachePath;

    /**
     * FileCache Manager constructor.
     * @param int $cacheTtl
     */
    public function __construct($cacheTtl = self::DEFAULT_CACHE_TTL)
    {
        $this->cacheTtl = $cacheTtl;
        $this->cachePath = __DIR__ . '/Data';

        if (!file_exists($this->cachePath)) {
            mkdir($this->cachePath);
        }
    }

    protected function generateFilePath($cacheKey)
    {
        return $this->cachePath . '/' . $cacheKey . '.txt';
    }

    function save($data, $cacheKey)
    {
        try {
            file_put_contents($this->generateFilePath($cacheKey), serialize($data));
        } catch (\Exception $e) {
            // This jobs exceptions will not break main process.
        }
    }

    function load($cacheKey)
    {
        try {
            $filePath = $this->generateFilePath($cacheKey);
            if (!file_exists($filePath)) {
                return false;
            }

            if ((new \DateTime())->getTimestamp() - filemtime($filePath) > $this->cacheTtl) {
                unlink($filePath);
                return false;
            }

            return unserialize(file_get_contents($filePath));
        } catch (\Exception $e) {
            return false;
        }
    }
}
