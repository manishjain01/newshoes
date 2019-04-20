# Instagram API for Laravel 5.*

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

Simple Instagram API package for Laravel 5.*. Package is in development, but works - nothing crazy. Always looking for contributors.

## Installation

To install, run the following command in your project directory

``` bash
$ composer require mbarwick83/instagram
```

Then in `config/app.php` add the following to the `providers` array:

```
Mbarwick83\Instagram\InstagramServiceProvider::class
```

Also, if you must (recommend you don't), add the Facade class to the `aliases` array in `config/app.php` as well:

```
'Instagram'    => Mbarwick83\Instagram\Facades\Instagram::class
```

**But it'd be best to just inject the class, like so (this should be familiar):**

```
use Mbarwick83\Instagram\Instagram;
```

## Configuration

To publish the packages configuration file, run the following `vendor:publish` command:

```
php artisan vendor:publish
```

This will create a instagram.php in your config directory. Here you **must** enter your Instagram API Keys. Get your API keys at [https://www.instagram.com/developer/clients/register/](https://www.instagram.com/developer/clients/register/).

## Example Usage

``` php
// Get login url:
public function index(Instagram $instagram)
{
	return $instagram->getLoginUrl();
	// or Instagram::getLoginUrl();
}

// Get access token on callback, once user has authorized via above method
public function callback(Request $request, Instagram $instagram)
{
	$response = $instagram->getAccessToken($request->code);
	// or $response = Instagram::getAccessToken($request->code);

    if (isset($response['code']) == 400)
    {
        throw new \Exception($response['error_message'], 400);
    }
    
    return $response['access_token'];
}
```

Those are the only two custom classes for the API package. The rest of the API works with `POST`, `DELETE` and `GET` requests based on Instagram's end points to keep this package ***super simple***. You can view all the end points here [https://www.instagram.com/developer/endpoints/](https://www.instagram.com/developer/endpoints/).

All you need to do is specify if the request is a `POST`, `DELETE` or `GET` request, specify **just the end point** and any URL queries that are required (in an array).
For example:

```php
public function index(Instagram $instagram)
{
    $data = $instagram->get('v1/users/self', ['access_token' => $access_token]);
    // $data = $instagram->get('v1/users/' $user-id, ['access_token' => $access_token]);
    return $data;
}
```

**VERY SIMPLE AND EASY!**

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Credits

- [Mike Barwick][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/mbarwick83/instagram.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/mbarwick83/instagram.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/mbarwick83/instagram
[link-downloads]: https://packagist.org/packages/mbarwick83/instagram
[link-author]: https://github.com/mbarwick83
[link-contributors]: ../../contributors
