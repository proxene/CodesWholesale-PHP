<?php

    namespace CodesWholesale\Resource;
    
    use CodesWholesale\Client;
    
    class Product {
        /**
         * Retrieve all products, optionally processing them with a callback
         *
         * @param Client $client
         * @param callable|null $callback
         * @return array
         * @throws \Exception
         */
        public static function getAll(Client $client, callable $callback = null): array {
            $allProducts = [];
            $continuationToken = null;
            $retry = 0;
            $maxRetry = 5;
    
            do {
                try {
                    $params = [];
                    if ($continuationToken) {
                        $params['continuationToken'] = $continuationToken;
                    }
    
                    $response = $client->request('GET', '/v3/products', $params);
    
                    if (!empty($response['items'])) {
                        if ($callback) {
                            $callback($response['items']);
                        } else {
                            $allProducts = array_merge($allProducts, $response['items']);
                        }
                    }
    
                    $continuationToken = $response['continuationToken'] ?? null;
                    $retry = 0;
    
                    usleep(500000); // 0.5s pause
    
                } catch (\Exception $e) {
                    $retry++;
                    if ($retry > $maxRetry) {
                        throw new \Exception("Failed after {$maxRetry} attempts: " . $e->getMessage());
                    }
                    sleep(3);
                    continue;
                }
            } while ($continuationToken);
    
            return $allProducts;
        }
    
        /**
         * Retrieve a product by its ID
         *
         * @param Client $client
         * @param string $productId
         * @return array|null
         */
        public static function getById(Client $client, string $productId): ?array {
            return $client->request('GET', "/v3/products/{$productId}");
        }
        
    }

?>
