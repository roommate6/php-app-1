<?php

declare(strict_types=1);

namespace App\Controllers;

use \App\Services\ViewService;
use App\Repositories\Transaction;
use App\Services\CSVReaderService;

class TransactionsController
{
    public function index(): string
    {
        $repository = new Transaction();
        $transactions = $repository->getAll();
        return ViewService::make(['Transactions', 'Index'], [
            'transactions' => $transactions,
            'transactionsMetadata' => $this->getMetadataAboutTransactions($transactions)
        ])->render();
    }

    public function getUpload(): string
    {
        return ViewService::make(['Transactions', 'Upload'])->render();
    }

    public function postUpload(): string
    {
        $pathToUploadedFile = $_FILES['transactions']['tmp_name'];
        $transactions = CSVReaderService::ReadTransactionFromFile($pathToUploadedFile);

        $repository = new Transaction();
        foreach ($transactions as $transaction) {
            $repository->create($transaction);
        }
        return '';
    }

    private function getMetadataAboutTransactions($transactions)
    {
        $result = ['total' => 0, 'income' => 0, 'expense' => 0];

        foreach ($transactions as $transaction) {
            $result['total'] += $transaction->amount;

            if ($transaction->amount > 0) {
                $result['income'] += $transaction->amount;
            }
        }
        $result['expense'] = $result['income'] - $result['total'];

        return $result;
    }
}
