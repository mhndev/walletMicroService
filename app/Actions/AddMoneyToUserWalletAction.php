<?php
namespace App\Actions;

use App\Repositories\WalletRepository;
use App\Models\Transaction;

/**
 * AddMoneyToUserWalletAction class
 */
class AddMoneyToUserWalletAction
{

    public function __construct(private WalletRepository $walletRepository) {}


    /**
     * @param integer $userId
     * @param integer $amount
     * @return Transaction
     */
    public function __invoke(int $userId, int $amount)
    {
        if(!$this->walletRepository->doesUserHaveWallet($userId)) {
            $this->walletRepository->createWallet($userId, $amount);
        }

        return $this->walletRepository->addMoneyToUserWallet($userId, $amount);
    }

}