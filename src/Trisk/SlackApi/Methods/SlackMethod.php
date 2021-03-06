<?php

namespace Trisk\SlackApi\Methods;

use Trisk\SlackApi\Contracts\ApiContract;
use Illuminate\Contracts\Cache\Repository as Cache;

/**
 * Class SlackMethod
 *
 * @package Trisk\SlackApi\Methods
 */
abstract class SlackMethod
{
    /**
     * Prefix of the api methods to allow you to use short method names.
     * @var string
     */
    protected $methodsGroup = 'api.';

    /**
     * @var ApiContract
     */
    protected $api;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var string
     */
    protected $cachePrefix = '__trisk_slackc_';

    /**
     * @param ApiContract  $api
     * @param Cache $cache
     */
    public function __construct(ApiContract $api, Cache $cache)
    {
        $this->api = $api;
        $this->cache = $cache;
    }

    /**
     * Sends a http request.
     *
     * @param string $method short method of the api (only the suffix after ".")
     * @param array  $params params to the given method
     * @param string $http http verb
     *
     * @return array
     */
    public function method($method, $params = [], $http = 'post'): array
    {
        return call_user_func([$this->getApi(), $http], $this->methodsGroup.$method, $params);
    }

    /**
     * Returns the api.
     * @return ApiContract
     */
    public function getApi(): ApiContract
    {
        return $this->api;
    }

    /**
     * Cache a value.
     *
     * @param string $key
     * @param mixed  $value
     * @param int    $minutes Default 1
     *
     * @return mixed
     */
    public function cachePut($key, $value, $minutes = 1)
    {
        $this->cache->put($this->cachePrefix($key), $value, $minutes);

        return $value;
    }

    /**
     * Remember the result value for a given closure.
     * @param $key
     * @param $minutes
     * @param $callback
     *
     * @return mixed
     */
    public function cacheRemember($key, $minutes, $callback)
    {
        return $this->cache->remember($this->cachePrefix($key), $minutes, $callback);
    }

    /**
     * Remember the result value for a closure forever.
     * @param $key
     * @param $callback
     *
     * @return mixed
     */
    public function cacheRememberForever($key, $callback)
    {
        return $this->cache->rememberForever($this->cachePrefix($key), $callback);
    }

    /**
     * Get a cache for a given key.
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function cacheGet($key, $default = null)
    {
        return $this->cache->get($this->cachePrefix($key), $default);
    }

    /**
     * Cache a value forever.
     * @param $key
     * @param $value
     */
    public function cacheForever($key, $value)
    {
        $this->cache->forever($this->cachePrefix($key), $value);
    }

    /**
     * Forget a value for a given key.
     * @param $key
     */
    public function cacheForget($key)
    {
        $this->cache->forget($this->cachePrefix($key));
    }

    /**
     * Get the default key prefix.
     *
     * @param string|null $key
     *
     * @return string
     */
    protected function cachePrefix($key = null)
    {
        return $this->cachePrefix.$key;
    }
}
