<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function logResponse($response) {
        $content = $response->getContent();
        error_log(substr($response->getContent(), 0, 2000));
    }
}
