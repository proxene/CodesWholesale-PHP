<?php
namespace CodesWholesale\Resource;

class OrderedProduct
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Retourne les codes du produit sous forme d’objets ProductCode
     *
     * @return ProductCode[]
     */
    public function getCodes(): array
    {
        $codes = [];
        foreach ($this->data['codes'] ?? [] as $c) {
            $codes[] = new ProductCode($c);
        }
        return $codes;
    }
}
