<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinauralBeats extends Model
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

    protected $appends = ['beat_url'];

    public function getBeatUrlAttribute()
    {
        return asset('storage/binaural-beats/audio/'.$this->attributes['audio_path']);
    }
}
