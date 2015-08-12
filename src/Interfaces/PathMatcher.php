<?php

namespace Monospice\SpicyUrlMatcher\Interfaces;

use Monospice\SpicyUrlMatcher\Interfaces;

/**
 * Compares URI Path components
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 * @see League\Uri\Path The underlying Path Uri Component
 * @link http://url.thephpleague.com/4.0/components/path/ For information about
 * the underlying Path Uri Component
 */
interface PathMatcher extends Interfaces\Matcher
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
    public function segment($key);

    /**
     * An alias for Interfaces\KeyMatcher::hasKey()
     *
     * @api
     *
     * @param mixed $key The key integer or string
     *
     * @return bool True if the component has the given key
     */
    public function hasSegment($key);

}
