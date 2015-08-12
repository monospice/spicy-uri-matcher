Spicy URI Matcher
=======

[![Build Status](https://travis-ci.org/monospice/spicy-identifier-tools.svg?branch=master)](https://travis-ci.org/monospice/spicy-identifier-tools)

**Compare URLs and URIs the easy way!**

Spicy URI Matcher provides a simple way to compare URIs, URLs, and their
components. It includes a built-in adapter for the excellent
[League\Url](https://github.com/thephpleague/url) library.

**Warning:** This package is under heavy development and should be considered
**incomplete** and **unstable**.

Simple Example
------

```php
$exampleUrl = new UriMatcher('http://www.monospice.com/');
if ($exampleUrl->domainHas('monospice.com')) {
    // What a great looking URL this is!
}
```

Requirements
-------

- **PHP >= 5.5.0** or **HHVM >= 3.6**
- PHP's `mbstring` extension
- PHP's `intl` extension
- PHP's `filter` extension
- A UTF-8 compatible environment language setting to compare International
Domain Names

Installation
-------

```bash
$ composer require monospice/spicy-uri-matcher
```

And if you're autoloading classes, of course:

```php
use Monospice\SpicyUriMatcher\UriMatcher;
```

Basic Usage
-------

```php
// Let's use this URL for the following examples
$url = 'http://www.example.com/blog/post-title/';

// You can set the URI in the constructor
$matcher = new UriMatcher($url);

// Or instantiate first to use the following
$matcher = new UriMatcher();

// Compare a string or League\Uri\Uri object
$matcher->setUri($url);
$matcher->uri($url); // alias for above

// Compare $_SERVER environment variable
$matcher->setUriFromServer();
$matcher->server(); // alias for above

// Compare components array, such as one returned by PHP's parse_url function
$componentsArray = parse_url($url);
$matcher->setUriFromComponents($componentsArray);
$matcher->components($componentsArray); // alias for above

// With method chaining
$matcher->url($url)->domainStartsWith('www.');
$matcher->server()->portIs(80);
$matcher->components($componentsArray)->pathMatches('/^\/blog\/(.*)\//');
```

Comparison Examples
-------

```php
// Let's use this URI Matcher for the following examples
$checkUrl = new UriMatcher('http://www.example.com/blog/post-title/?admin=yes');

// Compare the whole URI...
if ($checkUrl->has('example')) {...}
// ...or just a component by prepending the component name
if ($checkUrl->domainHas('example')) {...}

// Look for an exact match
if ($checkUrl->domainIs('www.example.com')) {...}
if ($checkUrl->domainEquals('www.example.com')) {...} // alias for above

// Look for a partial match
if ($checkUrl->domainHas('example')) {...}
if ($checkUrl->domainContains('example')) {...} // alias for above

// Look for a match at the beginning
if ($checkUrl->domainStartsWith('www.')) {...}

// Look for a match at the end
if ($checkUrl->domainEndsWith('.com')) {...}

// Look for a match using regular expressions
if ($checkUrl->schemeMatches('/(http|https)/')) {...}

// Get the results of a regular expression match
$matches = $checkUrl->getResults();
echo $matches[0]; // 'http'

// Compare parts of a component
if ($checkUrl->domainLabel(0)->is('www')) {...}
if ($checkUrl->queryKey('admin')->is('yes')) {...}
```

International Support
-------

Spicy Uri Matcher can flexibly compare IDN and Unicode URIs if the PHP
environment is configured appropriately.

```php
// Let's use this URI Matcher for the following examples
$checkUrl = new UriMatcher('http://www.éxamplé.com/');

// Determine if the URI contains an International Domain Name
$checkUrl->domainIsIdn(); // true

// The URI Matcher recognizes the equivalent ASCII representation of a
// Unicode hostname
$checkUrl->domainIs('www.xn--xampl-9raf.com'); // true

// And vice versa
$checkUrl->setUrl('http//www.xn--xampl-9raf.com/');
$checkUrl->domainIs('www.éxamplé.com'); // true
```

Supported Components and Comparisons
-------

Spicy URI Matcher can compare each of the components in the League\Uri package:
uri, scheme, userInfo, user, pass (alias: password), host (alias: domain),
port, path, query, and fragment.

It supports the following comparisons: is (alias: equals), has (alias:
contains), startsWith, endsWith, and matches (performs regular expression
comparisons).

Each component can be combined with a comparison as a method call to the
UriMatcher object. When choosing a method to compare an entire URI, the uri
component should not be explicitly included in the method name:

```php
// Compare an entire URI
$matcher->startsWith('http://www');
```

Example combinations:

```php
// Compare part of a URI
$matcher->passwordHas('secret');
$matcher->userInfoIs('user:secret');
$matcher->hostStartsWith('127.');
```

Additionally, this package supports some related functionality provided by the
League\Uri classes, such as League\Uri\Host::isIdn():

```php
$matcher->hostIsIdn();
```

Testing
-------

The Spicy URI Matcher package uses PHPUnit to test input variations and
PHPSpec for object behavior.

```bash
$ phpunit
$ vendor/bin/phpspec run
```

Security
-------

If you discover any security related issues, please email cy@rossignols.me instead of using the issue tracker.

License
-------

The MIT License (MIT). Please see [LICENSE File](LICENSE) for more information.
