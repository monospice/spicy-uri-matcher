<?php

namespace tests\Traits;

use tests\Providers\AsciiUrlDataProvider;
use tests\Providers\UtfUrlDataProvider;
use tests\Providers\Ipv4UrlDataProvider;
use tests\Providers\Ipv6UrlDataProvider;
use tests\Providers\InvalidUrlDataProvider;
use tests\Providers\InvalidHostUrlDataProvider;

trait UriDataProvider
{
    /**
     * tests\AsciiUrlDataProvider Provides test data for ascii URIs
     */
    protected $ascii;

    /**
     * tests\UtfUrlDataProvider Provides test data for UTF-8 URIs
     */
    protected $utf;

    /**
     * tests\Providers\Ipv4UrlDataProvider Provides test data for IPv4 URIs
     */
    protected $ipv4;

    /**
     * tests\Providers\Ipv6UrlDataProvider Provides test data for IPv6 URIs
     */
    protected $ipv6;

    /**
     * tests\Providers\InvalidUrlDataProvider Provides test data for invalid
     * URIs
     */
    protected $invalid;

    /**
     * tests\Providers\InvalidHostUrlDataProvider Provides test data for hosts
     * with invalid hostnames
     */
    protected $invalidHost;

    /**
     * mixed The ascii subject to compare
     */
    protected $asciiTestSubject;

    /**
     * string The expected result from an ascii comparison
     */
    protected $asciiExpectedResult;

    /**
     * string The ascii partial URI or component to compare
     */
    protected $asciiPartial;

    /**
     * string The ascii partial to compare with startsWith()
     */
    protected $asciiStart;

    /**
     * string The ascii partial to compare with endsWith()
     */
    protected $asciiEnd;

    /**
     * mixed The unicode subject to compare
     */
    protected $utfTestSubject;

    /**
     * string The expected result from an unicode comparison
     */
    protected $utfExpectedResult;

    /**
     * string The unicode partial URI or component to compare
     */
    protected $utfPartial;

    /**
     * string The ascii partial to compare with startsWith()
     */
    protected $utfStart;

    /**
     * string The ascii partial to compare with endsWith()
     */
    protected $utfEnd;

    /**
     * mixed The empty URI or component object to test empty comparisons
     */
    protected $emptyTestSubject;

    /**
     * Instantiates URI data providers in the test class
     */
    protected function useUriDataProviders()
    {
        $this->ascii = new AsciiUrlDataProvider();
        $this->utf = new UtfUrlDataProvider();
        $this->ipv4 = new Ipv4UrlDataProvider();
        $this->ipv6 = new Ipv6UrlDataProvider();
        $this->invalid = new InvalidUrlDataProvider();
        $this->invalidHost = new InvalidHostUrlDataProvider();
    }
}
