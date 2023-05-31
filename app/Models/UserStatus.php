<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    public const STATUS_ENABLED = 1;
    public const STATUS_DISABLED = 0;
}
