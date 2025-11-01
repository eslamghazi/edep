<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'technician_name',
        'service_quality',
        'response_time',
        'technician_behavior',
        'technician_competence',
        'problem_solved',
        'would_recommend',
        'notes'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
