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
        *
        * @return void
        * @throws \Exception If maximum retries are exceeded
        */
        public static function getAll(Client $client, callable $callback, ?string $continuationToken = null): void {

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


    class ProductItem {

        private array $data;


        /**
        * Constructor for ProductItem
        *
        * @param array $data Product data
        */
        public function __construct(array $data) {
            $this->data = $data;
        }


        /**
        * Get product ID
        *
        * @return string|null Product ID
        */
        public function getId(): ?string {
            return $this->data['productId'] ?? null;
        }


        /**
        * Get product name
        *
        * @return string|null Product name
        */
        public function getName(): ?string {
            return $this->data['name'] ?? null;
        }


        /**
        * Get product prices
        *
        * @return array|null List of prices
        */
        public function getPrices(): ?array {
            return $this->data['prices'] ?? null;
        }


        /**
        * Get default price for quantity 1
        *
        * @return float|null Default price
        */
        public function getDefaultPrice(): ?float {

            $prices = $this->getPrices();

            if (!$prices) return null;

            foreach ($prices as $price) {

                if ($price['from'] == 1) {
                    return $price['value'];
                }

            }

            return null;

        }

        /**
        * Get available stock quantity
        *
        * @return int|null Stock quantity
        */
        public function getStock(): ?int {
            return $this->data['quantity'] ?? null;
        }


        /**
        * Get the platform name
        *
        * @return string|null Platform
        */
        public function getPlatform(): ?string {
            return $this->data['platform'] ?? null;
        }


        /**
        * Get available regions
        *
        * @return array|null List of regions
        */
        public function getRegions(): ?array {
            return $this->data['regions'] ?? null;
        }

        /**
        * Get the release date
        *
        * @return string|null Release date
        */
        public function getReleaseDate(): ?string {

            if (empty($this->data['releaseDate'])) {
                return null;
            }

            $timestamp = strtotime($this->data['releaseDate']);
            if ($timestamp === false) {
                return null;
            }

            return date('d/m/Y', $timestamp);

        }

    }

?>