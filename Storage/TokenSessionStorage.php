<?php

    namespace CodesWholesale\Storage;

    class TokenSessionStorage extends AbstractSessionTokenStorage {

        public function __construct(string $sessionKey = 'codeswholesale_token') {
            parent::__construct($sessionKey);
        }

    }

?>
