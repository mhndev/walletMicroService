<?php
namespace App\Http\V1;

use App\Actions\AddMoneyToUserWalletAction;
use App\Actions\GetUserBalanceAction;
use App\Validators\WalletValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

/**
 * WalletController
 */
class WalletController extends BaseController
{

    public function __construct(
        private AddMoneyToUserWalletAction $addMoneyToUserWalletAction,
        private GetUserBalanceAction $getUserBalanceAction,
        private WalletValidator $walletValidator
    ) {}


    /**
     * @param integer $userId
     * @return JsonResponse
     */
    public function getUserBalance(int $userId): JsonResponse
    {
        $balance = $this->getUserBalanceAction->__invoke($userId);

        return response()->json([
            'balance' => $balance
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function addMoney(): JsonResponse
    {
        $this->walletValidator->validateAddMoneyToUserWallet(request()->all());

        $transaction = $this->addMoneyToUserWalletAction->__invoke(
            request('user_id'),
            request('amount')
        );

        return response()->json(['reference_id' => $transaction->reference_id]);
    }

}