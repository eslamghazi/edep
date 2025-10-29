<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Printer extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    /**
     * Get the localized name attribute
     */
    public function getLocalizedNameAttribute()
    {
        return app()->getLocale() === 'en' && $this->name_en ? $this->name_en : $this->name;
    }
}
