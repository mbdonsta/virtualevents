<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPermissionRelation extends Model
{
    protected $fillable = ['user_id', 'permission_id'];

    protected $with = ['permission'];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }
}
