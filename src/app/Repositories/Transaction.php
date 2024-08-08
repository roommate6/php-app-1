<?php

declare(strict_types=1);

namespace App\Repositories;

use PDOException;

class Transaction extends BaseRepository
{
    public function __construct()
    {
        BaseRepository::__construct();
    }

    public function create(object $model): bool
    {
        try {
            $statement = $this->_databaseService->prepare(
                "INSERT INTO transactions
                 (`date`, check_number, `description`, amount)
                 VALUES
                 (?, ?, ?, ?);"
            );

            $statement->execute([
                $model->date,
                $model->checkNumber,
                $model->description,
                $model->amount
            ]);

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function getById(int $id): ?object
    {
        $statement = $this->_databaseService->prepare(
            'SELECT *
             FROM transactions
             WHERE id = ?;'
        );

        $statement->execute([$id]);

        $row = $statement->fetch() ?? null;
        if ($row === null) {
            return null;
        }
        $fetchedTransaction = new \App\Models\Transaction();
        $fetchedTransaction->id = $row['id'];
        $fetchedTransaction->date = $row['date'];
        $fetchedTransaction->checkNumber = $row['check_number'];
        $fetchedTransaction->description = $row['description'];
        $fetchedTransaction->amount = (float)$row['amount'];

        return $fetchedTransaction;
    }

    public function getAll(): array
    {
        $statement = $this->_databaseService->prepare(
            'SELECT *
             FROM transactions;'
        );
        $statement->execute();

        $result = [];
        foreach ($statement->fetchAll() as $row) {
            $fetchedTransaction = new \App\Models\Transaction();
            $fetchedTransaction->id = $row['id'];
            $fetchedTransaction->date = $row['date'];
            $fetchedTransaction->checkNumber = $row['check_number'];
            $fetchedTransaction->description = $row['description'];
            $fetchedTransaction->amount = (float)$row['amount'];

            array_push($result, $fetchedTransaction);
        }

        return $result;
    }
}
