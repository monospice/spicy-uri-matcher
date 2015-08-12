<?php

namespace tests\Providers;

use League\Uri\Url;

class Ipv6UrlDataProvider extends AsciiUrlDataProvider {

    public $subdomain = '';
    public $domain = '[::1]';
    public $domainWithZone = 'Fe80::4432:34d6:e6e6:b122%eth0-1';

    public $urlWithZone;
    public $urlObjectWithZone;

    public function __construct()
    {
        parent::__construct();

        $this->urlWithZone = $this->buildUrl([
            'domain' => $this->domainWithZone
        ]);

        $this->urlObjectWithZone = Url::createFromString($this->urlWithZone);
    }

}

