<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'activity_date',
        'category_id',
        'code',
        'location',
        'capacity',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query, $keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('code', 'like', "%{$keyword}%");
            });
        });
    }

    public function scopeOfCategory($query, $categoryId)
    {
        return $query->when(
            $categoryId,
            fn ($query, $id) => $query->where('category_id', $id)
        );
    }

    public function scopeOfStatus($query, ?string $status)
    {
        return $query->when(
            $status,
            fn ($query, $status) => $query->where('status', $status)
        );
    }

    public function scopeSortByDate($query, ?string $direction)
    {
        return $query->orderBy(
            'activity_date',
            $direction === 'asc' ? 'asc' : 'desc'
        );
    }
}