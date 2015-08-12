<?php

namespace tests\Spec\Monospice\SpicyUrlMatcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use League\Uri\Url;

use tests\Providers\AsciiUrlDataProvider;
use tests\Providers\UtfUrlDataProvider;

/**
 * Class spec and unit tests for Monospice\SpicyUrlMatcher\UrlMatcher
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 */
class UrlMatcherSpec extends ObjectBehavior
{

    use \tests\Traits\UriDataProvider;
    use \tests\Traits\UrlMatcher\InstantiationTests;
    use \tests\Traits\UrlMatcher\ValidationTests;
    use \tests\Traits\UrlMatcher\ExactMatchTests;
    use \tests\Traits\UrlMatcher\PartialMatchTests;
    use \tests\Traits\UrlMatcher\StartsWithMatchTests;
    use \tests\Traits\UrlMatcher\EndsWithMatchTests;
    use \tests\Traits\UrlMatcher\RegexMatchTests;
    use \tests\Traits\UrlMatcher\ExceptionTests;

    function let()
    {
        $this->useUriDataProviders();
    }

}

