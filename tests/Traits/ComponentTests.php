<?php

namespace tests\Traits;

trait ComponentTests
{
    function it_loads_an_object_for_comparison_using_setter()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->getSubjectString()->shouldReturn($this->asciiExpectedResult);
    }

    function it_loads_a_string_for_comparison_using_setter()
    {
        $this->setSubject((string) $this->asciiTestSubject);
        $this->getSubjectString()->shouldReturn($this->asciiExpectedResult);
    }

    function it_loads_an_object_for_comparison_using_constructor()
    {
        $this->beConstructedWith($this->asciiTestSubject);
        $this->getSubjectString()->shouldReturn($this->asciiExpectedResult);
    }

    function it_returns_the_current_object_for_chaining_after_setting_subject()
    {
        $this->setSubject($this->asciiTestSubject)
            ->shouldHaveType('Monospice\SpicyUrlMatcher\Interfaces\Matcher');
    }

    function it_provides_an_interface_for_calling_methods_dynamically()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->callMethod('is', [$this->asciiExpectedResult])->shouldReturn(true);
    }

    function it_compares_a_subject_for_an_exact_match()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->is($this->asciiExpectedResult)->shouldReturn(true);
        $this->equals($this->asciiExpectedResult)->shouldReturn(true);
        $this->is($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_unicode_subject_for_an_exact_match()
    {
        $this->setSubject($this->utfTestSubject);
        $this->is($this->utfExpectedResult)->shouldReturn(true);
        $this->is($this->utf->noMatch)->shouldReturn(false);
    }

    function it_compares_a_subject_for_a_partial_match()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->has($this->asciiPartial)->shouldReturn(true);
        $this->contains($this->asciiPartial)->shouldReturn(true);
        $this->has($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_unicode_subject_for_a_partial_match()
    {
        $this->setSubject($this->utfTestSubject);
        $this->has($this->utfPartial)->shouldReturn(true);
        $this->has($this->utf->noMatch)->shouldReturn(false);
    }

    function it_compares_a_subject_for_a_regex_match()
    {
        $pathEscaped = str_replace('/', '\/', $this->asciiPartial);

        $this->setSubject($this->asciiTestSubject);
        $this->matches('/' . $pathEscaped . '/')->shouldReturn(true);
        $this->matches('/' . $this->ascii->noMatch . '/')->shouldReturn(false);
    }

    function it_compares_a_unicode_subject_for_a_regex_match()
    {
        $pathEscaped = str_replace('/', '\/', $this->utfPartial);

        $this->setSubject($this->utfTestSubject);
        $this->matches('/' . $pathEscaped . '/')->shouldReturn(true);
        $this->matches('/' . $this->utf->noMatch . '/')->shouldReturn(false);
    }

    function it_returns_the_results_of_a_regex_match()
    {
        $pathEscaped = str_replace('/', '\/', $this->asciiPartial);

        $this->setSubject($this->asciiTestSubject);
        $this->matches('/(' . $pathEscaped . ')/')->shouldReturn(true);
        $this->getResult()->shouldReturn([
            $this->asciiPartial, // the entire matched result
            $this->asciiPartial // the first matched group
        ]);
        $this->matches('/(' . $this->ascii->noMatch . ')/')
            ->shouldReturn(false);
        $this->getResult()->shouldReturn([]);
    }

    function it_returns_a_result_of_a_given_key_of_a_regex_match()
    {
        $pathEscaped = str_replace('/', '\/', $this->asciiPartial);

        $this->setSubject($this->asciiTestSubject);
        $this->matches('/(' . $pathEscaped . ')/')->shouldReturn(true);
        $this->getResult(0)->shouldReturn($this->asciiPartial);
    }

    function it_checks_if_results_exist_from_a_regex_match()
    {
        $pathEscaped = str_replace('/', '\/', $this->asciiPartial);

        $this->setSubject($this->asciiTestSubject);
        $this->matches('/(' . $pathEscaped . ')/')->shouldReturn(true);
        $this->hasResult()->shouldReturn(true);
        $this->matches('/(' . $this->ascii->noMatch . ')/')
            ->shouldReturn(false);
        $this->hasResult()->shouldReturn(false);
    }

    function it_checks_if_results_exist_for_a_given_key_from_a_regex_match()
    {
        $pathEscaped = str_replace('/', '\/', $this->asciiPartial);

        $this->setSubject($this->asciiTestSubject);
        $this->matches('/(' . $pathEscaped . ')/')->shouldReturn(true);
        $this->hasResult(0)->shouldReturn(true);
        $this->hasResult(999)->shouldReturn(false);
    }

    function it_compares_a_subject_for_a_match_at_the_beginning()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->startsWith($this->asciiStart)->shouldReturn(true);
        $this->startsWith($this->asciiEnd)->shouldReturn(false);
    }

    function it_compares_a_unicode_subject_for_a_match_at_the_beginning()
    {
        $this->setSubject($this->utfTestSubject);
        $this->startsWith($this->utfStart)->shouldReturn(true);
        $this->startsWith($this->utfEnd)->shouldReturn(false);
    }

    function it_compares_a_subject_for_a_match_at_the_end()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->endsWith($this->asciiEnd)->shouldReturn(true);
        $this->endsWith($this->asciiStart)->shouldReturn(false);
    }

    function it_compares_a_unicode_subject_for_a_match_at_the_end()
    {
        $this->setSubject($this->utfTestSubject);
        $this->endsWith($this->utfEnd)->shouldReturn(true);
        $this->endsWith($this->utfStart)->shouldReturn(false);
    }

    function it_handles_comparisons_with_empty_components()
    {
        $pathEscaped = str_replace('/', '\/', $this->asciiPartial);

        $this->setSubject($this->emptyTestSubject);
        $this->is($this->asciiExpectedResult)->shouldReturn(false);
        $this->has($this->asciiPartial)->shouldReturn(false);
        $this->matches('/' . $pathEscaped . '/')->shouldReturn(false);
        $this->startsWith($this->asciiStart)->shouldReturn(false);
        $this->endsWith($this->asciiEnd)->shouldReturn(false);
    }

    function it_handles_unicode_comparisons_with_empty_components()
    {
        $pathEscaped = str_replace('/', '\/', $this->utfPartial);

        $this->setSubject($this->emptyTestSubject);
        $this->is($this->utfExpectedResult)->shouldReturn(false);
        $this->has($this->utfPartial)->shouldReturn(false);
        $this->matches('/' . $pathEscaped . '/')->shouldReturn(false);
        $this->startsWith($this->utfStart)->shouldReturn(false);
        $this->endsWith($this->utfEnd)->shouldReturn(false);
    }

    function it_handles_comparisons_with_empty_patterns()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->is('')->shouldReturn(false);
        $this->has('')->shouldReturn(false);
        $this->matches('//')->shouldReturn(true);
        $this->startsWith('')->shouldReturn(false);
        $this->endsWith('')->shouldReturn(false);
    }

    function it_asserts_that_a_subject_is_empty()
    {
        $this->setSubject($this->emptyTestSubject);
        $this->isEmpty()->shouldReturn(true);
    }

    function it_handles_unicode_comparisons_with_empty_patterns()
    {
        $this->setSubject($this->utfTestSubject);
        $this->is('')->shouldReturn(false);
        $this->has('')->shouldReturn(false);
        $this->matches('//')->shouldReturn(true);
        $this->startsWith('')->shouldReturn(false);
        $this->endsWith('')->shouldReturn(false);
    }

    function it_throws_an_exception_when_attempting_an_invalid_comparison()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->shouldThrow('\BadMethodCallException')
            ->during('callMethod', ['hasss', [$this->asciiExpectedResult]]);
    }

    function it_throws_an_exception_when_getting_regex_result_before_compare()
    {
        $this->setSubject($this->asciiTestSubject);
        $this->shouldThrow('\RuntimeException')->during('getResult');
    }

    function it_throws_an_exception_when_getting_nonexistant_regex_result_key()
    {
        $pathEscaped = str_replace('/', '\/', $this->asciiPartial);

        $this->setSubject($this->asciiTestSubject);
        $this->matches('/' . $pathEscaped . '/')->shouldReturn(true);
        $this->shouldThrow('\OutOfBoundsException')->during('getResult', [99]);
    }

}

