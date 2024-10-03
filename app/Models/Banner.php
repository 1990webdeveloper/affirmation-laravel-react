<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'status'
    ];
    protected $appends = ['banner'];

    public function getBannerAttribute(){
        return asset('storage/banner/'.$this->attributes['image']);
    }
}
