<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProblemType extends Model
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

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function building()
    {
        return $this->belongsTo(Building::class);
    }
    public function printer()
    {
        return $this->belongsTo(Printer::class);
    }
    public function problemType()
    {
        return $this->belongsTo(ProblemType::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
