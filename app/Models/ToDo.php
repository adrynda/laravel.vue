<?php

namespace App\Models;

use ApiPlatform\Laravel\Eloquent\Filter\DateFilter;
use ApiPlatform\Laravel\Eloquent\Filter\EqualsFilter;
use ApiPlatform\Laravel\Eloquent\Filter\PartialSearchFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\QueryParameter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ApiResource]
#[QueryParameter(key: 'priority', filter: EqualsFilter::class)]
#[QueryParameter(key: 'user', filter: EqualsFilter::class)]
#[QueryParameter(key: 'status', filter: EqualsFilter::class)]
#[QueryParameter(key: 'category', filter: EqualsFilter::class)]
#[QueryParameter(key: 'title', filter: PartialSearchFilter::class)]
#[QueryParameter(key: 'notes', filter: PartialSearchFilter::class)]
#[QueryParameter(key: 'createdAt', filter: DateFilter::class)]
#[QueryParameter(key: 'updatedAt', filter: DateFilter::class)]
#[QueryParameter(key: 'dueDate', filter: DateFilter::class)]
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
