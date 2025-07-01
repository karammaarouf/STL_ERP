<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseRack extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'section_id'
    ];

    public function section()
    {
        return $this->belongsTo(WarehouseSection::class);
    }

    public function slots()
    {
        return $this->hasMany(WarehouseSlot::class, 'rack_id');
    }
}

