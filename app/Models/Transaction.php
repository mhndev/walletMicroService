<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Transaction Model class
 *
 * @property int $userId
 * @property int $amount
 * @property string $reference_id
 */
class Transaction extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'amount',
        'reference_id'
    ];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }


}