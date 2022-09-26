# Tidings Through mNotify
This package is for sending SMS notifications programmatically through mNotify. To use the package in your PHP (or Laravel)
application, you need to an [mNotify account](https://www.mnotify.com/).

You don't need to clone this repository to use this library in your own projects. Use Composer to install it from Packagist.

# Installation
If you're new to Composer, here are some resources that you may find useful:
 - [Composer's Getting Started page](https://getcomposer.org/doc/00-intro.md) from Composer project's documentation.
 - [A Beginner's Guide to Composer](https://scotch.io/tutorials/a-beginners-guide-to-composer) from the good people at ScotchBox.
##### Software Requirement
- Git
- Composer

##### Installation Steps

1. `composer require naviware/tidings-through-mnotify`
2. `composer update`

#### Publish Configuration File
To publish the configuration file, run the code below

`php artisan vendor:publish --provider="Naviware\TidingsThroughMNotify\Providers\TidingsServiceProvider" --tag="config"`

# Changelog
Please see [CHANGELOG](https://github.com/NaviwareRnD/tidings-through-mnotify/blob/main/CHANGELOG.md) for more information on what has changed recently.

# Contributing
Please see [CONTRIBUTING](https://github.com/NaviwareRnD/tidings-through-mnotify/blob/main/CONTRIBUTORS.md) for details.

# Security Vulnerabilities
Please review [our security policy](https://github.com/NaviwareRnD/tidings-through-mnotify/security/policy) on how to report security vulnerabilities.

# Testing Suite
This package has not been tested yet!

# Credits
- [KwesiNavilot](https://github.com/KwesiNavilot)
- [All Contributors](https://github.com/NaviwareRnD/tidings-through-mnotify/graphs/contributors)

# License
The MIT License (MIT). Please see [License File](https://github.com/NaviwareRnD/tidings-through-mnotify/blob/main/LICENSE.md) for more information.