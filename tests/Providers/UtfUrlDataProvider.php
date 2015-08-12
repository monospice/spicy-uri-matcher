<?php

namespace tests\Providers;

use League\Uri\Url;
use tests\Providers\AsciiUrlDataProvider;

class UtfUrlDataProvider extends AsciiUrlDataProvider {

    public $user = '例';
    public $pass = '例';
    public $domain = '例.com';
    public $directory1 = '例1';
    public $directory2 = '例2';
    public $fileName = '例';
    public $queryKey1 = '例key1';
    public $queryValue1 = '例value1';
    public $queryKey2 = '例key2';
    public $queryValue2 = '例value2';
    public $fragment = '例';

    public $asciiDomain;
    public $asciiUrl;
    public $asciiUrlObject;

    public function __construct()
    {
        parent::__construct();

        $this->asciiDomain = idn_to_ascii($this->domain);

        $this->asciiUrl = $this->buildUrl([
            'domain' => $this->asciiDomain,
        ]);

        $this->asciiUrlObject = Url::createFromString($this->asciiUrl);
    }
}

