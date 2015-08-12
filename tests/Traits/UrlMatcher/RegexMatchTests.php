<?php

namespace tests\Traits\UrlMatcher;

trait RegexMatchTests
{

    function it_compares_an_entire_url_for_a_regex_match()
    {
        $escapedUrl = str_replace('/', '\/', $this->ascii->url);
        $escapedUrl = str_replace('?', '\?', $escapedUrl);

        $this->setUrl($this->ascii->url);
        $this->matches('/' . $escapedUrl . '/')->shouldReturn(true);
        $this->matches('/' . $this->ascii->noMatch . '/')->shouldReturn(false);
    }

    function it_compares_an_entire_unicode_url_for_a_regex_match()
    {
        $escapedUrl = str_replace('/', '\/', $this->utf->url);
        $escapedUrl = str_replace('?', '\?', $escapedUrl);

        $escapedNoMatch = str_replace('/', '\/', $this->utf->noMatch);
        $escapedNoMatch = str_replace('?', '\?', $escapedNoMatch);

        $this->setUrl($this->utf->url);
        $this->matches('/' . $escapedUrl . '/')->shouldReturn(true);
        $this->matches('/' . $escapedNoMatch . '/')->shouldReturn(false);
    }

    function it_compares_a_url_scheme_for_a_regex_match()
    {
        $this->setUrl($this->ascii->url);
        $this->schemeMatches('/' . $this->ascii->scheme . '/')
            ->shouldReturn(true);
        $this->schemeMatches('/' . $this->ascii->noMatch . '/')
            ->shouldReturn(false);
    }

    function it_compares_a_url_userinfo_for_a_regex_match()
    {
        $this->setUrl($this->ascii->url);
        $this->userInfoMatches('/' . $this->ascii->userInfo . '/')
            ->shouldReturn(true);
        $this->userInfoMatches('/' . $this->ascii->noMatch . '/')
            ->shouldReturn(false);
    }

    function it_compares_a_url_user_for_a_regex_match()
    {
        $this->setUrl($this->ascii->url);
        $this->userMatches('/' . $this->ascii->user . '/')
            ->shouldReturn(true);
        $this->userMatches('/' . $this->ascii->noMatch . '/')
            ->shouldReturn(false);
    }

    function it_compares_a_url_password_for_a_regex_match()
    {
        $this->setUrl($this->ascii->url);
        $this->passMatches('/' . $this->ascii->pass . '/')
            ->shouldReturn(true);
        $this->passMatches('/' . $this->ascii->noMatch . '/')
            ->shouldReturn(false);
        $this->passwordMatches('/' . $this->ascii->pass . '/')
            ->shouldReturn(true);
        $this->passwordMatches('/' . $this->ascii->noMatch . '/')
            ->shouldReturn(false);
    }

    function it_compares_a_url_host_for_a_regex_match()
    {
        $this->setUrl($this->ascii->url);
        $this->hostMatches('/' . $this->ascii->host . '/')
            ->shouldReturn(true);
        $this->hostMatches('/' . $this->ascii->noMatch . '/')
            ->shouldReturn(false);
    }

    function it_compares_a_url_port_for_a_regex_match()
    {
        $this->setUrl($this->ascii->url);
        $this->portMatches('/' . $this->ascii->port . '/')
            ->shouldReturn(true);
        $this->portMatches('/' . $this->ascii->noMatch . '/')
            ->shouldReturn(false);
    }

    function it_compares_a_url_path_for_a_regex_match()
    {
        $escapedPath = str_replace('/', '\/', $this->ascii->path);

        $this->setUrl($this->ascii->url);
        $this->pathMatches('/' . $escapedPath . '/')
            ->shouldReturn(true);
        $this->pathMatches('/' . $this->ascii->noMatch . '/')
            ->shouldReturn(false);
    }

    function it_compares_a_url_query_for_a_regex_match()
    {
        $this->setUrl($this->ascii->url);
        $this->queryMatches('/' . $this->ascii->query . '/')
            ->shouldReturn(true);
        $this->queryMatches('/' . $this->ascii->noMatch . '/')
            ->shouldReturn(false);
    }

    function it_compares_a_url_fragment_for_a_regex_match()
    {
        $this->setUrl($this->ascii->url);
        $this->fragmentMatches('/' . $this->ascii->fragment . '/')
            ->shouldReturn(true);
        $this->fragmentMatches('/' . $this->ascii->noMatch . '/')
            ->shouldReturn(false);
    }

}

