<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    public static function get($key)
    {
        $setting = Setting::where('key', $key)->first();

        if ($setting) {
            return $setting->value;
        }

        return null;
    }

    public static function setSettings($key, $value)
    {
        $key = strtolower($key);
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
