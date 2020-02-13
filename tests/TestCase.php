<?php

namespace Tests;

use App\Driver;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    public function signIn() {
        $driver = Driver::findOrFail('1');
        $this->be($driver);
    }
}
