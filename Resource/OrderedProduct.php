<?php

    namespace CodesWholesale\Resource;
    
    class OrderedProduct {
      
        private array $data;
    
        public function __construct(array $data) {
            $this->data = $data;
        }
    
        /**
         * Return product codes as ProductCode objects
         *
         * @return ProductCode[]
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
