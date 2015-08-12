<?php

namespace Monospice\SpicyUrlMatcher\Matchers;

use League\Uri\Query;

use Monospice\SpicyUrlMatcher\Interfaces;
use Monospice\SpicyUrlMatcher\Matchers\BasicMatcher;

/**
 * Compares URI Query Components
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 * @see League\Uri\Query The underlying Host Uri Component
 * @link http://url.thephpleague.com/4.0/components/query/ For information about
 * the underlying Host Uri Component
 */
class QueryMatcher extends BasicMatcher implements Interfaces\MatchesKeys
{

    /**
     * array The array representation of the subject query
     *
     * @internal
     */
    protected $subjectArray;


    /**
     * Checks if two query strings contain exactly the same key/value pairs
     *
     * @api
     *
     * @param mixed $match The League\Uri\Query object, array of key/value
     * pairs, or query string to compare
     *
     * @return bool True if the given query contains exactly the same key/value
     * pairs as the subject query
     */
    public function is($match)
    {
        if (is_string($match) && parent::is($match)) {
            return true;
        }

        $matchArray = self::parseQueryToArray($match);

        return $this->getSubjectArray() === $matchArray;
    }


    /**
     * Checks if the subject contains the key/value pairs of the comparison
     *
     * @api
     *
     * @param mixed $match The League\Uri\Query object, array of key/value
     * pairs, or query string to compare
     *
     * @return bool True if the subject query contains each of the key/value
     * pairs of the given query
     */
    public function has($match)
    {
        if (is_string($match) && parent::has($match)) {
            return true;
        }

        $subjectArray = $this->getSubjectArray();
        $matchArray = self::parseQueryToArray($match);

        if (count($matchArray) === 0 && count($subjectArray > 0)) {
            return false;
        }

        $matched = array_intersect_assoc($matchArray, $this->getSubjectArray());

        return count($matched) === count($matchArray);
    }


    /**
     * WARNING: Although this package provides QueryMatcher::startsWith()
     * for completeness, this method compares by string only! Parameters in a
     * query string can arrive in any arbitrary order, so comparing the start
     * of the string is unreliable!
     */
    public function startsWith($string)
    {
        return parent::startsWith($string);
    }


    /**
     * WARNING: Although this package provides QueryMatcher::endsWith()
     * for completeness, this method compares by string only! Parameters in a
     * query string can arrive in any arbitrary order, so comparing the end
     * of the string is unreliable!
     */
    public function endsWith($string)
    {
        return parent::endsWith($string);
    }


    /**
     * WARNING: Although this package provides QueryMatcher::matches()
     * for completeness, this method compares by string only! Parameters in a
     * query string can arrive in any arbitrary order, so comparing multiple
     * keys using regular expressions on the string is unreliable!
     */
    public function matches($pattern, $flags = 0, $offset = 0)
    {
        return parent::matches($pattern, $flags, $offset);
    }


    // Inherit Doc from Interfaces\KeyMatcher
    public function key($key)
    {
        $value = $this->subject->getValue($key);

        // Store a reference to the sub matcher so we can get regex results
        return $this->subMatcher = new BasicMatcher($value);
    }


    // Inherit Doc from Interfaces\KeyMatcher
    public function hasKey($key)
    {
        return $this->subject->hasKey($key);
    }


    /**
     * Gets the array representation of the current query string
     *
     * @internal
     *
     * @return array The array representation of the current query string
     */
    protected function getSubjectArray()
    {
        if ($this->subjectArray !== null) {
            return $this->subjectArray;
        }

        return $this->subjectArray = self::parseQueryToArray($this->subject);
    }


    /**
     * Parses a query into an array and sorts by key from low to high.
     * Use this function to maintain uniform arrays for comparison.
     *
     * @internal
     *
     * @param mixed $query The query to parse. Can be an instance of
     * League\Uri\Query, an array of key/value pairs, or a query string
     *
     * @return array The parsed query array
     */
    protected static function parseQueryToArray($query)
    {
        if ($query instanceof Query) {
            $queryArray = $query->toArray();
        } elseif (is_array($query)) {
            $queryArray = $query;
        } else {
            // attempt to parse the query as a string
            $query = (string) $query;

            // remove leading question mark if it exists
            if (strlen($query) && $query[0] === '?') {
                $query = substr($query, 1);
            }
            $queryArray = Query::parse($query);
        }

        ksort($queryArray);

        return $queryArray;
    }

}

