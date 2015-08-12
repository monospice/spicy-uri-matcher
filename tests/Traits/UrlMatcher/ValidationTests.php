<?php

namespace tests\Traits\UrlMatcher;

trait ValidationTests
{

    function it_determines_if_the_url_set_from_string_is_valid()
    {
        $this->setUrl($this->ascii->url);
        $this->isValid()->shouldReturn(true);
        $this->setUrl($this->invalid->url);
        $this->isValid()->shouldReturn(false);
    }

    function it_determines_if_a_unicode_url_set_from_string_is_valid()
    {
        $this->setUrl($this->utf->url);
        $this->isValid()->shouldReturn(true);
    }

    function it_determines_if_the_url_set_from_server_is_valid()
    {
        // First test the valid server array
        // Set the $_SERVER superglobal for the following test
        $oldServer = $_SERVER;
        $_SERVER = array_replace($this->ascii->serverArray);

        // Try to set the url from the $_SERVER superglobal when no arguments
        // are passed
        $this->setUrlFromServer();
        $this->isValid()->shouldReturn(true);

        // Now test the invalid server array
        $oldServer = $_SERVER;
        $_SERVER = array_replace($this->ascii->invalidServerArray);

        $this->setUrlFromServer();
        $this->isValid()->shouldReturn(false);

        // Revert the altered $_SERVER superglobal for the remainder of the test
        $_SERVER = $oldServer;
    }

    function it_fails_the_comparison_if_the_url_object_is_not_valid()
    {
        $this->setUrl($this->invalid->url);
        $this->is($this->asciiExpectedResult)->shouldReturn(false);
    }

}

