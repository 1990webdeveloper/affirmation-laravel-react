<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affirmation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'binaural_beat_id',
        'background_audio_id', 'name',
        'recorded_audio', 'mix_audio',
        'recorded_transcription', 'images', 'effect_type',
        'is_transcription_display', 'step'
    ];

    protected $appends = ['modification_date', 'audio_url', 'mixed_audio_url', 'images_url'];

    public function getModificationDateAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d-M-Y | h:i');
    }

    public function getAudioUrlAttribute()
    {
        return $this->attributes['recorded_audio'] ? asset('storage/audio_file/' . $this->attributes['recorded_audio']) : null;
    }

    public function getMixedAudioUrlAttribute()
    {
        return $this->attributes['mix_audio'] ? asset('storage/mix_audio_file/' . $this->attributes['mix_audio']) : null;
    }

    public function getImagesUrlAttribute()
    {
        $urls = null;
        if ($this->attributes['images']) {
            foreach (explode(',', $this->attributes['images']) as $image) {
                $urls[] = $this->attributes['images'] ? asset('storage/affirmation/' . $this->attributes['id'] . '/' . $image) : null;
            }
        }
        return $urls;
    }
}
