<?php

namespace tests\Spec\Monospice\SpicyUrlMatcher\Matchers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use League\Uri\Path;

class PathMatcherSpec extends ObjectBehavior
{
    use \tests\Traits\UriDataProvider;
    use \tests\Traits\ComponentTests;

    function let()
    {
        $this->useUriDataProviders();

        $this->asciiTestSubject = $this->ascii->urlObject->path;
        $this->asciiExpectedResult = $this->ascii->path;
        $this->asciiPartial = $this->ascii->directory1;
        $this->asciiStart = '/' . $this->ascii->directory1;
        $this->asciiEnd = $this->ascii->basename;
        $this->utfTestSubject = $this->utf->urlObject->path;
        $this->utfExpectedResult = $this->utf->path;
        $this->utfPartial = $this->utf->directory1;
        $this->utfStart = '/' . $this->utf->directory1;
        $this->utfEnd = $this->utf->basename;
        $this->emptyTestSubject = new Path();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Monospice\SpicyUrlMatcher\Interfaces' .
            '\PathMatcher');
        $this->shouldHaveType('Monospice\SpicyUrlMatcher\Matchers\PathMatcher');
    }

    function it_provides_access_to_path_segments_for_comparison()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->key(0)->shouldHaveType('Monospice\SpicyUrlMatcher\Matchers' .
            '\BasicMatcher');
        $this->key(0)->is($this->ascii->directory1)->shouldReturn(true);
        $this->key(999)->is($this->ascii->directory1)->shouldReturn(false);

        // segment() is an alias for HostMatcher::key()
        $this->segment(0)->shouldHaveType('Monospice\SpicyUrlMatcher\Matchers' .
            '\BasicMatcher');
        $this->segment(0)->is($this->ascii->directory1)->shouldReturn(true);
        $this->segment(999)->is($this->ascii->directory1)->shouldReturn(false);
    }

    function it_checks_that_a_path_contains_a_given_key()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->hasKey(0)->shouldReturn(true);
        $this->hasKey(999)->shouldReturn(false);

        // hasSegment() is an alias for HostMatcher::hasKey()
        $this->hasSegment(0)->shouldReturn(true);
        $this->hasSegment(999)->shouldReturn(false);
    }
}

