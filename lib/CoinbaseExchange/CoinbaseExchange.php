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
        'accounts' => array('method' => 'GET', 'uri' => '/accounts'),
        'account' => array('method' => 'GET', 'uri' => '/accounts/%s'),
        'ledger' => array('method' => 'GET', 'uri' => '/accounts/%s/ledger'),
        'holds' => array('method' => 'GET', 'uri' => '/accounts/%s/holds'),
        'place' => array('method' => 'POST', 'uri' => '/orders'),
        'cancel' => array('method' => 'DELETE', 'uri' => '/orders/%s'),
        'orders' => array('method' => 'GET', 'uri' => '/orders'),
        'order' => array('method' => 'GET', 'uri' => '/orders/%s'),
        'fills' => array('method' => 'GET', 'uri' => '/fills'),
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
     * Headers to send with each call
     */
    public $key = null;

    /**
     * Headers to send with each call
     */
    public $passphrase = null;

    /**
     * Headers to send with each call
     */
    public $timestamp = null;

    /**
     * The secret to sign each call with
     */
    public $secret = null;

    public function auth($key, $passphrase, $secret) {
        $this->key = $key;
        $this->passphrase = $passphrase;
        $this->secret = $secret;
    }

    /**
     * GET /accounts
     *
     * https://docs.exchange.coinbase.com/#list-accounts
     */
    public function listAccounts() {
        return $this->request('accounts');
    }

    /**
     * GET /accounts/<account-id>
     *
     * https://docs.exchange.coinbase.com/#get-an-account
     */
    public function getAccount($id) {
        return $this->request('account', array('id' => $id));
    }

    /**
     * GET /accounts/<account-id>/ledger
     *
     * https://docs.exchange.coinbase.com/#get-account-history
     */
    public function getAccountHistory($id) {
        return $this->request('ledger', array('id' => $id));
    }

    /**
     * GET /accounts/<account_id>/holds
     *
     * https://docs.exchange.coinbase.com/#get-holds
     */
    public function getHolds($id) {
        return $this->request('holds', array('id' => $id));
    }

    /**
     * POST /orders
     *
     * https://docs.exchange.coinbase.com/#place-a-new-order
     */
    public function placeOrder($side, $price, $size, $productId) {
        $data = array(
            //'client_oid' => '', // client generated UUID
            'price' => $price, // in quote_increment units (0.01 min for BTC-USD)
            'size' => $size, // must honor base_min_size and base_max_size
            'side' => $side, // buy or sell
            'product_id' => $productId
            //'stp' => 'dc' // Or one of co, cn, cb
        );
        return $this->request('place', $data);
    }

    /**
     * DELETE /orders/<order-id>
     *
     * https://docs.exchange.coinbase.com/#cancel-an-order
     */
    public function cancelOrder($id) {
        return $this->request('cancel', array('id' => $id));
    }

    /**
     * GET /orders
     *
     * https://docs.exchange.coinbase.com/#list-open-orders
     */
    public function listOrders() {
        return $this->request('orders');
    }


    /**
     * GET /orders/<order-id>
     *
     * https://docs.exchange.coinbase.com/#get-an-order
     */
    public function getOrder($id) {
        return $this->request('order', array('id' => $id));
    }

    /**
     * GET /fills
     *
     * https://docs.exchange.coinbase.com/#fills
     */
    public function listFills() {
        return $this->request('fills');
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
        return $this->request('book', array('id' => $product));
    }


    /**
     * GET /products/<product-id>/ticker
     *
     * https://docs.exchange.coinbase.com/#get-product-ticker
     */
    public function getTicker($product = 'BTC-USD') {
        return $this->request('ticker', array('id' => $product));
    }

    /**
     * GET /products/<product-id>/trades
     *
     * https://docs.exchange.coinbase.com/#get-trades
     */
    public function listTrades($product = 'BTC-USD') {
        return $this->request('trades', array('id' => $product));
    }

    /**
     * GET /products/<product-id>/candles
     *
     * https://docs.exchange.coinbase.com/#get-historic-rates
     */
    public function getHistoricRates($product = 'BTC-USD') {
        return $this->request('rates', array('id' => $product));
    }

    /**
     * GET /products/<product-id>/stats
     *
     * https://docs.exchange.coinbase.com/#get-24hr-stats
     */
    public function get24hrStats($product = 'BTC-USD') {
        return $this->request('stats', array('id' => $product));
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
        $body = (!empty($params) ? json_encode($params) : '');
        $headers = array(
            'User-Agent: CoinbaseExchangePHP/v0.1',
            'Content-Type: application/json',
            'CB-ACCESS-KEY: ' . $this->key,
            'CB-ACCESS-SIGN: ' . $this->sign($method . $uri . $body),
            'CB-ACCESS-TIMESTAMP: ' .  $this->timestamp,
            'CB-ACCESS-PASSPHRASE: ' . $this->passphrase,
        );

        $request = new CoinbaseExchange_Request;
        try {
            $response = $request->call($url, $method, $headers, $body);
            if ($response['statusCode'] === 200) {
                $response['body'] = json_decode($response['body'], true);
            }
            return $response;
        } catch (Exception $e) {
            return 'Caught exception: ' . $e->getMessage();
        }
    }

    protected function getEndpoint($key, $params) {
        $endpoint = $this->endpoints[$key];
        if (empty($endpoint)) {
            throw new Exception('Invalid endpoint ' . $key . ' specified');
        }
        if (!empty($params['id'])) {
            $endpoint['uri'] = sprintf($endpoint['uri'], $params['id']);
            unset($params['id']);
        }
        $endpoint['params'] = $params;
        return $endpoint;
    }

    protected function sign($data) {
        $this->timestamp = time();
        return base64_encode(hash_hmac(
            'sha256',
            $this->timestamp . $data,
            base64_decode($this->secret),
            true
        ));
    }
}
