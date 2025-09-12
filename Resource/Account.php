<?php

    namespace CodesWholesale\Resource;

    use CodesWholesale\Client;

    class Account {


        /**
         * Retrieve current account details
         *
         * @param Client $client
         * @return AccountItem|null
         * @throws \Exception
         */
        public static function getCurrent(Client $client): ?AccountItem {

            $data = $client->request('GET', '/v3/accounts/current');
            return $data ? new AccountItem($data) : null;

        }

    }


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