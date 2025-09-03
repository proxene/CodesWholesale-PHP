<?php

    namespace CodesWholesale\Storage;
    
    class TokenSessionStorage implements TokenStorageInterface {
        
        private $sessionKey;
    
        /**
         * Constructor, optionally specify a custom session key
         *
         * @param string $sessionKey
         */
        public function __construct($sessionKey = 'codeswholesale_token') {
            $this->sessionKey = $sessionKey;
    
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }
    
        /**
         * Save token data in session
         *
         * @param array $tokenData
         */
        public function saveToken(array $tokenData): void {
            $_SESSION[$this->sessionKey] = $tokenData;
        }
    
        /**
         * Retrieve token data from session
         *
         * @return array|null
         */
        public function getToken(): ?array {
            return $_SESSION[$this->sessionKey] ?? null;
        }
    
        /**
         * Clear token data from session
         */
        public function clearToken(): void {
            unset($_SESSION[$this->sessionKey]);
        }
        
    }

?>
