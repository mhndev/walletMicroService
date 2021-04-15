<?php

namespace Tests;

use App\Constants\Routes;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, MigrateFreshSeedOnce;

        /**
     * @param string $routeName
     * @param array $params
     * @return string
     */
    public function getRoute(string $routeName, array $params = []): string
    {
        return Routes::getRoute($routeName, $params);
    }

}