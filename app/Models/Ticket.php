<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function setImageAttribute($value)
    {
        if (!empty($value)) {
            $filename = $value->getClientOriginalName();
            $location = storage_path('app/public/tickets');
            $value->move($location, $filename);
            $this->attributes['image'] = $filename;
        }
    }
    public function getImageAttribute($value)
    {
        if ($value) {
            $image  = asset('storage/tickets/' . $value);
            return $image;
        } else {
            return null;
        }
    }
    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by')->withDefault();
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function printer()
    {
        return $this->belongsTo(Printer::class);
    }

    public function problemType()
    {
        return $this->belongsTo(ProblemType::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function scopeFilter(Builder $builder, array $filters): Builder
    {
        return $builder
            ->when(data_get($filters, 'user'), fn ($builder) => $builder->where('user_id', $filters['user']))
            ->when(data_get($filters, 'type_id'), fn ($builder) => $builder->where('problem_type_id', $filters['type_id']))
            ->when(data_get($filters, 'city_id'), fn ($builder) => $builder->where('city_id', $filters['city_id']))
            ->when(data_get($filters, 'department_id'), fn ($builder) => $builder->where('department_id', $filters['department_id']))
            ->when(data_get($filters, 'status'), fn ($builder) => $builder->where('status', $filters['status']))
            ->when(data_get($filters, 'ticket_code'), fn ($builder) => $builder->where('ticket_code', 'like', '%' . $filters['ticket_code'] . '%'))
            ->when(data_get($filters, 'requester_name'), fn ($builder) => $builder->where('requester_name', 'like', '%' . $filters['requester_name'] . '%'))
            ->when(data_get($filters, 'phone_number'), fn ($builder) => $builder->where('phone', 'like', '%' . $filters['phone_number'] . '%'))
            ->when(data_get($filters, 'printer_code'), fn ($builder) => $builder->where('printer_code', 'like', '%' . $filters['printer_code'] . '%'))
            ->when(data_get($filters, ['start_date']) && data_get($filters, ['end_date']), fn ($builder) => $builder->whereBetween('created_at', [
                Carbon::createFromFormat('Y-m-d', $filters['start_date'])->startOfDay(),
                Carbon::createFromFormat('Y-m-d', $filters['end_date'])->endOfDay()
            ]))
            ->when(data_get($filters, 'date_range'), function ($query, $range) {
                $endDate = Carbon::today();
                $startDate = $endDate->copy();

                switch ($range) {
                    case '1':
                        $startDate = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
                        $endDate = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
                        break;
                    case '7':
                        $startDate = Carbon::now()->subDays(7)->format('Y-m-d H:i:s');
                        $endDate = Carbon::now()->format('Y-m-d H:i:s');
                        break;
                    case '30':
                        $startDate = Carbon::now()->subDays(30)->format('Y-m-d H:i:s');
                        $endDate = Carbon::now()->format('Y-m-d H:i:s');
                        break;
                    case '90':
                        $startDate = Carbon::now()->subDays(90)->format('Y-m-d H:i:s');
                        $endDate = Carbon::now()->format('Y-m-d H:i:s');
                        break;
                }

                $query->whereBetween('created_at', [$startDate, $endDate]);
            });
    }

    function scopeUserRole(Builder $builder)
    {
        if (auth()->user()->hasRole('user')) {
            return $builder->where('user_id', auth()->user()->id);
        }
    }
}
