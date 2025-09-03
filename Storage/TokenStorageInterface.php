<?php

    namespace CodesWholesale\Storage;

    interface TokenStorageInterface {

        public function saveToken(array $tokenData): void;
        public function getToken(): ?array;
        public function clearToken(): void;

    }

?>
