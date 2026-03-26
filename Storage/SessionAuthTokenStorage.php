<?php

    namespace CodesWholesale\Storage;

    class SessionAuthTokenStorage extends AbstractSessionTokenStorage implements AuthTokenStorageInterface {

        public function __construct(string $sessionKey = 'codeswholesale_auth_token') {
            parent::__construct($sessionKey);
        }

    }

?>
