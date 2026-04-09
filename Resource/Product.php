<?php

    namespace CodesWholesale\Resource;

    use CodesWholesale\Client;

    class Product {

        /**
        * Retrieve all products, optionally processing them with a callback
        *
        * @param Client $client The CodesWholesale client
        * @param callable|null $callback Callback to process retrieved items
        * @param string|null $continuationToken Token for paginated requests
        * @param array $filters Optional query filters (e.g. updatedSince, createdSince)
        *
        * @return void
        * @throws \Exception If maximum retries are exceeded
        */
        public static function getAll(Client $client, callable $callback, ?string $continuationToken = null, array $filters = []): void {

            $retry = 0;
            $maxRetry = 5;

            do {

                try {

                    $params = $filters; // updatedSince, createdSince, etc.

                    if ($continuationToken) {
                        $params['continuationToken'] = $continuationToken;
                    }

                    $response = $client->request('GET', '/v3/products', $params);

                    if (!empty($response['items'])) {
                        $callback($response['items'], $response['continuationToken'] ?? null);
                    }

                    $continuationToken = $response['continuationToken'] ?? null;
                    $retry = 0;

                    usleep(200000);

                } catch (\Exception $e) {

                    $retry++;

                    if ($retry > $maxRetry) {
                        throw new \Exception("Failed after {$maxRetry} attempts: " . $e->getMessage());
                    }

                    sleep(3);

                }

            } while ($continuationToken);

        }


        /**
        * Retrieve a product by its ID
        *
        * @param Client $client The CodesWholesale client
        * @param string $productId The product identifier
        *
        * @return ProductItem|null ProductItem instance or null if not found
        */
        public static function getById(Client $client, string $productId): ?ProductItem {

            $data = $client->request('GET', "/v3/products/{$productId}");
            return $data ? new ProductItem($data) : null;

        }

    }

?>