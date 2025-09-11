<?php
namespace CodesWholesale\Resource;

class ProductCode
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function isText(): bool
    {
        return ($this->data['codeType'] ?? '') === 'CODE_TEXT';
    }

    public function isImage(): bool
    {
        return ($this->data['codeType'] ?? '') === 'CODE_IMAGE';
    }

    public function getCode(): ?string
    {
        return $this->data['code'] ?? null;
    }

    public function getFilename(): ?string
    {
        return $this->data['filename'] ?? null;
    }
}
