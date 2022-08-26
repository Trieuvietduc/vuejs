<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

class Company extends Model
{
    use HasFactory, Notifiable, SoftDeletes, Sortable;
    protected $table = 'company';
    protected $fillable = [
        'id',
        'code',
        'name',
        'telephone',
        'address',
        'deleted_at'
    ];
}
