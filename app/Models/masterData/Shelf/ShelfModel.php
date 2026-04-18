<?php

namespace App\Models\masterData\Shelf;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShelfModel extends Model
{
    use HasFactory;

    protected $table = 'shelves';

    protected $fillable = [
        'code',
        'name',
        'room_id',
        'status_id',
        'created_by',
    ];

    public function room()
    {
        return $this->belongsTo(\App\Models\masterData\Room\RoomModel::class, 'room_id');
    }

    public function locations()
    {
        return $this->hasMany(\App\Models\masterData\Location\LocationModel::class, 'shelf_id');
    }
}
