<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function enableAuth()
{
    config()->set('auth.registration.required', true);
}

    public function disableAuth()
    {
        config()->set('auth.registration.required', false);
    }

    public function enableRegistration()
    {
        config()->set('auth.registration.enabled', true);
    }

    public function disableRegistration()
    {
        config()->set('auth.registration.enabled', false);
    }
}
