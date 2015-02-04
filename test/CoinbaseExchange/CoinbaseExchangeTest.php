<?php

class CoinbaseExchangeTest extends PHPUnit_Framework_TestCase {
    public $exchange = null;

    public function setUp() {
        $this->exchange = new CoinbaseExchange();
    }
    public function testListProducts() {
        $products = $this->exchange->listProducts();
        $this->assertArrayHasKey('id', $products[0]);
        $this->assertArrayHasKey('base_currency', $products[0]);
        $this->assertArrayHasKey('quote_currency', $products[0]);
        $this->assertArrayHasKey('base_min_size', $products[0]);
        $this->assertArrayHasKey('base_max_size', $products[0]);
        $this->assertArrayHasKey('quote_increment', $products[0]);
        $this->assertArrayHasKey('display_name', $products[0]);
    }
    public function testListCurrencies() {
        $currencies = $this->exchange->listCurrencies();
        $this->assertArrayHasKey('id', $currencies[0]);
        $this->assertArrayHasKey('name', $currencies[0]);
        $this->assertArrayHasKey('min_size', $currencies[0]);
    }
}
