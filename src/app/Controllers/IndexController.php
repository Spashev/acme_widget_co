<?php

declare(strict_types=1);

namespace App\Controllers;

class IndexController
{
    public function home(): void
    {
        echo phpinfo();
    }
}
