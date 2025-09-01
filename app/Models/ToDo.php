<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ApiResource]
class ToDo extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(ToDoStatus::class, 'to_do_status_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ToDoCategory::class, 'to_do_category_id');
    }
}
