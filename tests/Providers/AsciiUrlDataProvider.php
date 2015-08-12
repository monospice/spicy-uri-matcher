<?php

namespace tests\Providers;

use League\Uri;
use League\Uri\Url;

class AsciiUrlDataProvider {

    public $scheme = 'http';
    public $user = 'testUser';
    public $pass = 'testPassword';
    public $subdomain = 'www';
    public $domain = 'example.com';
    public $port = 81;
    public $directory1 = 'dir1';
    public $directory2 = 'dir2';
    public $fileName = 'index';
    public $fileExtension = 'html';
    public $queryKey1 = 'key1';
    public $queryValue1 = 'value1';
    public $queryKey2 = 'key2';
    public $queryValue2 = 'value2';
    public $fragment = 'testfragment';

    public $userInfo;
    public $host;
    public $fqdn;
    public $authority;
    public $basename;
    public $path;
    public $queryPair1;
    public $queryPair2;
    public $query;

    public $url;
    public $fqdnUrl;

    public $urlObject;
    public $partialUrlObject;
    public $fqdnUrlObject;
    public $emptyUrlObject;

    public $components;

    public $serverUrl = 'https://127.0.0.1:23';
    public $serverArray = [
        'PHP_SELF' => '',
        'REQUEST_URI' => '',
        'SERVER_ADDR' => '127.0.0.1',
        'HTTPS' => 'on',
        'SERVER_PORT' => 23,
    ];
    public $invalidServerArray = [
        'PHP_SELF' => '',
        'REQUEST_URI' => '',
        'SERVER_ADDR' => '',
        'HTTPS' => 'on',
        'SERVER_PORT' => 23,
    ];

    public $noMatch = 'not a match';

    public function __construct() {
        $this->initializeUrlStrings();
        $this->initializeUrlObjects();
        $this->initializeUrlComponents();
    }

    protected function initializeUrlStrings()
    {
        $this->userInfo = $this->buildUserInfo();
        $this->host = $this->buildHost();
        $this->fqdn = $this->buildFqdn();
        $this->authority = $this->buildAuthority();
        $this->basename = $this->buildBasename();
        $this->path = $this->buildPath();
        $this->queryPair1 = $this->buildQueryPair(1);
        $this->queryPair2 = $this->buildQueryPair(2);
        $this->query = $this->buildQuery();

        $this->url = $this->buildUrl();
        $this->fqdnUrl = $this->buildUrl(['domain' => $this->fqdn]);
    }

    protected function initializeUrlObjects()
    {
        $this->urlObject = Url::createFromString($this->url);
        $this->partialUrlObject = Url::createFromString(
            $this->buildPartialUrl());
        // The League\Uri package dosen't support FQDN in the URI constructor
        //$this->fqdnUrlObject = Url::createFromString($this->fqdnUrl);

        $this->emptyUrlObject = new Url(
            new Uri\Scheme(),
            new Uri\UserInfo(),
            new Uri\Host(),
            new Uri\Port(),
            new Uri\Path(),
            new Uri\Query(),
            new Uri\Fragment(),
            null // no scheme registry
        );
    }

    protected function initializeUrlComponents()
    {
        $this->components = parse_url($this->url);
    }

    protected function buildUserInfo(array $replacements = null)
    {
        $components = $this->replaceDefaultComponents($replacements);

        return $components['user'] . ':' . $components['pass'];
    }

    protected function buildHost(array $replacements = null)
    {
        $components = $this->replaceDefaultComponents($replacements);

        $subdomain = '';
        if (strlen($components['subdomain'])) {
            $subdomain .= $components['subdomain'] . '.';
        }

        return $subdomain . $components['domain'];
    }

    protected function buildFqdn(array $replacements = null)
    {
        $components = $this->replaceDefaultComponents($replacements);

        return $this->buildHost($replacements) . '.';
    }

    protected function buildAuthority(array $replacements = null)
    {
        $components = $this->replaceDefaultComponents($replacements);

        return $this->buildUserInfo($replacements) . '@' .
            $this->buildHost($replacements) .
            ':' . $components['port'];
    }

    protected function buildBasename(array $replacements = null)
    {
        $components = $this->replaceDefaultComponents($replacements);

        return $components['fileName'] . '.' . $components['fileExtension'];
    }

    protected function buildPath(array $replacements = null)
    {
        $components = $this->replaceDefaultComponents($replacements);

        return '/' . $components['directory1'] . '/' .
            $components['directory2'] . '/' .
            $this->buildBasename($replacements);
    }

    protected function buildQueryPair($pairId, array $replacements = null)
    {
        $components = $this->replaceDefaultComponents($replacements);

        return $components['queryKey' . $pairId] . '=' .
            $components['queryValue' . $pairId];
    }

    protected function buildQuery(array $replacements = null)
    {
        $components = $this->replaceDefaultComponents($replacements);

        return $components['queryPair1'] . '&' . $components['queryPair2'];
    }

    protected function buildUrl(array $replacements = null)
    {
        $components = $this->replaceDefaultComponents($replacements);

        return $components['scheme'] . '://' .
            $this->buildAuthority($replacements) .
            $this->buildPath($replacements) .
            '?' . $this->buildQuery($replacements) .
            '#' . $components['fragment'];
    }


    protected function buildPartialUrl(array $replacements = null)
    {
        $components = $this->replaceDefaultComponents($replacements);

        return $this->scheme . '://' . $this->buildAuthority();
    }

    protected function replaceDefaultComponents(array $replacements = null)
    {
        $components = get_object_vars($this);
        if ($replacements !== null) {
            $components = array_replace($components,
                $replacements);
        }

        return $components;
    }

}

