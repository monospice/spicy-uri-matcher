<?php

namespace tests\Spec\Monospice\SpicyUrlMatcher\Matchers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BasicMatcherSpec extends ObjectBehavior
{
    use \tests\Traits\UriDataProvider;
    use \tests\Traits\ComponentTests;

    function let()
    {
        $this->useUriDataProviders();

        $this->asciiTestSubject = $this->ascii->urlObject;
        $this->asciiExpectedResult = $this->ascii->url;
        $this->asciiPartial = $this->ascii->domain;
        $this->asciiStart = $this->ascii->scheme;
        $this->asciiEnd = $this->ascii->fragment;
        $this->utfTestSubject = $this->utf->urlObject;
        $this->utfExpectedResult = $this->utf->url;
        $this->utfPartial = $this->utf->domain;
        $this->utfStart = $this->utf->scheme;
        $this->utfEnd = $this->utf->fragment;
        $this->emptyTestSubject = $this->ascii->emptyUrlObject;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Monospice\SpicyUrlMatcher\Interfaces\Matcher');
        $this->shouldHaveType('Monospice\SpicyUrlMatcher\Matchers' .
            '\BasicMatcher');
    }
}

