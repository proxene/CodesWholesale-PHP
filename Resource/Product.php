<?php

    namespace CodesWholesale\Resource;

    use CodesWholesale\Client;

    class Product {


        private array $data;

        public function __construct(array $data)
        {
            $this->data = $data;
        }


        /**
         * Retrieve all products, optionally processing them with a callback
         *
         * @param Client $client
         * @param callable|null $callback
         * @return array
         * @throws \Exception
         */
        public static function getAll(Client $client, callable $callback): void {
            $continuationToken = null;
            $retry = 0;
            $maxRetry = 5;

            do {
                try {
                    $params = [];
                    if ($continuationToken) $params['continuationToken'] = $continuationToken;

                    $response = $client->request('GET', '/v3/products', $params);

                    if (!empty($response['items'])) {
                        $callback($response['items'], $response['continuationToken'] ?? null);
                    }

                    $continuationToken = $response['continuationToken'] ?? null;
                    $retry = 0;

                    usleep(200000);

                } catch (\Exception $e) {
                    $retry++;
                    if ($retry > $maxRetry) throw new \Exception("Failed after {$maxRetry} attempts: ".$e->getMessage());
                    sleep(3);
                }

            } while ($continuationToken);
        }


        /**
         * Retrieve a product by its ID
         *
         * @param Client $client
         * @param string $productId
         * @return array|null
         */
        public static function getById(Client $client, string $productId): ?self {
            $data = $client->request('GET', "/v3/products/{$productId}");
            return $data ? new self($data) : null;
        }

        public function getName(): ?string {
            return $this->data['name'] ?? null;
        }

        public function getPrices(): ?array {
            return $this->data['prices'] ?? null;
        }

        public function getDefaultPrices(): ?float {

            $prices = $this->getPrices();

            if (!$prices) return null;

            foreach ($prices as $price) {
                if ($price['from'] == 1) {
                    return $price['value'];
                }
            }

            return null;

        }

        public function getStock(): ?int {
            return $this->data['quantity'] ?? null;
        }

        public function getPlatform(): ?string {
            return $this->data['platform'] ?? null;
        }

        public function getRegions(): ?array {
            return $this->data['regions'] ?? null;
        }

    }

?>