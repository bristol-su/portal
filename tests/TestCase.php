<?php

namespace Tests;

use BristolSU\Support\Testing\HandlesAuthentication;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use BristolSU\Support\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions, HandlesAuthentication;

    public function alias(): string
    {
        return 'support';
    }
}
