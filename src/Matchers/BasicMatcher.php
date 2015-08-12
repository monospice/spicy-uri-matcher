<?php

namespace Monospice\SpicyUrlMatcher\Matchers;

use League\Uri\Services\Formatter;

use Monospice\SpicyUrlMatcher\Interfaces;

/**
 * Compares URIs and URI Components against strings
 *
 * @author Cy Rossignol <cy.rossignol@yahoo.com>
 */
class BasicMatcher implements Interfaces\Matcher
{

    /**
     * mixed The Uri Component object that will be compared
     *
     * @internal
     */
    protected $subject;

    /**
     * string A string of the subject that will be compared
     *
     * @internal
     */
    protected $subjectString;

    /**
     * League\Uri\Services\Formatter Sets internal URI formatting
     *
     * @internal
     */
    protected $formatter;

    /**
     * array An array of matched results from a regular expression comparison
     *
     * @internal
     */
    protected $results;

    /**
     * Interfaces\Matcher Reference to the recursive matcher. Used for getting
     * results of a recursive regex match
     *
     * @internal
     */
    protected $subMatcher;


    /**
     * Construct a new BasicMatcher object
     *
     * @api
     *
     * @param mixed $subject The League\Uri\Url or Url Component object to
     * compare
     */
    public function __construct($subject = null)
    {
        $this->formatter = new Formatter();
        $this->formatter->setHostEncoding(Formatter::HOST_AS_UNICODE);

        if ($subject !== null) {
            $this->setSubject($subject);
        }
    }


    // Inherit Doc from Interfaces\Matcher
    public function setSubject($subject)
    {
        $this->subject = $subject;
        $this->subjectString = $this->getFormattedString($subject);

        return $this;
    }


    // Inherit Doc from Interfaces\Matcher
    public function getSubjectString()
    {
        return $this->subjectString;
    }


    // Inherit Doc from Interfaces\Matcher
    public function getResult($key = null)
    {
        if ($this->subMatcher !== null) {
            return $this->subMatcher->getResult($key);
        }

        if ($this->results === null) {
            throw new \RuntimeException(__CLASS__ . '::' . __METHOD__ .
                ' called before a regular expression comparison was performed');
        }

        if ($key !== null) {
            if(isset($this->results[$key])) {
                return $this->results[$key];
            }

            throw new \OutOfBoundsException('The regex results array does ' .
                'not contain the given key');
        }

        return $this->results;
    }


    // Inherit Doc from Interfaces\Matcher
    public function hasResult($key = null)
    {
        if ($this->subMatcher !== null) {
            return $this->subMatcher->hasResult($key);
        }

        if ($this->results === null || count($this->results) === 0) {
            return false;
        }

        if ($key !== null) {
            return isset($this->results[$key]);
        }

        return true;
    }


    // Inherit Doc from Interfaces\Matcher
    public function is($string)
    {
        return $this->subjectString === (string) $string;
    }


    // Inherit Doc from Interfaces\Matcher
    public function equals($string)
    {
        return $this->is($string);
    }


    // Inherit Doc from Interfaces\Matcher
    public function has($string)
    {
        $string = (string) $string;

        $length = mb_strlen($string);
        if ($length === 0) {
            return $this->subjectString === '';
        }

        return mb_strpos($this->subjectString, $string) !== false;
    }


    // Inherit Doc from Interfaces\Matcher
    public function contains($string)
    {
        return $this->has($string);
    }


    // Inherit Doc from Interfaces\Matcher
    public function startsWith($string)
    {
        $string = (string) $string;

        $length = mb_strlen($string);
        if ($length === 0) {
            return $this->subjectString === '';
        }

        return mb_substr($this->subjectString, 0, $length) === $string;
    }


    // Inherit Doc from Interfaces\Matcher
    public function endsWith($string)
    {
        $string = (string) $string;

        $length = mb_strlen($string);
        if ($length === 0) {
            return $this->subjectString === '';
        }

        return mb_substr($this->subjectString, -$length) === $string;
    }


    // Inherit Doc from Interfaces\Matcher
    public function matches($pattern, $flags = 0, $offset = 0)
    {
        // Clear any refernce to a sub matcher so the correct regex results
        // can be accessed
        $this->subMatcher = null;

        // preg_match returns:
        //      1: matches found
        //      2: no matches found
        //      false: an error occured
        $result = preg_match($pattern, $this->subjectString, $this->results,
            $flags, $offset);

        return $result === 1;
    }


    // Inherit Doc from Interfaces\Matcher
    public function isEmpty()
    {
        return $this->subjectString === '';
    }


    /**
     * Formats the internal URL or component for comparison.
     *
     * @internal
     *
     * @param mixed $urlComponent The URL or component to format
     *
     * @return string The formatted string
     */
    protected function getFormattedString($urlComponent)
    {
        return urldecode($urlComponent);
    }


    // Inherit Doc from Interfaces\Matcher
    public function callMethod($methodName, array $arguments)
    {
        if (method_exists($this, $methodName)) {
            return call_user_func_array([$this, $methodName], $arguments);
        }

        if (method_exists($this->subject, $methodName)) {
            return call_user_func_array([$this->subject, $methodName],
                $arguments);
        }

        throw new \BadMethodCallException('The ' . $methodName .
            ' method does not exist on the matcher or Uri Component Object');
    }


    // Inherit Doc from Interfaces\Matcher
    public function __call($methodCalled, array $arguments)
    {
        return $this->callMethod($methodCalled, $arguments);
    }
}

