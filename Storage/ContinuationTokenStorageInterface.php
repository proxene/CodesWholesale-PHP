<?php

    namespace CodesWholesale\Storage;

    interface ContinuationTokenStorageInterface {

        public function saveContinuationToken(?string $token): void;
        public function getContinuationToken(): ?string;
        public function clearContinuationToken(): void;

    }

?>