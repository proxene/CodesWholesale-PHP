<?php

    namespace CodesWholesale\Resource;

    class OrderedProduct {

        private array $data;


        /**
        * Constructor for OrderedProduct
        *
        * @param array $data Ordered product data
        */
        public function __construct(array $data) {
            $this->data = $data;
        }


        /**
        * Get product codes as ProductCode objects
        *
        * @return ProductCode[] List of product codes
        */
        public function getCodes(): array {

            $codes = [];

            foreach ($this->data['codes'] ?? [] as $c) {
                $codes[] = new ProductCode($c);
            }

            return $codes;

        }

    }

?>