<?php
namespace App\Repositories;

use App\Exceptions\WalletBalanceCantBeNegativeException;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Database\Connection;
use Ramsey\Uuid\UuidFactory;
use Throwable;

/**
 * WalletRepository Class
 */
class WalletRepository
{


    /**
     * WalletRepository Constructor
     */
    public function __construct(
        private Wallet $walletModel,
        private Transaction $transactionModel,
        private Connection $connection,
        private UuidFactory $uuidLib
    ) {}

    /**
     * @param integer $userId
     * @param integer $initialValue
     * @return Wallet
     */
    public function createWallet(int $userId): Wallet
    {
        return $this->walletModel->newQuery()->create([
            'user_id' => $userId,
            'balance' => 0
        ]);
    }


    /**
     * @param integer $userId
     * @return boolean
     */
    public function doesUserHaveWallet(int $userId): bool
    {
        return $this->walletModel->newQuery()->where('user_id', $userId)->exists();
    }

    /**
     *
     * @param integer $userId
     * @param int $amount
     * @return Transaction
     */
    public function addMoneyToUserWallet(int $userId, int $amount): Transaction
    {
        /**
         * @var Wallet $wallet
         */
        $wallet = $this->walletModel->newQuery()->where('user_id', $userId)->firstOrFail();
        $wallet->balance += $amount;
        if($wallet->isBalanceNegative()) {
            throw new WalletBalanceCantBeNegativeException;
        }

        try {
            $this->connection->beginTransaction();
            $transaction = $this->transactionModel->newQuery()->create([
                'user_id' => $userId,
                'amount' => $amount,
                'reference_id' => $this->uuidLib->uuid4()
            ]);
            $wallet->save();
            $this->connection->commit();

        } catch (Throwable $e) {

            dd($e->getMessage(), get_class($e));
            $this->connection->rollback();
        }

        return $transaction;
    }

    /**
     * @param integer $userId
     * @return integer
     */
    public function getUserBalance(int $userId): int
    {
        /**
         * @var Wallet $wallet
         */
        $wallet = $this->walletModel->newQuery()->where('user_id', $userId)->firstOrFail();

        return $wallet->balance;
    }


    /**
     * returns sum of amount values in transaction table
     *
     * @return integer
     */
    public function sumAllTransactionAmounts(): int
    {
        return $this->transactionModel->newQuery()->sum('amount');
    }
}
