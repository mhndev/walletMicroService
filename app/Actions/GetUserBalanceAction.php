<?php
namespace App\Actions;

use App\Repositories\WalletRepository;

/**
 * GetUserBalanceAction class
 */
class GetUserBalanceAction
{

    public function __construct(private WalletRepository $walletRepository) {}

    /**
     * @return integer
     */
    public function __invoke(int $userId): int
    {
        return $this->walletRepository->getUserBalance($userId);
    }

}