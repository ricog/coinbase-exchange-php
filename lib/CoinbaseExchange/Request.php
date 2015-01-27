<?php

class CoinbaseExchange_Request {
	public function call($url, $method, $params = array()) {
		$queryString = http_build_query($params);
        $headers = array(
            'User-Agent: CoinbaseExchangePHP/v0.1'
        );
		$curl = curl_init();
		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_RETURNTRANSFER => true,
		);

        $method = strtolower($method);
        if ($method == 'get') {
            $options[CURLOPT_HTTPGET] = 1;
            if ($queryString) {
                $options[CURLOPT_URL] .= "?" . $queryString;
            }
        } else if ($method == 'post') {
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = $queryString;
        } else if ($method == 'delete') {
            $options[CURLOPT_CUSTOMREQUEST] = "DELETE";
            if ($queryString) {
                $options[CURLOPT_URL] .= "?" . $queryString;
            }
        } else if ($method == 'put') {
            $options[CURLOPT_CUSTOMREQUEST] = "PUT";
            $options[CURLOPT_POSTFIELDS] = $queryString;
        }
		curl_setopt_array($curl, $options);
		$response = curl_exec($curl);
		if ($response === false) {
			$error = curl_errno($curl);
			$message = curl_error($curl);
			curl_close($curl);
			throw new Exception("Network error " . $message . " (" . $error . ")");
		}

		$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		if($statusCode != 200) {
			throw new Exception("Status code " . $statusCode . ' ' . $response);
		}
		return array( "statusCode" => $statusCode, "body" => $response );
	}
}
