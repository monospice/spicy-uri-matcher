<?php

namespace Monospice\SpicyUrlMatcher\Interfaces;

/**
 * Compares URIs and URI Components against strings
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 */
interface Matcher
{

    /**
     * Set the subject that will be compared
     *
     * @api
     *
     * @param mixed $subject The subject that will be compared
     *
     * @return Matcher The Matcher object for chaining
     */
    public function setSubject($subject);

    /**
     * Gets the string representation of the subject that is compared against
     *
     * @api
     *
     * @return string The string representation of the subject that is
     * compared against
     */
    public function getSubjectString();

    /**
     * Get the array of matched results from a regular expression comparison
     *
     * @api
     *
     * @param int $key The key of the result to fetch
     *
     * @return mixed The array of matched results or the value of a matched
     * result element if getting by key
     *
     * @throws \RuntimeException If the method is called before performing a
     * regular expression comparison with ::matches()
     * @throws \OutOfBoundsException If the given $key is not contained in the
     * regular expression results array
     */
    public function getResult($key = null);

    /**
     * Check if matched results exist from a regular expression comparison
     *
     * @api
     *
     * @param int $key The key of the result to check
     *
     * @return bool True if the regex match result exists
     */
    public function hasResult($key = null);

    /**
     * Match a URL or URL component exactly.
     *
     * @api
     *
     * @param string $string The string to match against
     *
     * @return bool True if the subject matches the given string exactly
     */
    public function is($string);

    /**
     * An alias for is()
     *
     * @api
     *
     * @param string $string The string to match against
     *
     * @return bool True if the subject matches the given string exactly
     */
    public function equals($string);

    /**
     * Match a URL or URL component that contains the given pattern.
     *
     * @api
     *
     * @param string $string The string to match against
     *
     * @return bool True if the subject contains the given string
     */
    public function has($string);

    /**
     * An alias for has()
     *
     * @api
     *
     * @param string $string The string to match against
     *
     * @return bool True if the subject contains the given string
     */
    public function contains($string);

    /**
     * Match the beginning of the URL or URL component against the given
     * string.
     *
     * @api
     *
     * @param string $string The string to match agaist
     *
     * @return bool True of the subject starts with the given string
     */
    public function startsWith($string);

    /**
     * Match the end of the URL or URL component against the given string.
     *
     * @api
     *
     * @param string $string The string to match agaist
     *
     * @return bool True of the subject ends with the given string
     */
    public function endsWith($string);

    /**
     * Match against the given regular expression. Remember to escape path
     * delimeter slashes and use the "/u" modifier when working with IDN
     * (Unicode-containing) URLs.
     *
     * @api
     * @see preg_match
     * @link http://php.net/manual/en/function.preg-match.php
     *
     * @param string $pattern The regular expression to match against
     * @param int $flags Any flags to pass to preg_match()
     * @param int $offset The offset to pass to preg_match()
     *
     * @return bool True if the subject matches the given regular expression
     */
    public function matches($pattern, $flags = 0, $offset = 0);

    /**
     * Assert that the URI or URI component is equal to an empty string.
     *
     * @api
     *
     * @return bool True of the subject is empty
     */
    public function isEmpty();

    /**
     * Handles dynamic comparison method calls from other classes
     *
     * @internal
     *
     * @param string $methodName The name of the comparison method to call
     * @param array $arguments The arguments to pass to the method
     *
     * @return bool The results of the comparison
     *
     * @throws \BadMethodCallException If the dynamic method name does not
     * match a valid method
     */
    public function callMethod($methodName, array $arguments);

    /**
     * Handles dynamic method calls to the underlying Uri Component object
     *
     * @internal
     *
     * @param string $methodCalled The name of the method to call on the Uri
     * Component object
     * @param array $arguments The array of arguments to pass to the called
     * method
     *
     * @return bool The results of the dynamic method call on the Uri
     * component object
     */
    public function __call($methodCalled, array $arguments);
}

