<?php

namespace tests\Traits\UrlMatcher;

trait PartialMatchTests
{

    function it_compares_an_entire_url_for_a_partial_match()
    {
        $this->setUrl($this->ascii->url);
        $this->has($this->ascii->url)->shouldReturn(true);
        $this->has($this->ascii->noMatch)->shouldReturn(false);
        $this->contains($this->ascii->url)->shouldReturn(true);
        $this->contains($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_an_entire_unicode_url_for_a_partial_match()
    {
        $this->setUrl($this->utf->url);
        $this->has($this->utf->url)->shouldReturn(true);
        $this->has($this->utf->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_scheme_for_a_partial_match()
    {
        $this->setUrl($this->ascii->url);
        $this->schemeHas($this->ascii->scheme)->shouldReturn(true);
        $this->schemeHas($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_userinfo_for_a_partial_match()
    {
        $this->setUrl($this->ascii->url);
        $this->userInfoHas($this->ascii->userInfo)->shouldReturn(true);
        $this->userInfoHas($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_user_for_a_partial_match()
    {
        $this->setUrl($this->ascii->url);
        $this->userHas($this->ascii->user)->shouldReturn(true);
        $this->userHas($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_password_for_a_partial_match()
    {
        $this->setUrl($this->ascii->url);
        $this->passHas($this->ascii->pass)->shouldReturn(true);
        $this->passHas($this->ascii->noMatch)->shouldReturn(false);
        $this->passwordHas($this->ascii->pass)->shouldReturn(true);
        $this->passwordHas($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_host_for_a_partial_match()
    {
        $this->setUrl($this->ascii->url);
        $this->hostHas($this->ascii->host)->shouldReturn(true);
        $this->hostHas($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_port_for_a_partial_match()
    {
        $this->setUrl($this->ascii->url);
        $this->portHas($this->ascii->port)->shouldReturn(true);
        $this->portHas($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_path_for_a_partial_match()
    {
        $this->setUrl($this->ascii->url);
        $this->pathHas($this->ascii->path)->shouldReturn(true);
        $this->pathHas($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_query_for_a_partial_match()
    {
        $this->setUrl($this->ascii->url);
        $this->queryHas($this->ascii->query)->shouldReturn(true);
        $this->queryHas($this->ascii->noMatch)->shouldReturn(false);
    }

    function it_compares_a_url_fragment_for_a_partial_match()
    {
        $this->setUrl($this->ascii->url);
        $this->fragmentHas($this->ascii->fragment)->shouldReturn(true);
        $this->fragmentHas($this->ascii->noMatch)->shouldReturn(false);
    }

}

