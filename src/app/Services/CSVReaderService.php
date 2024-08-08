<?php

declare(strict_types=1);

namespace App\Services;

use \App\Models\Transaction;

class CSVReaderService
{
    public static function readTransactionFromFile(string $filePath): array
    {
        if (!file_exists($filePath)) {
            return [];
        }

        $file = fopen($filePath, 'r');

        $result = [];

        fgetcsv($file);
        while (($transactionRow = fgetcsv($file)) !== false) {
            array_push($result, static::parseRowToTransaction($transactionRow));
        }

        return $result;
    }

    private static function parseRowToTransaction(array $transactionRow): Transaction
    {
        $transactionModel = new Transaction();

        $rawDateArray = explode('/', $transactionRow[0]);
        $timeStamp = mktime(0, 0, 0, (int)$rawDateArray[0], (int)$rawDateArray[1], (int)$rawDateArray[2]);
        $transactionModel->date = date('Y-m-d', $timeStamp);

        $transactionModel->checkNumber = (int)$transactionRow[1];
        $transactionModel->description = $transactionRow[2];

        $amount = str_replace(['"', '$', ','], '', $transactionRow[3]);
        $transactionModel->amount = (float)$amount;

        return $transactionModel;
    }
}
