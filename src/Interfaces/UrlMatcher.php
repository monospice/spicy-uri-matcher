<?php

namespace Monospice\SpicyUrlMatcher\Interfaces;

use League\Url\Url;

/**
 * Compare URIs and URI components
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 */
interface UrlMatcher
{

	/**
	 * Set the URL to match against.
	 *
	 * @param mixed The URL to match against
	 */
    public function setUrl($url);

    /**
     * Determine if the URI set is valid for comparison
     *
     * @return bool True if the URI is valid for comparison
     */
    public function isValid();

	/**
	 * Get the current URL object.
	 *
	 * @return League\Url\Url The current URL object
	 */
    public function getUrl();

	/**
	 * Get the string representation of the current URL.
	 *
	 * @return string The current URL
	 */
	public function getUrlString();

	/**
	 * Get the array of matched results from a regular expression comparison
	 *
	 * @return array The array of matched results
	 *
	 * @throws RuntimeException If the method is called before performing a
	 * regular expression comparison with ::matches()
	 */
	public function getResults();
}

