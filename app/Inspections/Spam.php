<?php

namespace App\Inspections;

class Spam
{

    /**
     * @var array
     */
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class,
    ];

    /**
     * @param $body
     * @return bool
     * @throws \Exception
     */
    public function detect($body)
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }

}