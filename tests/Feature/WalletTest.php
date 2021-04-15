<?php

namespace Tests\Feature;

use App\Constants\Routes;
use App\Models\Wallet;
use Tests\TestCase;

class WalletTest extends TestCase
{

    /**
     * @param integer $userId
     * @param integer $balance
     * @return void
     */
    private function createWallet(int $userId, int $balance = 0)
    {
        Wallet::query()->create([
            'user_id' => $userId,
            'balance' => $balance
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_balance_api_is_200_and_returns_correct_balance()
    {
        $this->createWallet(1, 1000);

        $route = $this->getRoute(Routes::GET_BALANCE, ['user_id' => 1]);

        $response = $this->get($route);

        $response->assertStatus(200);
        $response->assertJson([
            'balance' => true
        ]);
        $this->assertEquals(1000, $response['balance']);
    }


    public function test_get_balance_for_none_exsiting_user_should_give_us_404()
    {
        $route = $this->getRoute(Routes::GET_BALANCE, ['user_id' => 1000]);

        $response = $this->get($route);

        $response->assertStatus(404);
    }


    public function test_add_money_api_call_validation_works()
    {
        $route = $this->getRoute(Routes::ADD_MONEY);

        $response = $this->postJson($route, ['amount' => 2200]);

        $response->assertStatus(422);
    }

    public function test_add_money_api_call_status_is_200_and_give_us_reference_code_in_response()
    {
        $route = $this->getRoute(Routes::ADD_MONEY);

        $response = $this->postJson($route, ['amount' => 2200, 'user_id' => 1]);

        $response->assertStatus(200);
        $response->assertJson(['reference_id'=> true]);
    }


    public function test_user_balance_after_add_money()
    {
        $route = $this->getRoute(Routes::ADD_MONEY);


        $userId = 1;

        $userWalletBeforeAddMoney = Wallet::query()->where('user_id', $userId)->first();
        $this->postJson($route, ['amount' => 2200, 'user_id' => $userId]);

        $userWalletAfterAddMoney =  Wallet::query()->where('user_id', $userId)->first();

        $this->assertEquals($userWalletAfterAddMoney->balance, $userWalletBeforeAddMoney->balance+2200);
    }

}
