<?php

namespace App\Models\masterData\Document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentModel extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $fillable = [
        'code',
        'name',
        'location_id',
        'status_id',
        'expired_date',
        'created_by',
    ];

    protected $casts = [
        'expired_date' => 'date',
    ];

    public function location()
    {
        return $this->belongsTo(\App\Models\masterData\Location\LocationModel::class, 'location_id');
    }
}
