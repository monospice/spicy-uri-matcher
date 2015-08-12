<?php

namespace Monospice\SpicyUrlMatcher\Interfaces;

/**
 * Compares Hosts and Hostnames
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 * @see League\Uri\Host The underlying Host Uri Component
 * @link http://url.thephpleague.com/4.0/components/host/ For information about
 * the underlying Host Uri Component
 */
interface HostMatcher
{
    /**
     * An alias for Interfaces\KeyMatcher::key()
     *
     * @api
     *
     * @param mixed $key The key integer or string
     *
     * @return Interfaces\Matcher The matcher that will perform the comparison
     * on the value corresponding to the given key
     */
    public function label($key);

    /**
     * An alias for Interfaces\KeyMatcher::hasKey()
     *
     * @api
     *
     * @param mixed $key The key integer or string
     *
     * @return bool True if the component has the given key
     */
    public function hasLabel($key);

    /**
     * Determine if the hostname's public suffix is valid
     *
     * @api
     *
     * @return bool True if the public suffix is valid
     */
    public function publicSuffixIsValid();
}

