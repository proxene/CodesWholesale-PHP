<?php

    namespace CodesWholesale\Storage;

    abstract class AbstractSessionTokenStorage implements TokenStorageInterface {

        protected string $sessionKey;

        public function __construct(string $sessionKey) {
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
