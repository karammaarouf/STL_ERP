<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipmentFinancialTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\ShipmentFinancialTransactionFactory> */
    use HasFactory,SoftDeletes;
}
