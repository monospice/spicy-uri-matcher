<?php

namespace tests\Traits\UrlMatcher;

use League\Uri\Url;

trait InstantiationTests
{

    function it_is_initializable()
    {
        $this->shouldHaveType('Monospice\SpicyUrlMatcher\UrlMatcher');
    }

    function it_loads_a_url_from_a_string_using_setter()
    {
        $this->setUrl($this->ascii->url);
        $this->getUrl()->shouldHaveType('League\Uri\Url');
        $this->getUrlString()->shouldReturn($this->ascii->url);

        // url() is an alias for setUrl()
        $this->url($this->ascii->url);
        $this->getUrl()->shouldHaveType('League\Uri\Url');
        $this->getUrlString()->shouldReturn($this->ascii->url);
    }

    function it_loads_a_url_from_a_string_using_constructor()
    {
        $this->beConstructedWith($this->ascii->url);
        $this->getUrl()->shouldHaveType('League\Uri\Url');
        $this->getUrlString()->shouldReturn($this->ascii->url);
    }

    function it_loads_a_url_from_the_server_array()
    {
        // Set the $_SERVER superglobal for the following test
        $oldServer = $_SERVER;
        $_SERVER = array_replace($this->ascii->serverArray);

        // Try to set the url from the $_SERVER superglobal when no arguments
        // are passed
        $this->setUrlFromServer();
        $this->getUrl()->shouldHaveType('League\Uri\Url');
        $this->getUrlString()->shouldReturn($this->ascii->serverUrl);

        // Revert the altered $_SERVER superglobal for the remainder of the test
        $_SERVER = $oldServer;

        $this->setUrlFromServer($this->ascii->serverArray);
        $this->getUrl()->shouldHaveType('League\Uri\Url');
        $this->getUrlString()->shouldReturn($this->ascii->serverUrl);

        // server() is an alias for setUrlFromServer()
        $this->server($this->ascii->serverArray);
        $this->getUrl()->shouldHaveType('League\Uri\Url');
        $this->getUrlString()->shouldReturn($this->ascii->serverUrl);
    }

    function it_loads_a_url_from_a_parse_url_components_array()
    {
        $this->setUrlFromComponents($this->ascii->components);
        $this->getUrl()->shouldHaveType('League\Uri\Url');
        $this->getUrlString()->shouldReturn($this->ascii->url);

        // components() is an alias for setUrlFromComponents()
        $this->components($this->ascii->components);
        $this->getUrl()->shouldHaveType('League\Uri\Url');
        $this->getUrlString()->shouldReturn($this->ascii->url);
    }

    function it_loads_a_url_from_a_url_object_using_setter()
    {
        $urlObject = Url::createFromString($this->ascii->url);
        $this->beConstructedWith($urlObject);
        $this->getUrl()->shouldHaveType('League\Uri\Url');
        $this->getUrlString()->shouldReturn($this->ascii->url);
    }

    function it_returns_the_current_object_for_chaining_after_setting_url()
    {
        $this->setUrl($this->ascii->url)
            ->shouldHaveType('Monospice\SpicyUrlMatcher\UrlMatcher');
        $this->url($this->ascii->url)
            ->shouldHaveType('Monospice\SpicyUrlMatcher\UrlMatcher');
        $this->setUrlFromServer($this->ascii->serverArray)
            ->shouldHaveType('Monospice\SpicyUrlMatcher\UrlMatcher');
        $this->server($this->ascii->serverArray)
            ->shouldHaveType('Monospice\SpicyUrlMatcher\UrlMatcher');
        $this->setUrlFromComponents($this->ascii->components)
            ->shouldHaveType('Monospice\SpicyUrlMatcher\UrlMatcher');
        $this->components($this->ascii->components)
            ->shouldHaveType('Monospice\SpicyUrlMatcher\UrlMatcher');
    }

}

