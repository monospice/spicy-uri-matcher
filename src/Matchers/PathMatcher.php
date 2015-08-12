<?php

namespace Monospice\SpicyUrlMatcher\Matchers;

use League\Uri\Path;

use Monospice\SpicyUrlMatcher\Interfaces;
use Monospice\SpicyUrlMatcher\Matchers\BasicMatcher;

/**
 * Compares URI Path components
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 * @see League\Uri\Path The underlying Path Uri Component
 * @link http://url.thephpleague.com/4.0/components/path/ For information about
 * the underlying Path Uri Component
 *
 * @method bool isAbsolute() Determines if the path is absolute (begins with
 * a leading slash
 */
class PathMatcher extends BasicMatcher implements Interfaces\PathMatcher, Interfaces\MatchesKeys
{

    // Inherit Doc from Interfaces\MatchesKeys
    public function key($key)
    {
        $value = $this->subject->getSegment($key);

        // Store a reference to the sub matcher so we can get regex results
        return $this->subMatcher = new BasicMatcher($value);
    }


    // Inherit Doc from Interfaces\HostMatcher
    public function segment($key)
    {
        return $this->key($key);
    }


    // Inherit Doc from Interfaces\MatchesKeys
    public function hasKey($key)
    {
        return $this->subject->hasKey($key);
    }


    // Inherit Doc from Interfaces\HostMatcher
    public function hasSegment($key)
    {
        return $this->hasKey($key);
    }

}
