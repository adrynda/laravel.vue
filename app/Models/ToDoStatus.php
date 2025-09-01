<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
class ToDoStatus extends Model
{
    public $timestamps = false;
}
