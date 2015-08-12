<?php

namespace Monospice\SpicyUrlMatcher\Interfaces;

/**
 * Provides matching access to individual component keys
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 */
interface MatchesKeys
{

    /**
     * Get a component key to perform a comparison
     *
     * @param mixed $key The key integer or string
     *
     * @return Interfaces\Matcher The matcher that will perform the comparison
     * on the value corresponding to the given key
     */
    public function key($key);

    /**
     * Check that a component has the given key
     *
     * @param mixed $key The key integer or string
     *
     * @return bool True if the component has the given key
     */
    public function hasKey($key);

}

