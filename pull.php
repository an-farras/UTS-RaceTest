<?php

include 'functions.php';
$pdo = pdo_connect();

if (isset($_GET['id'])&&isset($_GET['amount'])) {
    $data_pulled = $_GET['amount'];
    $pdo->beginTransaction();
    $stmt = $pdo->prepare('SELECT * FROM deposit WHERE id = ? FOR UPDATE');
    $stmt->execute([$_GET['id']]);
    $deposit = $stmt->fetch(PDO::FETCH_ASSOC);
    if($deposit['amount'] >= $data_pulled){
        $d_now = $deposit['amount'] - $data_pulled;
        $stmt = $pdo->prepare('UPDATE deposit set amount= ? WHERE id = ?');
        $stmt->execute([$d_now, $_GET['id']]);
        echo "success\n";
    } else {
        die('Not enough amount');
    }
    $pdo->commit();
} else {
    die ('No ID specified!');
}

?>