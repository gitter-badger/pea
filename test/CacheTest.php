<?php namespace Lvht\Pea;

use Mockery as M;
use Illuminate\Contracts\Redis\Database as Redis;
use Lvht\Pea\RedisCache;

class CacheTest extends TestCase
{
    public function testGet()
    {
        $redis = M::mock(Redis::class);
        $redis->shouldReceive('mget')->with([
            'a',
            'b',
        ])->andReturn([
            1,
            null,
        ]);

        $cache = new RedisCache($redis);
        $result = $cache->get(['a', 'b']);
        $this->assertEquals([ 'a' => 1, 'b' => null], $result);
    }

    public function testSet()
    {
        $redis = M::mock(Redis::class);
        $redis->shouldReceive('mset')->with([
            'a' => 1,
            'b' => 2,
        ]);

        $cache = new RedisCache($redis);
        $cache->set([
            'a' => 1,
            'b' => 2,
        ]);
    }

    public function testDel()
    {
        $redis = M::mock(Redis::class);
        $redis->shouldReceive('del')->with([
            'a',
            'b',
        ]);

        $cache = new RedisCache($redis);
        $cache->del(['a', 'b']);
    }
}