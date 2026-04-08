<?php

declare(strict_types=1);

namespace App\Traits;

use JsonException;

trait JsonResponse
{
    /**
     * @throws JsonException
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data, JSON_THROW_ON_ERROR);
    }

    protected function error(string $message, int $statusCode): void
    {
        $this->json(['error' => $message], $statusCode);
    }
}
