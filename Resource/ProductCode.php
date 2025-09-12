<?php

    namespace CodesWholesale\Resource;

    class ProductCode {

        private array $data;


        /**
        * Constructor for ProductCode
        *
        * @param array $data Product code data
        */
        public function __construct(array $data) {
            $this->data = $data;
        }


        /**
        * Check if the code is a text code
        *
        * @return bool True if code type is text
        */
        public function isText(): bool {
            return ($this->data['codeType'] ?? '') === 'CODE_TEXT';
        }


        /**
        * Check if the code is an image code
        *
        * @return bool True if code type is image
        */
        public function isImage(): bool {
            return ($this->data['codeType'] ?? '') === 'CODE_IMAGE';
        }


        /**
        * Get the code value
        *
        * @return string|null Code value or null
        */
        public function getCode(): ?string {
            return $this->data['code'] ?? null;
        }


        /**
        * Get the filename associated with the code
        *
        * @return string|null Filename or null
        */
        public function getFilename(): ?string {
            return $this->data['filename'] ?? null;
        }


        /**
        * Get all links associated with the code
        *
        * @return array List of links
        */
        public function getLinks(): array {
            return $this->data['links'] ?? [];
        }


        /**
        * Save image code as a file
        *
        * Downloads the image code using the client and saves it to the specified directory.
        *
        * @param object $client The CodesWholesale client
        * @param string $saveDir Directory to save images
        * @param string $baseUrl Base URL to remove from href
        *
        * @return string Full path of saved image
        * @throws Exception If the code is not an image or download fails
        */
        public function saveImageBase64(object $client, string $saveDir = __DIR__ . '/codes', string $baseUrl = ''): string {

            if (!$this->isImage()) {

                throw new Exception("Only image codes can be downloaded.");

            }

            $links = $this->getLinks();

            if (empty($links[0]['href'])) {

                throw new Exception("No link found for this image code.");

            }

            $link = $links[0]['href'];
            $endpoint = $baseUrl ? str_replace($baseUrl, '', $link) : $link;

            $data = $client->request('GET', $endpoint);

            if (empty($data['filename']) || empty($data['code'])) {

                throw new Exception("Invalid API response for image code.");

            }

            if (!is_dir($saveDir)) {

                mkdir($saveDir, 0755, true);

            }

            $filepath = rtrim($saveDir, '/') . '/' . $data['filename'];
            $decoded = base64_decode($data['code']);

            if ($decoded === false) {

                throw new Exception("Failed to decode base64 image data.");

            }

            file_put_contents($filepath, $decoded);

            return $filepath;

        }

    }

?>