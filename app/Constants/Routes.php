<?php
namespace App\Constants;

use App\Exceptions\RouteParamsDontMatchException;

/**
 * Routes
 */
class Routes
{

    const BASE_URL_V1 = '/api/v1';

    const GET_BALANCE = 'GET_BALANCE';
    const ADD_MONEY = 'ADD_MONEY';

    const ALL_ROUTES = [
        self::GET_BALANCE => '/wallet/get-balance/{user_id}',
        self::ADD_MONEY => '/wallet/add-money'
    ];

    /**
     * @param string $routeName
     * @param array $params
     * @return string
     */
    public static function getRoute(string $routeName, array $params = []): string
    {
        $route = self::BASE_URL_V1 . self::ALL_ROUTES[$routeName];

        $numberOfNeededParams = substr_count($route, '{');

        if(count($params) !== $numberOfNeededParams) {
            throw new RouteParamsDontMatchException("Route params don't match");
        }

        foreach($params as $key => $value) {
            if (!str_contains($route, "{$key}")) {
                throw new RouteParamsDontMatchException("Needed parameter : $key is missed");
            }

            $route = str_replace("{{$key}}",$value,$route);
        }

        return $route;
    }

}
