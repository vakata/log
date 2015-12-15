# log

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Code Climate][ico-cc]][link-cc]
[![Tests Coverage][ico-cc-coverage]][link-cc]

A file logger class.

## Install

Via Composer

``` bash
$ composer require vakata/log
```

## Usage

``` php
// create an instance
// by default all error levels are logged to the default "error_log" location
$log = new \vakata\log\Log();
// log a message with some params
$log->debug('Just some info', ['context'=>'params']);
// add some additional context for all future calls
$log->addContext(['context'=>'for all future logs']);
// directly logging exceptions works too
try {
    throw new Exception('Some exception');
}
catch (\Exception $e) {
    $log->error($e);
}

// you can optionally make sure only certain error levels are logged
// and also specify a file for the log
$log = new \vakata\log\Log(
    \vakata\log\Log::ALL ^ \vakata\log\Log::DEBUG, // we log everything but debug
    __DIR__ . '/path/to.log'
);
```

Read more in the [API docs](docs/README.md)

## Testing

``` bash
$ composer test
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email github@vakata.com instead of using the issue tracker.

## Credits

- [vakata][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information. 

[ico-version]: https://img.shields.io/packagist/v/vakata/log.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/vakata/log/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/vakata/log.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/vakata/log.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/vakata/log.svg?style=flat-square
[ico-cc]: https://img.shields.io/codeclimate/github/vakata/log.svg?style=flat-square
[ico-cc-coverage]: https://img.shields.io/codeclimate/coverage/github/vakata/log.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/vakata/log
[link-travis]: https://travis-ci.org/vakata/log
[link-scrutinizer]: https://scrutinizer-ci.com/g/vakata/log/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/vakata/log
[link-downloads]: https://packagist.org/packages/vakata/log
[link-author]: https://github.com/vakata
[link-contributors]: ../../contributors
[link-cc]: https://codeclimate.com/github/vakata/log

