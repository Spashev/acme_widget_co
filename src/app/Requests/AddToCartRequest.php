<?php

declare(strict_types=1);

namespace App\Requests;

class AddToCartRequest extends JsonRequest
{
    public readonly string $productCode;
    public readonly int $quantity;

    /** @var array<string, float> */
    private array $catalogue;

    /**
     * @param array<string, float> $catalogue
     */
    public function __construct(array $catalogue)
    {
        $this->catalogue = $catalogue;
        parent::__construct();
    }

    protected function validate(): void
    {
        $productCode = $this->input['product_code'] ?? null;
        $quantity = $this->input['quantity'] ?? 1;

        if (empty($productCode) || !is_string($productCode)) {
            $this->addError('product_code is required');
        } elseif (!isset($this->catalogue[$productCode])) {
            $this->addError("Product '$productCode' not found");
        }

        if (!is_int($quantity) || $quantity < 1) {
            $this->addError('quantity must be a positive integer');
        }

        $this->productCode = $productCode ?? '';
        $this->quantity = (int) $quantity;
    }
}
