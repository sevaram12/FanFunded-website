<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportsModel extends Model
{
    use HasFactory;
    const TABLE = 'sports';
    protected $table = self::TABLE;
    protected $fillable =
     [
        
        
        'key',
        'group',
        'title',
        'description',
        'active',
        'has_outrights',

    ];

    public $timestamps =true;
}
