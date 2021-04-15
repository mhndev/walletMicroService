<?php
namespace App\Actions;

use App\Repositories\WalletRepository;

/**
 * CalculateTotalAmountOfTransactions class
 */
class CalculateTotalAmountOfTransactionsAction
{

    public function __construct(private WalletRepository $walletRepository) {}


    public function __invoke()
    {
        return $this->walletRepository->sumAllTransactionAmounts();
    }

}