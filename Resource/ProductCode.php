<?php

    namespace CodesWholesale\Resource;
    
    class ProductCode {
        
        private array $data;
    
        public function __construct(array $data) {
            $this->data = $data;
        }
    
        /**
         * Check if the code is a text code
         */
        public function isText(): bool {
            return ($this->data['codeType'] ?? '') === 'CODE_TEXT';
        }
    
        /**
         * Check if the code is an image code
         */
        public function isImage(): bool {
            return ($this->data['codeType'] ?? '') === 'CODE_IMAGE';
        }
    
        /**
         * Get the code value
         */
        public function getCode(): ?string {
            return $this->data['code'] ?? null;
        }
    
        /**
         * Get the filename associated with the code
         */
        public function getFilename(): ?string {
            return $this->data['filename'] ?? null;
        }
        
    }

?>
