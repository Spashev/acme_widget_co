<?php

declare(strict_types=1);

namespace App\Requests;

abstract class JsonRequest
{
    public readonly array $input;

    /** @var string[] */
    private array $errors = [];

    public function __construct()
    {
        $this->input = json_decode(file_get_contents('php://input'), true) ?? [];
        $this->validate();
    }

    abstract protected function validate(): void;

    protected function addError(string $message): void
    {
        $this->errors[] = $message;
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }

    /** @return string[] */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
