<!DOCTYPE html>
<html>

<head>
    <title>Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table tr th,
        table tr td {
            padding: 5px;
            border: 1px #eee solid;
        }

        tfoot tr th,
        tfoot tr td {
            font-size: 20px;
        }

        tfoot tr th {
            text-align: right;
        }

        .red-text {
            color: red;
        }

        .green-text {
            color: green;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Check #</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($this->transactions as $transaction) {
                $amountStyleClass = 'green-text';
                if ($transaction->amount < 0) {
                    $amountStyleClass = 'red-text';
                }

                echo '<tr>';
                echo "<th>"
                    . \App\Services\StringPipesService::dateToFormatedString($transaction->date) . "</th>";
                echo "<th>$transaction->checkNumber</th>";
                echo "<th>$transaction->description</th>";
                echo "<th class='$amountStyleClass'>"
                    . \App\Services\StringPipesService::amountToFormatedString($transaction->amount) . "</th>";
                echo '</tr>';
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Income:</th>
                <?php
                echo "<td class='green-text'>";
                echo \App\Services\StringPipesService::amountToFormatedString($this->transactionsMetadata['income']);
                echo '</td>';
                ?>
            </tr>
            <tr>
                <th colspan="3">Total Expense:</th>
                <?php
                echo "<td class='red-text'>";
                echo \App\Services\StringPipesService::amountToFormatedString($this->transactionsMetadata['expense']);
                echo '</td>';
                ?>
            </tr>
            <tr>
                <th colspan="3">Net Total:</th>
                <?php
                $styleClass = 'green-text';
                if ($this->transactionsMetadata['total'] < 0) {
                    $styleClass = 'red-text';
                }

                echo "<td class='$styleClass'>";
                echo \App\Services\StringPipesService::amountToFormatedString($this->transactionsMetadata['total']);
                echo '</td>';
                ?>
            </tr>
        </tfoot>
    </table>
</body>

</html>