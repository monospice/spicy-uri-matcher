<?php

namespace tests\Spec\Monospice\SpicyUrlMatcher\Matchers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use League\Uri\Query;

class QueryMatcherSpec extends ObjectBehavior
{
    use \tests\Traits\UriDataProvider;
    use \tests\Traits\ComponentTests;

    function let()
    {
        $this->useUriDataProviders();

        $this->asciiTestSubject = $this->ascii->urlObject->query;
        $this->asciiExpectedResult = $this->ascii->query;
        $this->asciiPartial = $this->ascii->queryKey1;
        $this->asciiStart = $this->ascii->queryKey1;
        $this->asciiEnd = $this->ascii->queryValue2;
        $this->utfTestSubject = $this->utf->urlObject->query;
        $this->utfExpectedResult = $this->utf->query;
        $this->utfPartial = $this->utf->queryKey1;
        $this->utfStart = $this->utf->queryKey1;
        $this->utfEnd = $this->utf->queryValue2;
        $this->emptyTestSubject = new Query();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Monospice\SpicyUrlMatcher\Interfaces' .
            '\MatchesKeys');
        $this->shouldHaveType('Monospice\SpicyUrlMatcher\Matchers\QueryMatcher');
    }

    function it_compares_an_entire_query_with_keys_in_any_order()
    {
        $reverseQuery = $this->ascii->queryPair2 . '&' .
            $this->ascii->queryPair1;

        $this->setSubject($this->asciiTestSubject);
        $this->is($this->ascii->query)->shouldReturn(true);
        $this->is($reverseQuery)->shouldReturn(true);
    }

    function it_compares_a_partial_query_with_keys_in_any_order()
    {
        $reverseQuery = $this->ascii->queryPair2 . '&' .
            $this->ascii->queryPair1;

        $this->setSubject($this->asciiTestSubject);
        $this->has($this->ascii->query)->shouldReturn(true);
        $this->has($reverseQuery)->shouldReturn(true);
    }

    function it_compares_a_subject_against_an_entire_query_array()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->is([
            $this->ascii->queryKey1 => $this->ascii->queryValue1,
            $this->ascii->queryKey2 => $this->ascii->queryValue2,
        ])->shouldReturn(true);
        $this->is(['no query match'])->shouldReturn(false);
    }

    function it_compares_a_subject_against_a_partial_query_array()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->has([
            $this->ascii->queryKey2 => $this->ascii->queryValue2,
        ])->shouldReturn(true);
        $this->has(['no query match'])->shouldReturn(false);
    }

    function it_compares_a_subject_against_an_entire_query_object()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->is($this->ascii->urlObject->query)->shouldReturn(true);
        $this->is(new Query())->shouldReturn(false);
    }

    function it_compares_a_subject_against_a_partial_query_object()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->has(new Query($this->ascii->queryPair2))->shouldReturn(true);
        $this->has(new Query())->shouldReturn(false);
    }

    function it_flexibly_compares_a_query_string_with_a_leading_question_mark()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->is('?' . $this->ascii->query)->shouldReturn(true);
    }

    function it_provides_access_to_query_keys_for_comparison()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->key($this->ascii->queryKey1)->shouldHaveType(
            'Monospice\SpicyUrlMatcher\Matchers\BasicMatcher'
        );
        $this->key($this->ascii->queryKey1)->is($this->ascii->queryValue1)
            ->shouldReturn(true);
        $this->key('not a key')->is($this->ascii->queryValue1)->shouldReturn(false);
    }

    function it_checks_that_a_query_contains_a_given_key()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->hasKey($this->ascii->queryKey1)->shouldReturn(true);
        $this->hasKey('not a key')->shouldReturn(false);
    }

    function it_returns_the_results_of_a_regex_match_on_a_given_key()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->key($this->ascii->queryKey1)
            ->matches('/(' . $this->ascii->queryValue1 . ')/')
            ->shouldReturn(true);
        $this->getResult()->shouldReturn([
            $this->ascii->queryValue1, // the entire matched result
            $this->ascii->queryValue1 // the result of the first matched group
        ]);
    }

    function it_checks_if_results_exist_from_a_regex_match_on_a_given_key()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->key($this->ascii->queryKey1)
            ->matches('/(' . $this->ascii->queryValue1 . ')/')
            ->shouldReturn(true);
        $this->hasResult()->shouldReturn(true);
    }

}

