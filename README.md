# This repository is no longer active.
⛔ No new issues ⛔ No pull requests ⛔ No maintenance

Source code is kept only for reference purposes.

# Messari.io PHP REST API Client
[![Build Status](https://travis-ci.org/codenix-sv/messari-api.svg?branch=master)](https://travis-ci.org/codenix-sv/messari-api)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/codenix-sv/messari-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/codenix-sv/messari-api/?branch=master)
[![Maintainability](https://api.codeclimate.com/v1/badges/b2c1309440c3aab07502/maintainability)](https://codeclimate.com/github/codenix-sv/messari-api/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/b2c1309440c3aab07502/test_coverage)](https://codeclimate.com/github/codenix-sv/messari-api/test_coverage)
[![License: MIT](https://img.shields.io/github/license/codenix-sv/messari-api)](https://github.com/codenix-sv/messari-api/blob/master/LICENSE)

A simple REST API client, written with PHP for [messari.io](https://messari.io).

Messari provides free API endpoints for thousands of crypto assets. These endpoints include trades, market data (VWAP), quantitative metrics, qualitative information. This is the same API that drives the [messari.io](https://messari.io) web app.

Most endpoints are accessible without an API key, but rate limited. This is free tier. This free tier does not include redistribution rights and requires attribution and a link back to [messari.io](https://messari.io).

Messari.io [API documentation](https://messari.io/api/docs).

## Requirements

* PHP >= 7.2
* ext-json

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ composer require codenix-sv/messari-api
```
or add

```json
"codenix-sv/messari-api": "^0.1"
```
## Basic usage

### Example
```php
use Codenixsv\MessariApi\MessariClient;

$client = new MessariClient();

$data = $client->assets()->getAll();
```
## Available methods

### Assets

#### getAll

Get the paginated list of all assets and their metrics and profiles.

```php
$data = $client->assets()->getAll();
```

#### get

Get basic metadata for an asset.

```php
$data = $client->assets()->get('btc');
```

#### getProfile

Get all of our qualitative information for an asset.

```php
$data = $client->assets()->getProfile('btc');
```

#### getMetrics

Get all of our quantitative metrics for an asset.

```php
$data = $client->assets()->getMetrics('btc');
```

#### getMarketData

Get the latest market data for an asset. This data is also included in the metrics endpoint, but if all you need is market-data, use this.

```php
$data = $client->assets()->getMarketData('btc');
```

#### getTimeseries

Retrieve historical timeseries data for an asset.

```php
$data = $client->assets()->getTimeseries('btc', 'price', ['start' => '2020-01-01', 'end' => '2020-01-07', 'interval' => '1d']);
```

### Markets

#### getAll

Get the list of all exchanges and pairs that our WebSocket-based market real-time market data API supports.

```php
$data = $client->markets()->getAll();
```

#### getTimeseries

Retrieve historical timeseries data for a market.

```php
$data = $client->markets()->getTimeseries('binance-btc-usdt', 'price', ['start' => '2020-01-01', 'end' => '2020-01-07', 'interval' => '1d']);
```

### News

#### getAll

Get the latest (paginated) news and analysis for all assets.

```php
$data = $client->news()->getAll();
```

#### GetForAsset

Get the latest (paginated) news and analysis for an asset.

```php
$data = $client->news()->getForAsset('btc');
```
## License

`codenix-sv/messari-api` is released under the MIT License. See the bundled [LICENSE](./LICENSE) for details.
