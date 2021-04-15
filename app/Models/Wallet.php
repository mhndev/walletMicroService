<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Wallet Model class
 * @property int  $user_id
 * @property float $balance
 */
class Wallet extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'balance',
    ];


    /**
     * @return boolean
     */
    public function isBalanceNegative(): bool
    {
        return $this->balance < 0;
    }

}