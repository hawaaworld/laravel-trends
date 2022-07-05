<p align="center"><img src="https://i.ibb.co/cccf74t/logo.png" alt="Laravel Trends"></p>

<p align="center">
<a href="https://packagist.org/packages/hawaaworld/laravel-trends"><img src="https://poser.pugx.org/hawaaworld/laravel-trends/d/total" alt="Total Downloads"></a> <a href="https://packagist.org/packages/hawaaworld/laravel-trends"><img src="https://poser.pugx.org/hawaaworld/laravel-trends/v/stable" alt="Latest Stable Version"></a> <a href="https://packagist.org/packages/hawaaworld/laravel-trends"><img src="https://poser.pugx.org/hawaaworld/laravel-trends/license" alt="License"></a>
</p>

> **Note**
> This package is a fork of [hacklabsdev/laravel-trends](https://github.com/hacklabsdev/laravel-trends) and is not maintained by the original author.

## Introduction

Have you ever wondered how Twitter's Trending Topics works? Laravel Trends provides a lightweight trending system to your application.

## Prerequisites

Before you install the package make sure you have queues working and running since Trends uses it to control the tendencies. Refer to Laravel [official documentation](https://laravel.com/docs/master/queues#introduction "official documentation") in order to configure queues in your project.

## Installation

You may install Laravel Trends via Composer:

`composer require hawaaworld/laravel-trends`

Next, publish the Trends configuration and migration files using the vendor:publish command. The configuration file will be placed in your config directory:

`php artisan vendor:publish --provider="Hawaaworld\Trends\TrendsServiceProvider"`

And finally, you should run your database migrations:

`php artisan migrate`

## How it works

`Trends` allows you to create a trending system for any model you want. Let's take Twitter as an example. Everytime a hashtag is tweeted it receives 1 point of energy, but after 30 minutes this single point of energy loss 0.25 of its value. After more 30 minutes it loss 0.45 points of its value. Finally, after another 30 minutes it loss 0.30 of its value returning to 0. But how can a trend be detected? Imagine that thousands of people hits the same hashtag at the same time, this hashtag will have thousands of energy points and if you have an ordered list of hashtags this one will surely be on top, but after a few minutes if this hashtag doesn't receive any more energy points it will start to lose its energy and loss over time.

## Configuration

To configure your losing time you can set the `loss_time` parameter in `config/trends.php`. The losing time is measured in hours.

## Preparing your model

To allow your model to work with Trends you'll need to implement the Energy interface with HasEnergy trait. And in order to return the current model's energy value, add `energy_amount` to your serialization.
```php
use Hawaaworld\Trends\Contracts\Energy;
use Hawaaworld\Trends\Traits\HasEnergy;

class Hashtag extends Model implements Energy
{
    use HasEnergy;
    
    protected $appends = ['energy_amount'];
}
```
## Usage

To add energy to your model use the following method:
```php
$hashtag->addEnergy(amount: 1.0);
```

To get the current energy amount:

```php
$hashtag->energy->amount;
```

## Getting the top trends

to get the top trends you can use the following method:

```php
$trendingArticles = Trends::top(10, Article::class);
```

The above code gets a top 10 trending articles, also you can set your own query builder to get the trending models you want:
    
```php
$trendingArticles = Trends::top(10, Article::class, function($query) {
    $query->where('published', true);
});
```

## License

Laravel Trends is open-sourced software licensed under the [MIT license](LICENSE.md).
