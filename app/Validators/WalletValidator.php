<?php
namespace App\Validators;

use Illuminate\Validation\Factory;

/**
 * Class WalletValidator
 * @package App\Validators
 */
class WalletValidator
{
    /**
     * @var Factory
     */
    private Factory $validator;

    /**
     * ClientValidator constructor.
     * @param Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @return void
     */
    public function validateAddMoneyToUserWallet(array $data)
    {
        $this->validator->validate($data, [
            'amount' => 'required|integer',
            'user_id' => 'required|integer'
        ]);
    }



}