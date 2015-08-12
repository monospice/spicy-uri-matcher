<?php

namespace tests\Traits\UrlMatcher;

trait ExactMatchTests
{

    function it_compares_an_entire_url_for_an_exact_match()
    {
        $this->setUrl($this->ascii->url);
        $this->is($this->ascii->url)->shouldReturn(true);
        $this->is($this->ascii->noMatch)->shouldReturn(false);
        $this->equals($this->ascii->url)->shouldReturn(true);
        $this->equals($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_an_entire_unicode_url_for_an_exact_match()
    {
        $this->setUrl($this->utf->url);
        $this->is($this->utf->url)->shouldReturn(true);
        $this->is($this->utf->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_scheme_for_an_exact_match()
    {
        $this->setUrl($this->ascii->url);
        $this->schemeIs($this->ascii->scheme)->shouldReturn(true);
        $this->schemeIs($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_userinfo_for_an_exact_match()
    {
        $this->setUrl($this->ascii->url);
        $this->userInfoIs($this->ascii->userInfo)->shouldReturn(true);
        $this->userInfoIs($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_user_for_an_exact_match()
    {
        $this->setUrl($this->ascii->url);
        $this->userIs($this->ascii->user)->shouldReturn(true);
        $this->userIs($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_password_for_an_exact_match()
    {
        $this->setUrl($this->ascii->url);
        $this->passIs($this->ascii->pass)->shouldReturn(true);
        $this->passIs($this->ascii->noMatch)->shouldReturn(false);
        $this->passwordIs($this->ascii->pass)->shouldReturn(true);
        $this->passwordIs($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_host_for_an_exact_match()
    {
        $this->setUrl($this->ascii->url);
        $this->hostIs($this->ascii->host)->shouldReturn(true);
        $this->hostIs($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_port_for_an_exact_match()
    {
        $this->setUrl($this->ascii->url);
        $this->portIs($this->ascii->port)->shouldReturn(true);
        $this->portIs($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_path_for_an_exact_match()
    {
        $this->setUrl($this->ascii->url);
        $this->pathIs($this->ascii->path)->shouldReturn(true);
        $this->pathIs($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_query_for_an_exact_match()
    {
        $this->setUrl($this->ascii->url);
        $this->queryIs($this->ascii->query)->shouldReturn(true);
        $this->queryIs($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_fragment_for_an_exact_match()
    {
        $this->setUrl($this->ascii->url);
        $this->fragmentIs($this->ascii->fragment)->shouldReturn(true);
        $this->fragmentIs($this->ascii->noMatch)->shouldReturn(false);
    }

}

