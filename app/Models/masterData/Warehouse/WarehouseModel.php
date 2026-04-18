<?php

namespace App\Models\masterData\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseModel extends Model
{
    use HasFactory;

    protected $table = 'warehouses';

    protected $fillable = [
        'code',
        'name',
        'department_id',
        'status_id',
        'created_by',
    ];

    public function rooms()
    {
        return $this->hasMany(\App\Models\masterData\Room\RoomModel::class, 'warehouse_id');
    }
}
