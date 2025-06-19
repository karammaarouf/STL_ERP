<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\FinancialTransactionFactory> */
    use HasFactory, SoftDeletes;
}
