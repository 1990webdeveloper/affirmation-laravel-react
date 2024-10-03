<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackgroundAudio extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'audio_path',
        'status'
    ];

    protected $appends = ['bg_audio_url'];

    public function getBgAudioUrlAttribute()
    {
        return asset('storage/background-audio/audio/'.$this->attributes['audio_path']);
    }
}
