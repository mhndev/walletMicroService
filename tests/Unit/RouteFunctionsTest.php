<?php

namespace Tests\Unit;

use App\Constants\Routes;
use App\Exceptions\RouteParamsDontMatchException;
use PHPUnit\Framework\TestCase;

class RouteFunctionsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRouteWithUnmatchedRouteParamsShouldThrowException()
    {
        $this->expectException(RouteParamsDontMatchException::class);

        Routes::getRoute(Routes::GET_BALANCE);
    }


        /**
     * A basic test example.
     *
     * @return void
     */
    public function testRouteWithParamsWorksCorrectly()
    {
        $route = Routes::getRoute(Routes::GET_BALANCE, ['user_id' => 10]);

        $this->assertEquals("/api/v1/wallet/get-balance/10", $route);
    }

}
