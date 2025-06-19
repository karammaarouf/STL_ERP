<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialAccount extends Model
{
    /** @use HasFactory<\Database\Factories\FinancialAccountFactory> */
    use HasFactory, SoftDeletes;
}
