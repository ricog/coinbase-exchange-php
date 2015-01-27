<?php

/**
 * Coinbase Exchange API
 *
 * https://docs.exchange.coinbase.com
 */
class CoinbaseExchange {

	/**
	 * API Endpoint URL
	 */
	public $url = 'https://api.exchange.coinbase.com';

	/**
	 * An array of API endpoints
	 */
	public $endpoints = array(
        'products' => array('method' => 'GET', 'uri' => '/products'),
        'book' => array('method' => 'GET', 'uri' => '/products/%s/book'),
        'ticker' => array('method' => 'GET', 'uri' => '/products/%s/ticker'),
        'trades' => array('method' => 'GET', 'uri' => '/products/%s/trades'),
        'stats' => array('method' => 'GET', 'uri' => '/products/%s/stats'),
        'rates' => array('method' => 'GET', 'uri' => '/products/%s/candles'),
	    'currencies' => array('method' =>'GET', 'uri' =>  '/currencies'),
		'time' => array('method' => 'GET', 'uri' => '/time'),
	);

	/**
	 * GET /accounts
	 *
	 * https://docs.exchange.coinbase.com/#list-accounts
	 */
	public function listAccounts() {
	}

	/**
	 * GET /accounts/<account-id>
	 *
	 * https://docs.exchange.coinbase.com/#get-an-account
	 */
	public function getAccount() {
	}

	/**
	 * GET /accounts/<account-id>/ledger
	 *
	 * https://docs.exchange.coinbase.com/#get-account-history
	 */
	public function getAccountHistory() {
	}

	/**
	 * GET /accounts/<account_id>/holds
	 *
	 * https://docs.exchange.coinbase.com/#get-holds
	 */
	public function getHolds() {
	}

	/**
	 * POST /orders
	 *
	 * https://docs.exchange.coinbase.com/#place-a-new-order
	 */
	public function placeOrder() {
	}

	/**
	 * DELETE /orders/<order-id>
	 *
	 * https://docs.exchange.coinbase.com/#cancel-an-order
	 */
	public function cancelOrder() {
	}

	/**
	 * GET /orders
	 *
	 * https://docs.exchange.coinbase.com/#list-open-orders
	 */
	public function listOrders() {
	}


	/**
	 * GET /orders/<order-id>
	 *
	 * https://docs.exchange.coinbase.com/#get-an-order
	 */
	public function getOrder() {
	}

	/**
	 * GET /fills
	 *
	 * https://docs.exchange.coinbase.com/#fills
	 */
	public function listFills() {
	}


	/**
	 * POST /transfers
	 *
	 * https://docs.exchange.coinbase.com/#transfer-funds
	 */
	public function transferFunds() {
	}

	/**
	 * GET /products
	 *
	 * https://docs.exchange.coinbase.com/#products
	 */
	public function products() {
		return $this->request('products');
	}


	/**
	 * GET /products/<product-id>/book
	 *
	 * https://docs.exchange.coinbase.com/#get-product-order-book
	 */
	public function getOrderBook($product = 'BTC-USD') {
        //$this->validate('product', $product);
		return $this->request('book', array('product' => $product));
	}


	/**
	 * GET /products/<product-id>/ticker
	 *
	 * https://docs.exchange.coinbase.com/#get-product-ticker
	 */
	public function getTicker($product = 'BTC-USD') {
		return $this->request('ticker', array('product' => $product));
	}

	/**
	 * GET /products/<product-id>/trades
	 *
	 * https://docs.exchange.coinbase.com/#get-trades
	 */
	public function listTrades($product = 'BTC-USD') {
		return $this->request('trades', array('product' => $product));
	}

	/**
	 * GET /products/<product-id>/candles
	 *
	 * https://docs.exchange.coinbase.com/#get-historic-rates
	 */
	public function getHistoricRates($product = 'BTC-USD') {
		return $this->request('rates', array('product' => $product));
	}

	/**
	 * GET /products/<product-id>/stats
	 *
	 * https://docs.exchange.coinbase.com/#get-24hr-stats
	 */
	public function get24hrStats($product = 'BTC-USD') {
		return $this->request('stats', array('product' => $product));
	}

	/**
	 * GET /currencies
	 *
	 * https://docs.exchange.coinbase.com/#get-currencies
	 */
	public function listCurrencies() {
		return $this->request('currencies');
	}

	/**
	 * GET /time
	 *
	 * https://docs.exchange.coinbase.com/#time
	 */
	public function getTime() {
		return $this->request('time');
	}

	protected function request($endpoint, $params = array()) {
		extract($this->getEndpoint($endpoint, $params));
        $url = $this->url . $uri;
        $exchange = new CoinbaseExchange_Request;
        try {
            $response = $exchange->call($url, $method, $params);
            $response['body'] = json_decode($response['body']);
            return $response;
        } catch (Exception $e) {
            throw new Exception('Unable to parse response');
        }

	}

	protected function getEndpoint($key, $params) {
        $endpoint = $this->endpoints[$key];
        if (empty($endpoint)) {
            throw new Exception('Invalid endpoint ' . $key . ' specified');
        }
        if (!empty($params['product'])) {
            $endpoint['uri'] = sprintf($endpoint['uri'], $params['product']);
        }
        return $endpoint;
 	}
}
