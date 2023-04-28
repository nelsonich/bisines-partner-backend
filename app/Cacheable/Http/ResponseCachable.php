<?php

namespace App\Cacheable\Http;

use App\Cacheable\Cacheable;
use Illuminate\Http\Request;
use RuntimeException;
use Throwable;

final class ResponseCachable
{
  private $request = null;
  private $timeout = null;
  private $hashId = null;
  private $executionMode = null;
  private $duration = null;
  private $response = null;
  private $exception = null;

  public static function factory()
  {
    return new static();
  }

  private function __construct()
  {
  }

  private static function cacheDriver()
  {
    return Cacheable::instance();
  }

  public static function clearForRequest(Request $request)
  {
    $hash = self::buildRequestHash($request);
    self::cacheDriver()->forget($hash);
  }

  private static function buildRequestHash(Request $request)
  {
    $hashingData = json_encode([
      'method' => $request->method(),
      'url' => $request->url(),
      'query' => $request->query->all(),
      'body' => $request->all(),
    ]);

    $hashAlgos = ['crc32', 'md5', 'sha256'];
    $hashGroups = array_map(function ($algorithm) use ($hashingData) {
      return hash($algorithm, $hashingData);
    }, $hashAlgos);

    return 'cachable-response:' . implode('-', $hashGroups);
  }

  public function setRequest(Request $request)
  {
    $this->request = $request;
    return $this;
  }

  public function getRequest()
  {
    return $this->request;
  }

  public function setTimeout(int $timeout)
  {
    $this->timeout = $timeout;
    return $this;
  }

  public function getTimeout()
  {
    return $this->timeout;
  }

  public function getHashId()
  {
    return $this->hashId;
  }

  public function getExecutionMode()
  {
    return $this->executionMode;
  }

  public function getDuration()
  {
    return $this->duration;
  }

  public function getResponse()
  {
    return $this->response;
  }

  public function getHeaders()
  {
    $headerPrefix = 'X-App-Cachable-Response';

    return [
      $headerPrefix . '-Hash-Id' => $this->hashId,
      $headerPrefix . '-Timeout' => $this->timeout,
      $headerPrefix . '-Mode' => $this->executionMode,
      $headerPrefix . '-Duration' => $this->duration,
      $headerPrefix . '-Exception' => $this->exception,
    ];
  }

  public function executeWithCallback(callable $callback)
  {
    $startTime = microtime(true);
    $this->generateRequestHash();

    try {
      $result = self::cacheDriver()->get($this->hashId);
      if (is_null($result) || false === $result) {
        $result = $this->waitForOtherExecutionResultOrExecute($callback);
      } else {
        $this->executionMode = 'cache-store';
        $result = unserialize($result);
      }
    } catch (Throwable $e) {
      $this->exception = $e->getMessage();
      $result = $this->waitForOtherExecutionResultOrExecute($callback);
    }

    $this->response = $result;
    $this->duration = (microtime(true) - $startTime) * 1000;

    return $this;
  }

  private function generateRequestHash()
  {
    $this->hashId = self::buildRequestHash($this->request);
  }

  private function getQueueCacheKey()
  {
    return 'cache-response-queue';
  }

  private function waitForOtherExecutionResultOrExecute(callable $callback)
  {
    $queueCacheKey = $this->getQueueCacheKey();
    try {
      $queueSerialized = self::cacheDriver()->get($queueCacheKey);
      $queue = unserialize($queueSerialized);

      if (!array_key_exists($this->hashId, $queue)) {
        return $this->executeRealCallback($callback);
      }

      $this->executionMode = 'cache-queue';
      $attempts = 0;
      while (true) {
        if (++$attempts === 20) {
          throw new RuntimeException('Queue max attempts exceeded.');
        }

        usleep(100);

        $result = self::cacheDriver()->get($this->hashId);
        if (is_null($result) || false === $result) {
          continue;
        }

        return unserialize($result);
      }
    } catch (Throwable $e) {
      $this->exception = $e->getMessage();
      return $this->executeRealCallback($callback);
    }
  }

  private function executeRealCallback(callable $callback)
  {
    $queueCacheKey = $this->getQueueCacheKey();

    $queueSerialized = self::cacheDriver()->get($queueCacheKey);
    $queue = unserialize($queueSerialized);

    $queue[$this->hashId] = 'queued';
    self::cacheDriver()->set($queueCacheKey, serialize($queue));

    $this->executionMode = 'execution';
    $result = $callback();

    unset($queue[$this->hashId]);
    self::cacheDriver()->set($queueCacheKey, serialize($queue));

    self::cacheDriver()->set($this->hashId, serialize($result), $this->timeout);

    return $result;
  }
}
