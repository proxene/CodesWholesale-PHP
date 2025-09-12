<?php

    namespace CodesWholesale\Storage;

    class FileContinuationTokenStorage implements ContinuationTokenStorageInterface {

        private $file;

        public function __construct($file = __DIR__ . '/last_token.txt') {
            $this->file = $file;
        }

        public function saveContinuationToken(?string $token): void {
            if ($token) {
                file_put_contents($this->file, $token);
            } else {
                $this->clearContinuationToken();
            }
        }

        public function getContinuationToken(): ?string {
            return file_exists($this->file) ? trim(file_get_contents($this->file)) : null;
        }

        public function clearContinuationToken(): void {
            if (file_exists($this->file)) {
                unlink($this->file);
            }
        }

    }

?>