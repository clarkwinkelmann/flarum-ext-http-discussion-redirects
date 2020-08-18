# HTTP Discussion Redirects

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/clarkwinkelmann/flarum-ext-http-discussion-redirects.svg)](https://packagist.org/packages/clarkwinkelmann/flarum-ext-http-discussion-redirects) [![Total Downloads](https://img.shields.io/packagist/dt/clarkwinkelmann/flarum-ext-http-discussion-redirects.svg)](https://packagist.org/packages/clarkwinkelmann/flarum-ext-http-discussion-redirects) [![Donate](https://img.shields.io/badge/paypal-donate-yellow.svg)](https://www.paypal.me/clarkwinkelmann)

This extension redirects non-canonical discussion URLs to their canonical version using HTTP 301 redirects.

**This extension has not been tested for subfolder installs and probably doesn't work on such setups!**

I'm unsure of the actual SEO benefits of this extension.
Flarum already uses the `canonical` meta tag which should be enough to prevent duplicate content.
301 redirects could help search engines in case of a discussion rename since it would otherwise appear as new content.
If anyone can test the actual impact I'll be happy to update this README with some metrics.

There is potential for infinite redirect loops if you rename a discussion back to its previous name and visitor browsers cached the previous redirects!

If you have a views counter extension enabled, two views might be counted when a user follows a redirected URL.

This extension has no settings. 302 redirects are used when debug mode is enabled.

## Installation

    composer require clarkwinkelmann/flarum-ext-http-discussion-redirects

## Support

This extension is under **minimal maintenance**.

It was developed for a client and released as open-source for the benefit of the community.
I might publish simple bugfixes or compatibility updates for free.

You can [contact me](https://clarkwinkelmann.com/flarum) to sponsor additional features or updates.

Support is offered on a "best effort" basis through the Flarum community thread.

## Links

- [GitHub](https://github.com/clarkwinkelmann/flarum-ext-http-discussion-redirects)
- [Packagist](https://packagist.org/packages/clarkwinkelmann/flarum-ext-http-discussion-redirects)
