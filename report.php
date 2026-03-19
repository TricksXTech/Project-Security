<?php
$data = json_decode(file_get_contents("php://input"), true);

file_put_contents("client_logs.txt",
    date("Y-m-d H:i:s") . " | " . $_SERVER['REMOTE_ADDR'] . " | " . json_encode($data) . "\n",
    FILE_APPEND
);
