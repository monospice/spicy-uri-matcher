<?php

namespace Monospice\SpicyUrlMatcher;

use League\Uri\Url;

use Monospice\SpicyUrlMatcher\Interfaces;
use Monospice\SpicyUrlMatcher\Matchers\BasicMatcher;
use Monospice\SpicyUrlMatcher\Matchers\HostMatcher;

/**
 * Compare URIs and URI components
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 * @link http://docs.monospice.com/uri-matcher
 *
 * @method bool is(string $string) Match the URL exactly agaist a string
 * @method bool schemeIs(string $string) Match the URL scheme component exactly
 * agaist a string
 * @method bool userInfoIs(string $string) Match the URL user info component
 * exactly against a string
 * @method bool userIs(string $string) Match the URL user component
 * exactly against a string
 * @method bool passIs(string $string) Match the URL password component
 * exactly against a string
 * @method bool passwordIs(string $string) An alias for passIs()
 * @method bool hostIs(string $string) Match the URL host component exactly
 * against a string
 * @method bool portIs(integer $int) Match the URL port component exactly
 * against an integer
 * @method bool pathIs(string $string) Match the URL path component exactly
 * against a string
 * @method bool queryIs(string $string) Match the URL query component exactly
 * against a string
 * @method bool fragmentIs(string $string) Match the URL fragment component
 * exactly against a string
 */
class UrlMatcher implements Interfaces\UrlMatcher
{

    /**
     * League\Uri\Url The current URI that will be compared
     * @internal
     */
    protected $url;

    /**
     * Matcher\MatcherInterface The matcher for the current comparison
     * @internal
     */
    protected $matcher;

    /**
     * bool True if the URI is valid
     * @internal
     */
    protected $valid;


    /**
     * Construct a new UrlMatcher object
     *
     * @param mixed The URI to match against
     */
    public function __construct($url = null)
    {
        if ($url !== null) {
            $this->setUrl($url);
        }
    }


    /**
     * Set the URI to match against.
     *
     * @param League\Uri\Url|string The URI to match against
     *
     * @return Monospice\SpicyUrlMatcher\UrlMatcher The current UrlMatcher
     * object used for chaining methods
     */
    public function setUrl($url)
    {
        $this->valid = true;

        if ($url instanceof Url) {
            $this->url = $url;
        } else {
            try {
                $this->url = Url::createFromString($url);
            } catch (\InvalidArgumentException $e) {
                $this->valid = false;
            }
        }

        return $this;
    }


    /**
     * An alias for UriMatcher::setUrl()
     *
     * @see UriMatcher::setUrl() The aliased method
     *
     * @param mixed $url The URI string or League\Uri\Uri object to match against
     *
     * @return UrlMatcher The current UrlMatcher
     * object used for chaining methods
     */
    public function url($url)
    {
        return $this->setUrl($url);
    }


    /**
     * Set the URI to match against from PHP's server variables. Attempts to
     * use the PHP $_SERVER superglobal if no argument is passed.
     *
     * @param array The server variables used to create the URI object
     *
     * @return Monospice\SpicyUrlMatcher\UrlMatcher The current UrlMatcher
     * object used for chaining methods
     */
    public function setUrlFromServer(array $server = null)
    {
        $this->valid = true;

        try {
            if ($server === null) {
                return $this->setUrl(Url::createFromServer($_SERVER));
            } else {
                return $this->setUrl(Url::createFromServer($server));
            }
        } catch (\InvalidArgumentException $e) {
            $this->valid = false;
            return $this;
        }
    }


    /**
     * An alias for setUrlFromServer()
     *
     * @param array The server variables used to create the URI object
     *
     * @return Monospice\SpicyUrlMatcher\UrlMatcher The current UrlMatcher
     * object used for chaining methods
     *
     * @throws \InvalidArgumentException If the URI cannot be parsed
     */
    public function server($server = null)
    {
        return $this->setUrlFromServer($server);
    }


    /**
     * Set the URI from an array of url components like the array returned
     * from PHP's parse_url() function.
     *
     * @param array The URI components array
     *
     * @return Monospice\SpicyUrlMatcher\UrlMatcher The current UrlMatcher
     * object used for chaining methods
     */
    public function setUrlFromComponents(array $components)
    {
        $this->valid = true;

        try {
            return $this->setUrl(Url::createFromComponents($components));
        } catch (\InvalidArgumentException $e) {
            $this->valid = false;
            return $this;
        }
    }


    /**
     * An alias for setUrlFromComponents()
     *
     * @param array The URI components array
     *
     * @return Monospice\SpicyUrlMatcher\UrlMatcher The current URI
     * object used for chaining methods
     *
     * @throws \InvalidArgumentException If the URI cannot be parsed
     */
    public function components(array $components)
    {
        return $this->setUrlFromComponents($components);
    }


    /**
     * Determine if the URI set is valid
     *
     * @return bool True if the URI is valid
     */
    public function isValid()
    {
        if (! $this->valid) {
            return false;
        }

        return filter_var((string) $this->url, FILTER_VALIDATE_URL)
            || filter_var((string) $this->url->toAscii(), FILTER_VALIDATE_URL);
    }


    /**
     * Get the current URI object.
     *
     * @return League\Uri\Url The current URI object
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * Get the string representation of the current URI.
     *
     * @return string The current URI string
     */
    public function getUrlString()
    {
        return (string) $this->url;
    }


    /**
     * Get the array of matched results from a regular expression comparison
     *
     * @return array The array of matched results
     *
     * @throws RuntimeException If the method is called before performing a
     * regular expression comparison with ::matches()
     */
    public function getResults()
    {
        if ($this->matcher === null) {
            throw new \RuntimeException(__CLASS__ . '::' . __METHOD__ .
                ' called before a regular expression comparison was performed');
        }

        return $this->matcher->getResults;
    }


    /**
     * Handle dynamic calls for the various matching combinations.
     *
     * @param string $method The accessed method name
     * @param array $arguments The array of dynamic arguments, usually
     * containing the string or pattern to match against
     *
     * @return bool True if the pattern matches the portion of the URI
     *
     * @throws \RuntimeException If there is no URI to match against
     * @throws \BadMethodCallException If no string or pattern is provided
     * @throws \BadMethodCallException If the dynamic method name does not
     * match a valid method
     * @throws \BadMethodCallException If the component name does not match
     * match a valid League\Uri\Url component
     */
    public function __call($methodCalled, $arguments)
    {
        // Determine how to compare the URI by parsing the dynamic methods
        // called. The dynamic method should be a camelCase word indicating
        // how the URI will be compared and which parts of the URI to compare.
        // For example: $matcher->domainIs(...) will check that the domain
        // matches the given string exactly.

        // If the League\Uri\Uri object isn't valid, the comparison just fails
        if ($this->valid === false) {
            return false;
        }

        $this->prepareForMatching($arguments);

        // Break the dynamic method into separate camel case words.
        //** $methodParts = static::getMethodParts($methodCalled);
        $method = MethodParser::parseFromCamelCase($methodCalled)
            ->mergePartsRangeIf([0 => 'user', 1 => 'Info']) // userInfo
            ->mergePartsRangeIf([1 => 'Starts', 2 => 'With']) // startsWith
            ->mergePartsRangeIf([1 => 'Ends', 2 => 'With']) // endsWith
            ->renamePartIf(0, 'subdomain', 'hostSubdomain') // alias subdomain
            ->renamePartIf(0, 'password', 'pass'); // alias password


        // If the entire URI should be compared (not just a component, so no
        // part name is passed as part of the dynamic method name), call the
        // appropriate method. For example, $matcher->has(...) will match
        // against the entire URI.
        //** if (count($methodParts) === 1) {
        if ($method->getNumParts() === 1) {
            $this->matcher = new BasicMatcher($this->url);
            return $method->call($this->matcher, $arguments);
            //** return $this->matcher->callMethod($methodParts[0], $arguments);
        }

        // If only part of the URI will be compared, the dynamic method will
        // start with the name of the Url component corresponding to a component
        // property on the League\Uri\Url object. If the dynamic method doesn't
        // match any valid components on the League\Uri\Url object, throw exception.
        //** list($componentName, $methodName) = $methodParts;

        // Get the appropriate Matcher for the current component
        $componentName = $method->getPart(0);
        $this->matcher = $this->getMatcher($componentName);

        // The next camel case word will determine how the Url component should
        // be compared. Call the method on the Matcher.
        return $method->call($this->matcher, $arguments);
        //** return $this->matcher->callMethod($methodName, $arguments);
    }


    /**
     * Cleanup and checks that should be performed before each match.
     *
     * @internal
     *
     * @param array $arguments The array of arguments passed to the dynamic
     * method
     *
     * @throws \RuntimeException If there is no URI to match against
     * @throws \BadMethodCallException If no string or pattern is provided
     */
    protected function prepareForMatching(array $dynamicArguments)
    {
        // Make sure there is a URI to match against
        if ($this->url === null) {
            throw new \RuntimeException(
                'The URI must be set before performing a comparison'
            );
        }

        // Make sure there is a pattern to match against
        if (count($dynamicArguments) === 0) {
            throw new \BadMethodCallException(
                'A comparison pattern or string is required but not provided'
            );
        }
    }


    /**
     * Determine which URI component to compare.
     *
     * @internal
     *
     * @param string $componentName The name of the component described by a
     * dynamic method call
     *
     * @return mixed The URI component object that will be compared
     *
     * @throws \BadMethodCallException If the component name does not match
     * match a valid League\Uri\Url component
     */
    protected function getComponent($componentName)
    {
        if (property_exists($this->url, $componentName)) {
            return $this->url->$componentName;
        } elseif (property_exists($this->url->userInfo, $componentName)) {
            return $this->url->userInfo->$componentName;
        } else {
            throw new \BadMethodCallException('The ' . $componentName .
                ' method does not exist on the Url object');
        }
    }


    /**
     * Determine which Matcher to use for matching the current component.
     *
     * @internal
     *
     * @param string $componentName The name of the component described by a
     * dynamic method call
     *
     * @return MatcherInterface The Matcher class to use for matching
     *
     * @throws \BadMethodCallException If the component name does not match
     * match a valid League\Uri\Url component
     */
    protected function getMatcher($componentName)
    {
        $component = $this->getComponent($componentName);

        switch ($componentName) {
            case 'host':
                return new HostMatcher($component);
            default:
                return new BasicMatcher($component);
        }
    }


    /**
     * Split the dynamic method call into parts. Camel cased words
     * are used as the delimiter.
     *
     * @internal
     *
     * @param string $methodName The dynamic method name to split
     *
     * @return array An array of the method name parts
     */
    protected static function getMethodParts($methodName)
    {
        $methodParts = preg_split('/(?=[A-Z])/', $methodName);

        static::mergeUserInfo($methodParts);
        static::mergeStartsWith($methodParts);
        static::mergeEndsWith($methodParts);
        static::aliasPassword($methodParts);

        return $methodParts;
    }


    /**
     * Combine the userInfo method name.
     *
     * @internal
     *
     * @param array $methodParts The parts of the dynamic method
     *
     * @return array The new array with the userInfo name parts combined
     */
    protected static function mergeUserInfo(array &$methodParts)
    {
        if ($methodParts[0] === 'user' && $methodParts[1] === 'Info') {
            array_splice($methodParts, 0, 2, ['userInfo']);
        }
    }


    /**
     * Combine the startsWith method name.
     *
     * @internal
     *
     * @param array $methodParts The parts of the dynamic method
     *
     * @return array The new array with the startsWith name parts combined
     */
    protected static function mergeStartsWith(array &$methodParts)
    {
    }


    /**
     * Combine the endsWith method name.
     *
     * @internal
     *
     * @param array $methodParts The parts of the dynamic method
     *
     * @return array The new array with the endsWith name parts combined
     */
    protected static function mergeEndsWith(array &$methodParts)
    {
    }


    /**
     * Alias "password" for "pass" when comparing the URI password component.
     *
     * @internal
     *
     * @param array $methodParts The parts of the dynamic method
     *
     * @return array The new array with the userInfo name parts combined
     */
    protected static function aliasPassword(&$methodParts)
    {
        if ($methodParts[0] === 'password') {
            $methodParts[0] = 'pass';
        }
    }
}
