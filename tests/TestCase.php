<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    use CreatesApplication, DatabaseTransactions;
}
