<?php

namespace tests\Spec\Monospice\SpicyUrlMatcher\Matchers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use League\Uri\Host;

class HostMatcherSpec extends ObjectBehavior
{
    use \tests\Traits\UriDataProvider;
    use \tests\Traits\ComponentTests;

    function let()
    {
        $this->useUriDataProviders();

        $this->asciiTestSubject = $this->ascii->urlObject->host;
        $this->asciiExpectedResult = $this->ascii->host;
        $this->asciiPartial = $this->ascii->domain;
        $this->asciiStart = $this->ascii->subdomain;
        $this->asciiEnd = $this->ascii->domain;
        $this->utfTestSubject = $this->utf->urlObject->host;
        $this->utfExpectedResult = $this->utf->host;
        $this->utfPartial = $this->utf->domain;
        $this->utfStart = $this->utf->subdomain;
        $this->utfEnd = $this->utf->domain;
        $this->emptyTestSubject = new Host();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Monospice\SpicyUrlMatcher\Interfaces' .
            '\HostMatcher');
        $this->shouldHaveType('Monospice\SpicyUrlMatcher\Matchers\HostMatcher');
    }

    function it_asserts_that_a_host_is_an_ip_address()
    {
        $this->setSubject($this->ipv4->urlObject->host);
        $this->isIp()->shouldReturn(true);
        $this->setSubject($this->ipv6->urlObject->host);
        $this->isIp()->shouldReturn(true);
        $this->setSubject($this->asciiTestSubject);
        $this->isIp()->shouldReturn(false);
    }

    function it_determines_that_a_host_is_an_ipv4_address()
    {
        $this->setSubject($this->ipv4->urlObject->host);
        $this->isIpv4()->shouldReturn(true);
        $this->setSubject($this->ipv6->urlObject->host);
        $this->isIpv4()->shouldReturn(false);
    }

    function it_determines_that_a_host_is_an_ipv6_address()
    {
        $this->setSubject($this->ipv6->urlObject->host);
        $this->isIpv6()->shouldReturn(true);
        $this->setSubject($this->ipv4->urlObject->host);
        $this->isIpv6()->shouldReturn(false);
    }

    function it_asserts_that_an_ipv6_host_has_a_zone_identifier()
    {
        $this->setSubject($this->ipv6->urlObjectWithZone->host);
        $this->hasZoneIdentifier()->shouldReturn(true);
        $this->setSubject($this->ipv6->urlObject->host);
        $this->hasZoneIdentifier()->shouldReturn(false);
    }

    function it_asserts_that_a_hostname_public_suffix_is_valid()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->publicSuffixIsValid()->shouldReturn(true);
        $this->setSubject($this->invalidHost->urlObject->host);
        $this->publicSuffixIsValid()->shouldReturn(false);
    }

    function it_asserts_that_a_unicode_hostname_public_suffix_is_valid()
    {
        $this->setSubject($this->utfTestSubject);
        $this->publicSuffixIsValid()->shouldReturn(true);
        $this->setSubject($this->invalidHost->urlObject->host);
        $this->publicSuffixIsValid()->shouldReturn(false);
    }

    function it_determines_that_a_hostname_is_a_fully_qualified_domain_name()
    {
        $fqdnHost = new Host($this->ascii->fqdn);
        $this->setSubject($fqdnHost);
        $this->isAbsolute()->shouldReturn(true);
        $this->setSubject($this->asciiTestSubject);
        $this->isAbsolute()->shouldReturn(false);
    }

    function it_determines_that_a_hostname_is_an_international_domain_name()
    {
        $this->setSubject($this->utfTestSubject);
        $this->isIdn()->shouldReturn(true);
        $this->setSubject($this->asciiTestSubject);
        $this->isIdn()->shouldReturn(false);
    }

    function it_flexibly_compares_entire_unicode_host_with_ascii_counterpart()
    {
        $this->setSubject($this->utfTestSubject);
        $this->is($this->utf->asciiUrlObject->host)->shouldReturn(true);
        $this->equals($this->utf->asciiUrlObject->host)->shouldReturn(true);
        $this->setSubject($this->utf->asciiUrlObject->host);
        $this->is($this->utfTestSubject)->shouldReturn(true);
    }

    function it_flexibly_compares_partial_unicode_host_with_ascii_counterpart()
    {
        $this->setSubject($this->utfTestSubject);
        $this->has($this->utf->asciiDomain)->shouldReturn(true);
        $this->contains($this->utf->asciiDomain)->shouldReturn(true);
        $this->setSubject($this->utf->asciiUrlObject->host);
        $this->has($this->utf->domain)->shouldReturn(true);
    }

    function it_flexibly_compares_start_of_unicode_host_with_ascii_counterpart()
    {
        $asciiHostWithoutTld = $this->utf->asciiUrlObject->host->getLabel(0) .
            '.' . $this->utf->asciiUrlObject->host->getLabel(1);
        $utfHostWithoutTld = $this->utfTestSubject->getLabel(0) . '.' .
            $this->utfTestSubject->getLabel(1);

        $this->setSubject($this->utfTestSubject);
        $this->startsWith($asciiHostWithoutTld)->shouldReturn(true);
        $this->setSubject($this->utf->asciiUrlObject->host);
        $this->startsWith($utfHostWithoutTld)->shouldReturn(true);
    }

    function it_flexibly_compares_end_of_unicode_host_with_ascii_counterpart()
    {
        $this->setSubject($this->utfTestSubject);
        $this->endsWith($this->utf->asciiDomain)->shouldReturn(true);
        $this->setSubject($this->utf->asciiUrlObject->host);
        $this->endsWith($this->utf->domain)->shouldReturn(true);
    }

    function it_flexibly_compares_regex_of_unicode_host_with_ascii_counterpart()
    {
        $this->setSubject($this->utfTestSubject);
        $this->matches('/' . $this->utf->asciiDomain . '/')->shouldReturn(true);
        $this->setSubject($this->utf->asciiUrlObject->host);
        $this->matches('/' . $this->utf->domain . '/')->shouldReturn(true);
    }

    function it_provides_access_to_hostname_labels_for_comparison()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->key(0)->shouldHaveType('Monospice\SpicyUrlMatcher\Matchers' .
            '\BasicMatcher');
        $this->key(0)->is($this->ascii->subdomain)->shouldReturn(true);
        $this->key(999)->is($this->ascii->subdomain)->shouldReturn(false);

        // label() is an alias for HostMatcher::key()
        $this->label(0)->shouldHaveType('Monospice\SpicyUrlMatcher\Matchers' .
            '\BasicMatcher');
        $this->label(0)->is($this->ascii->subdomain)->shouldReturn(true);
        $this->label(999)->is($this->ascii->subdomain)->shouldReturn(false);
    }

    function it_checks_that_a_hostname_contains_a_given_key()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->hasKey(0)->shouldReturn(true);
        $this->hasKey(999)->shouldReturn(false);

        // hasLabel() is an alias for HostMatcher::hasKey()
        $this->hasLabel(0)->shouldReturn(true);
        $this->hasLabel(999)->shouldReturn(false);
    }
}

