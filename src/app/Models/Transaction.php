<?php

declare(strict_types=1);

namespace App\Models;

class Transaction extends BaseModel
{
    public string $date;
    public int $checkNumber;
    public string $description;
    public float $amount;
}
