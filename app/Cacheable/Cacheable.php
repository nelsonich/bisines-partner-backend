<?php

namespace App\Cacheable;

use Closure;
use Illuminate\Contracts\Cache\Repository as CacheRepositoryInterface;
use Illuminate\Support\Facades\Cache as LaravelCache;
use Illuminate\Support\Str;

final class Cacheable implements CacheRepositoryInterface
{
  private static $singletonInstance = null;

  private $driver = null;

  public static function instance(): CacheRepositoryInterface
  {
    if (is_null(self::$singletonInstance)) {
      self::$singletonInstance = new static();
    }

    return self::$singletonInstance;
  }

  private function __construct()
  {
    $this->driver = LaravelCache::store('redis');
  }

  private function makeSpecificKey($key)
  {
    return Str::slug(config('app.name'), '_') . ':' . $key;
  }

  private function makeCompanySpecificKey($keys)
  {
    if (is_array($keys)) {
      $updatedKeys = [];
      foreach ($keys as $key) {
        $updatedKeys[] = $this->makeSpecificKey($key);
      }

      return $updatedKeys;
    }

    return $this->makeSpecificKey($keys);
  }

  public function getStore()
  {
    return $this->driver;
  }

  public function pull($key, $default = null)
  {
    $specificKey = $this->makeCompanySpecificKey($key);
    return $this->driver->pull($specificKey, $default);
  }

  public function put($key, $value, $ttl = null)
  {
    $specificKey = $this->makeCompanySpecificKey($key);
    return $this->driver->put($specificKey, $value, $ttl);
  }

  public function add($key, $value, $ttl = null)
  {
    $specificKey = $this->makeCompanySpecificKey($key);
    return $this->driver->add($specificKey, $value, $ttl);
  }

  public function increment($key, $value = 1)
  {
    $specificKey = $this->makeCompanySpecificKey($key);
    return $this->driver->increment($specificKey, $value);
  }

  public function decrement($key, $value = 1)
  {
    $specificKey = $this->makeCompanySpecificKey($key);
    return $this->driver->decrement($specificKey, $value);
  }

  public function forever($key, $value)
  {
    $specificKey = $this->makeCompanySpecificKey($key);
    return $this->driver->forever($specificKey, $value);
  }

  public function remember($key, $ttl, Closure $callback)
  {
    $specificKey = $this->makeCompanySpecificKey($key);
    return $this->driver->remember($specificKey, $ttl, $callback);
  }

  public function sear($key, Closure $callback)
  {
    $specificKey = $this->makeCompanySpecificKey($key);
    return $this->driver->sear($specificKey, $callback);
  }

  public function rememberForever($key, Closure $callback)
  {
    $specificKey = $this->makeCompanySpecificKey($key);
    return $this->driver->rememberForever($specificKey, $callback);
  }

  public function forget($key)
  {
    $specificKey = $this->makeCompanySpecificKey($key);
    return $this->driver->forget($specificKey);
  }

  public function has($key): bool
  {
    $specificKey = $this->makeCompanySpecificKey($key);
    return $this->driver->has($specificKey);
  }

  public function get($key, $default = null): mixed
  {
    $specificKey = $this->makeCompanySpecificKey($key);
    return $this->driver->get($specificKey, $default);
  }

  public function set($key, $value, $ttl = null): bool
  {
    $specificKey = $this->makeCompanySpecificKey($key);
    return $this->driver->set($specificKey, $value, $ttl);
  }

  public function delete($key): bool
  {
    $specificKey = $this->makeCompanySpecificKey($key);
    return $this->driver->delete($specificKey);
  }

  public function getMultiple($keys, mixed $default = null): iterable
  {
    $specificKeys = $this->makeCompanySpecificKey($keys);
    return $this->driver->getMultiple($specificKeys, $default);
  }

  public function setMultiple($values, $ttl = null): bool
  {
    // @TODO: code not implemented
    return true;
  }

  public function deleteMultiple($keys): bool
  {
    $specificKeys = $this->makeCompanySpecificKey($keys);
    return $this->driver->deleteMultiple($specificKeys);
  }

  public function clear(): bool
  {
    // @TODO: code not implemented
    return true;
  }
}
