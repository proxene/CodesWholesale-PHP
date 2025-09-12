<?php

    namespace CodesWholesale\Resource;
    use CodesWholesale\Client;

    class Order {

        private Client $client;
        private array $data;

        public function __construct(Client $client, array $data) {
            $this->client = $client;
            $this->data = $data;
        }

        /**
         * Create an order and return an Order object
         */
        public static function createOrder(Client $client, array $products, bool $allowPreOrder = true, ?string $clientOrderId = null): self {
            $payload = [
                'allowPreOrder' => $allowPreOrder,
                'orderId'       => $clientOrderId ?? uniqid('order_', true),
                'products'      => []
            ];

            foreach ($products as $p) {
                $item = [
                    'productId' => $p['productId'],
                    'quantity'  => $p['quantity']
                ];
                if (isset($p['price'])) {
                    $item['price'] = $p['price'];
                }
                $payload['products'][] = $item;
            }

            $response = $client->request('POST', '/v3/orders', $payload);
            return new self($client, $response);
        }

        /**
         * Return ordered products as OrderedProduct objects
         *
         * @return OrderedProduct[]
         */
        public function getProducts(): array {
            $products = [];
            foreach ($this->data['products'] ?? [] as $p) {
                $products[] = new OrderedProduct($p);
            }
            return $products;
        }

        /**
         * Get the order ID
         */
        public function getOrderId(): string {
            return $this->data['orderId'] ?? '';
        }

        /**
         * Get the order status
         */
        public function getStatus(): string {
            return $this->data['status'] ?? '';
        }

    }

?>