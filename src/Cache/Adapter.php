<?php

namespace EasyAws\Cache;

use Aws\CacheInterface;
use Illuminate\Cache\CacheManager;

class Adapter implements CacheInterface
{
    /** @var \Illuminate\Contracts\Cache\Repository */
    protected $cache;

    public function __construct(CacheManager $manager, string $store)
    {
        $this->cache = $manager->store($store);
    }

    /**
     * Get a cache item by key.
     *
     * @param string $key Key to retrieve.
     *
     * @return mixed|null Returns the value or null if not found.
     */
    public function get($key)
    {
        return $this->cache->get($this->makeKey($key));
    }

    /**
     * Set a cache key value.
     *
     * @param string $key   Key to set
     * @param mixed  $value Value to set.
     * @param int    $ttl   Number of seconds the item is allowed to live. Set
     *                      to 0 to allow an unlimited lifetime.
     */
    public function set($key, $value, $ttl = 0)
    {
        // NOTE: laravel uses minutes (pre 5.8) so this conversion is required
        $version = (float)app()->version();
        if ($version <= 5.8) {
            $ttl = ceil($ttl / 60);
        }

        $this->cache->put($this->makeKey($key), $value, $ttl);
    }

    /**
     * Remove a cache key.
     *
     * @param string $key Key to remove.
     * @codeCoverageIgnore AWS doesn't seem to ever call this but its required by the interface
     */
    public function remove($key)
    {
        $this->cache->forget($this->makeKey($key));
    }

    protected function makeKey(string $key)
    {
        return "easy$key";
    }
}
