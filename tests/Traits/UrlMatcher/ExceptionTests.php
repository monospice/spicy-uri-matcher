<?php

namespace tests\Traits\UrlMatcher;

trait ExceptionTests
{

    function it_throws_an_exception_when_attempting_an_invalid_comparison()
    {
        $this->setUrl($this->ascii->url);
        $this->shouldThrow('\BadMethodCallException')
            ->during('hostHasss', [$this->ascii->url]);
    }

    function it_throws_an_exception_when_comparing_an_invalid_url_component()
    {
        $this->setUrl($this->ascii->url);
        $this->shouldThrow('\BadMethodCallException')
            ->during('hhhostIs', [$this->ascii->url]);
    }

    function it_throws_an_excpetion_when_no_comparison_string_is_provided()
    {
        $this->setUrl($this->ascii->url);
        $this->shouldThrow('\BadMethodCallException')->during('is');
    }

    function it_throws_an_exception_when_trying_to_compare_before_setting_url()
    {
        $this->shouldThrow('\RuntimeException')
            ->during('is', [$this->ascii->url]);
    }

    function it_throws_an_exception_when_getting_regex_result_before_compare()
    {
        $this->setUrl($this->ascii->url);
        $this->shouldThrow('\RuntimeException')->during('getResults');
    }

}

