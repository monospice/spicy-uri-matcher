<?php

namespace tests\Providers;

class InvalidUrlDataProvider extends AsciiUrlDataProvider {

    public $subdomain = '';
    public $domain = '';

    protected function initializeUrlObjects()
    {
        // Don't initialize URI objects for the Invalid URI Data Provider
        // (a League\Uri\Uri object cannot be created from an invalid URI)
    }
}

