<?php

namespace App\Repositories;


use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CacheRepository
{
    CONST CACHE_KEY = 'VALUES';
    protected $cachePrefix;
    protected $duration;

    public function __construct()
    {
        $this->cachePrefix = config('database.redis.options.prefix') . config('cache.prefix');
        $this->duration = Carbon::now()->addMinutes(5);
    }


    /**
     * @return array
     */
    public function all()
    {
        $itemArray = $keyArray = [];
        $redis = Redis::connection();
        $cacheKeys = $redis->keys('*');
        foreach ($cacheKeys as $eachKey) {
            try {
                $keyArray[] =  explode("~",$eachKey)[1];
            } catch (\Exception $exception) {
                // echo $exception->getMessage();
            }
        }

        foreach ($keyArray as $eachKey) {
            $valKey = $this->getCacheKey($eachKey);
            $itemArray[$eachKey] = Cache::store('redis')->remember($valKey, $this->duration, function() {
                return null;
            });
        }

        return $itemArray;
    }

    /**
     * @param $keys
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getValueByKeys($keys)
    {
        $itemArray = [];
        foreach ($keys as $eachKey) {
            $eachKey = $this->getCacheKey($eachKey);
            $actualKey = explode("~",$eachKey)[1];
            if (Cache::store('redis')->has($eachKey)) {
                $itemArray[$actualKey] = Cache::store('redis')->remember($eachKey, $this->duration, function() {
                    return null;
                });
            }
        }

        return $itemArray;
    }

    /**
     * @param $values
     */
    public function store($values)
    {
        foreach ($values as $key => $eachValue) {
            $key = $this->getCacheKey($key);
            Cache::store('redis')->put($key, $eachValue, $this->duration);
        }
    }

    /**
     * @param $values
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function update($values)
    {
        foreach ($values as $key => $value) {
            $key = $this->getCacheKey($key);
            if (Cache::store('redis')->has($key)) {
                Cache::store('redis')->put($key, $value, $this->duration);
            }
        }
    }

    /**
     * @param $key
     * @return string
     */
    public function getCacheKey($key)
    {
        return self::CACHE_KEY . "~$key";
    }

}
