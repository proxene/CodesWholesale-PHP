<?php

    namespace CodesWholesale\Resource;

    class AccountItem {

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
        * Get account balance
        *
        * @return float|null Current balance or null if not set
        */
        public function getBalance(): ?float {
            return isset($this->data['currentBalance']) ? (float)$this->data['currentBalance'] : null;
        }

    }

?>
