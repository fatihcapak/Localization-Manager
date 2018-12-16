<?php
/**
 * CacheAbstract Model Class
 *
 * @copyright   Copyright (c) 2018 (https://github.com/fatihcapak/Localization-Manager)
 * @author      Fatih ÇAPAK
 */

namespace App\Models\Cache\Base;

abstract class CacheAbstract
{
    protected $cacheTtl;

    public function generateCacheKey()
    {
        return join('_', func_get_args()) . '_' . md5(json_encode(func_get_args()));
    }

    /**
     * @return mixed
     */
    public function getCacheTtl()
    {
        return $this->cacheTtl;
    }

    /**
     * @param mixed $cacheTtl
     */
    public function setCacheTtl($cacheTtl)
    {
        $this->cacheTtl = $cacheTtl;
    }

    abstract function save($data, $cacheKey);
    abstract function load($cacheKey);
}
