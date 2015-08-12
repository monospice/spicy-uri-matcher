<?php

namespace Monospice\SpicyUrlMatcher\Matchers;

use League\Uri\Host;

use Monospice\SpicyUrlMatcher\Interfaces;
use Monospice\SpicyUrlMatcher\Matchers\BasicMatcher;

/**
 * Compares Hosts and Hostnames
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 * @see League\Uri\Host The underlying Host Uri Component
 * @link http://url.thephpleague.com/4.0/components/host/ For information about
 * the underlying Host Uri Component
 *
 * @method bool isIp() Determines if the type of host is an IP Address
 * @method bool isIpv4() Determines if the type of host is an IPv4 Address
 * @method bool isIpv6() Determines if the type of host is an IPv6 Address
 * @method bool hasZoneIdentifier() Determines if the IPv6 host has a zone
 * identifier
 * @method bool isAbsolute() Determines if the hostname is a fully qualified
 * domain name (the hostname is terminated by the empty DNS root label '.')
 * @method bool isIdn() Determines if the hostname is an international domain
 * name (contains unicode characters)
 */
class HostMatcher extends BasicMatcher implements Interfaces\HostMatcher, Interfaces\MatchesKeys
{

    // Inherit Doc from Interfaces\Matcher
    public function is($string)
    {
        return $this->matchAsciiAndUnicode('is', $string);
    }


    // Inherit Doc from Interfaces\Matcher
    public function has($string)
    {
        return $this->matchAsciiAndUnicode('has', $string);
    }


    // Inherit Doc from Interfaces\Matcher
    public function startsWith($string)
    {
        return $this->matchAsciiAndUnicode('startsWith', $string);
    }


    // Inherit Doc from Interfaces\Matcher
    public function endsWith($string)
    {
        return $this->matchAsciiAndUnicode('endsWith', $string);
    }


    // Inherit Doc from Interfaces\Matcher
    public function matches($pattern, $flags = 0, $offset = 0)
    {
        return $this->matchAsciiAndUnicodeRegex('matches', $pattern, $flags,
            $offset);
    }


    // Inherit Doc from Interfaces\MatchesKeys
    public function key($key)
    {
        $value = $this->subject->getLabel($key);

        // Store a reference to the sub matcher so we can get regex results
        return $this->subMatcher = new BasicMatcher($value);
    }


    // Inherit Doc from Interfaces\HostMatcher
    public function label($key)
    {
        return $this->key($key);
    }


    // Inherit Doc from Interfaces\MatchesKeys
    public function hasKey($key)
    {
        return $this->subject->hasKey($key);
    }


    // Inherit Doc from Interfaces\HostMatcher
    public function hasLabel($key)
    {
        return $this->hasKey($key);
    }


    // Inherit Doc from Interfaces\HostMatcher
    public function publicSuffixIsValid()
    {
        return $this->subject->isPublicSuffixValid();
    }


    // Inherit Doc from Interfaces\Matcher
    protected function getFormattedString($urlComponent)
    {
        return parent::getFormattedString(
            $this->formatter->format($urlComponent));
    }

    /**
     * Perform the comparison on both Ascii and Unicode versions of the Host.
     *
     * @internal
     *
     * @param string $method The name of the comparison method to call
     * @param string $string The string or pattern to match against
     *
     * @return bool The result of the comparison
     */
    protected function matchAsciiAndUnicode($method, $string)
    {
        $string = (string) $string;

        if (parent::$method($string)) {
            return true;
        }

        $basicMatcher = new BasicMatcher($this->subject->toAscii());

        return $basicMatcher->$method($string)
            || $basicMatcher->setSubject($this->subject->toUnicode())
                ->$method($string);
    }


    /**
     * Perform the regular expression comparison on both Ascii and Unicode
     * versions of the Host.
     *
     * @internal
     *
     * @param string $method The name of the comparison method to call
     * @param string $string The string or pattern to match against
     *
     * @return bool The result of the comparison
     */
    protected function matchAsciiAndUnicodeRegex($method, $pattern, $flags,
        $offset
    ) {
        if (parent::$method($pattern, $flags, $offset)) {
            return true;
        }

        // Store a reference to the sub matcher so we can get regex results
        $this->subMatcher = new BasicMatcher($this->subject->toAscii());

        $match = $this->subMatcher->$method($pattern, $flags, $offset)
            || $this->subMatcher->setSubject($this->subject->toUnicode())
                ->$method($pattern, $flags, $offset);

        return $match;
    }

}

