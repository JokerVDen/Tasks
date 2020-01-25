<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Task Model
 * @package App\Models
 */
class Task extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'task',
        'performed',
        'status',
    ];

    /**
     * Returns fields of table that are allow for order
     *
     * @return array
     */
    public function getAllowedForOrder()
    {
        $allowedOrders = [
            'name',
            'email',
            'performed',
        ];
        return $allowedOrders;
    }
}