<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Visits
{
    protected $thread;

    /**
     * Visits constructor.
     * @param $thread
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    /**
     * @return $this
     */
    public function reset()
    {
        Redis::del($this->cacheKey());
        return $this;
    }

    /**
     * @return int
     */
    public function count()
    {
        return Redis::get($this->cacheKey()) ?? 0;
    }

    /**
     * @return $this
     */
    public function record()
    {
        Redis::incr($this->cacheKey());
        return $this;
    }

    /**
     * @return string
     */
    protected function cacheKey()
    {
        return "threads.{$this->thread->id}.visits";
    }

}