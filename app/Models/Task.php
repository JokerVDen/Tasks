<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Task Model
 * @package App\Models
 */
class Task extends Model
{
    protected $fillable = [
        'name',
        'email',
        'tasl',
        'performed',
    ];
}