<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'professionalism',
        'response_time',
        'quality_of_work',
        'communication',
        'overall_satisfaction',
        'notes'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
