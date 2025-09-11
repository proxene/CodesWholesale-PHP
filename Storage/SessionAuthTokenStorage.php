<?php

    namespace CodesWholesale\Storage;

    class SessionAuthTokenStorage implements AuthTokenStorageInterface {

        private $sessionKey;

        public function __construct($sessionKey = 'codeswholesale_auth_token') {
            $this->sessionKey = $sessionKey;
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }

        public function saveToken(array $tokenData): void {
            $_SESSION[$this->sessionKey] = $tokenData;
        }

        public function getToken(): ?array {
            return $_SESSION[$this->sessionKey] ?? null;
        }

        public function clearToken(): void {
            unset($_SESSION[$this->sessionKey]);
        }

    }

?>