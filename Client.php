<?php

    namespace CodesWholesale;
    
    use CodesWholesale\Storage\TokenStorageInterface;
    
    class Client {
        private $clientId;
        private $clientSecret;
        private $endpoint;
        private $tokenStorage;
    
        public function __construct(array $params) {
            $this->clientId     = $params['cw.client_id'];
            $this->clientSecret = $params['cw.client_secret'];
            $this->endpoint     = rtrim($params['cw.endpoint_uri'], '/');
            $this->tokenStorage = $params['cw.token_storage'];
        }
    
        /**
         * Get a valid access token
         *
         * @return string
         * @throws \Exception
         */
        private function getAccessToken(): string {
            $tokenData = $this->tokenStorage->getToken();
    
            if ($tokenData && $tokenData['expires_at'] > time()) {
                return $tokenData['access_token'];
            }
    
            $url  = $this->endpoint . '/oauth/token';
    
            $data = [
                'grant_type'    => 'client_credentials',
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
            ];
    
            $ch = curl_init($url);
    
            curl_setopt_array($ch, [
                CURLOPT_POST           => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS     => http_build_query($data),
                CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
            ]);
    
            $response = curl_exec($ch);
    
            if ($response === false) {
                throw new \Exception('cURL error: ' . curl_error($ch));
            }
    
            curl_close($ch);
    
            $json = json_decode($response, true);
            if (!isset($json['access_token'])) {
                throw new \Exception('Authentication failed: ' . $response);
            }
    
            $tokenData = [
                'access_token' => $json['access_token'],
                'expires_at'   => time() + $json['expires_in'] - 60,
            ];
    
            $this->tokenStorage->saveToken($tokenData);
    
            return $tokenData['access_token'];
        }
    
        /**
         * Make an HTTP request to the API
         *
         * @param string $method
         * @param string $endpoint
         * @param array $params
         * @return array
         * @throws \Exception
         */
        public function request(string $method, string $endpoint, array $params = []): array {
            $url = $this->endpoint . '/' . ltrim($endpoint, '/');
            $token = $this->getAccessToken();
    
            $headers = [
                'Authorization: Bearer ' . $token,
                'Accept: application/json',
            ];
    
            $ch = curl_init();
    
            if ($method === 'GET' && !empty($params)) {
                $url .= '?' . http_build_query($params);
            } elseif ($method === 'POST') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                $headers[] = 'Content-Type: application/json';
            }
    
            curl_setopt_array($ch, [
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_HTTPHEADER     => $headers,
            ]);
    
            $response = curl_exec($ch);
    
            if ($response === false) {
                throw new \Exception('cURL error: ' . curl_error($ch));
            }
    
            curl_close($ch);
    
            return json_decode($response, true);
        }
    
        /**
         * Clear the saved access token
         */
        public function clearToken(): void {
            $this->tokenStorage->clearToken();
        }
    }

?>
