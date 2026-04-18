<?php

namespace App\Models\masterData\Room;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomModel extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'code',
        'name',
        'warehouse_id',
        'status_id',
        'created_by',
    ];

    public function warehouse()
    {
        return $this->belongsTo(\App\Models\masterData\Warehouse\WarehouseModel::class, 'warehouse_id');
    }

    public function shelves()
    {
        return $this->hasMany(\App\Models\masterData\Shelf\ShelfModel::class, 'room_id');
    }
}
