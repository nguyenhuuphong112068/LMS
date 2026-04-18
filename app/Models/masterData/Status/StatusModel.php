<?php

namespace App\Models\masterData\Status;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusModel extends Model
{
    use HasFactory;

    protected $table = 'statuses';

    protected $fillable = [
        'name',
        'active',
        'prepareBy',
    ];
}
