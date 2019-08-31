<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Analysis extends Model
{
    protected $guarded = [];

    protected $casts = ['analysis_data' => 'json'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function thread()
    {
        return $this->hasOne(Thread::class, 'analysis_id');
    }

    /**
     * @return mixed
     */
    public static function addAnalysis()
    {
        return static::create([
            'user_id' => auth()->id(),
            'image_url' => \request('image_url'),
            'analysis_data' => \request('analysis_data'),
        ]);
    }

    /**
     * @param $analysisId
     * @return mixed
     */
    public static function isValidAnalysis($analysisId)
    {
        return self::where('user_id', auth()->id())->where('published', false)->where('id', $analysisId)->first();
    }

    /**
     * @return string
     */
    public function getImageFullPathAttribute()
    {
        return "https://www.tradingview.com/x/" . $this->image_url;
    }

}
