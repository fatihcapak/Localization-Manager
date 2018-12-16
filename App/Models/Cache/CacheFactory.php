<?php
/**
 * CacheFactory Model Class
 *
 * @copyright   Copyright (c) 2018 (https://github.com/fatihcapak/Localization-Manager)
 * @author      Fatih ÇAPAK
 */

namespace App\Models\Cache;

class CacheFactory
{
    const CACHE_FILE = 'File';
    const CACHE_REDIS = 'Redis';

    protected $service;

    public function get($serviceName)
    {
        $class = sprintf("\App\Models\Cache\%sCache", $serviceName);
        if (!class_exists($class)) {
            throw new \UnexpectedValueException("Invalid cache : $serviceName");
        }

        $this->service = new $class;
        return $this->service;
    }
}
