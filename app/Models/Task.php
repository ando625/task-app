<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'content',
        'priority',
        'due_at',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //優先度ラベル
    public function getPriorityLabelAttribute()
    {
        return match ($this->priority){
            1 => '低',
            2 => '中',
            default => '高',
        };
    }

    //進捗度ラベル
    public function getStatusLabelAttribute()
    {
        return match ($this->status){
            'todo' => '未着手',
            'in_progress' => '作業中',
            'completed' => '完了',
            default => '未着手',
        };
    }

    protected $casts = [
        'due_at' => 'datetime',
    ];
}
