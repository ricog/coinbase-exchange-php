# Coinbase Exchange API for PHP

A PHP library for communicating with the Coinbase Exchange.

**WARNING: This is a work in progress. Some parts may not work as expected.**

## Installation

### Composer Install

Require the library in your `composer.json`. ([What is Composer?](https://getcomposer.org/))

    "require": {
        "ricog/coinbase-exchange": ">=0.1"
    }

### Manual Install

Download the [latest release](https://github.com/ricog/coinbase-exchange-php/releases) and require `lib/CoinbaseExchange.php`.

    require_once('lib/CoinbaseExchange.php');

## Usage

Detailed usage can be found in [lib/CoinbaseExchange/CoinbaseExchange.php](lib/CoinbaseExchange/CoinbaseExchange.php).

### Public endpoints

Public endpoints do not require authentication.

    $exchange = new CoinbaseExchange();
    print_r($exchange->getTicker(), 1);

### Private endpoints

Private endpoints require authentication. Create an API key at [https://exchange.coinbase.com/settings](https://exchange.coinbase.com/settings).

    $exchange = new CoinbaseExchange();
    $exchange->auth('key', 'passphrase', 'secret');
    $exchange->placeOrder('sell', '1200.01', '.25', 'BTC-USD');

## TODO

- [x] Implement public endpoints.
- [x] Implement private trade enpoints.
- [ ] Add tests.
- [ ] Implement transfer endpoint.
