<?php
session_start();

// ===== CONFIG =====
$BLOCK_TIME = 600; // 10 min
$RATE_LIMIT = 50; // requests
$RATE_WINDOW = 10; // seconds

$ip = $_SERVER['REMOTE_ADDR'];
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

// ===== FILES =====
$blockFile = __DIR__ . "/blocked.json";
$rateFile  = __DIR__ . "/rate.json";

// ===== LOAD DATA =====
$blocked = file_exists($blockFile) ? json_decode(file_get_contents($blockFile), true) : [];
$rate    = file_exists($rateFile) ? json_decode(file_get_contents($rateFile), true) : [];

// ===== BLOCK CHECK =====
if (isset($blocked[$ip]) && time() < $blocked[$ip]) {
    http_response_code(403);
    exit("Access Denied");
}

// ===== RATE LIMIT =====
$now = time();
$rate[$ip][] = $now;

// remove old
$rate[$ip] = array_filter($rate[$ip], fn($t) => $t > ($now - $RATE_WINDOW));

if (count($rate[$ip]) > $RATE_LIMIT) {
    $blocked[$ip] = $now + $BLOCK_TIME;
}

// ===== INPUT SCAN =====
function detect_attack($input) {
    $patterns = [
        '/union\s+select/i',
        '/select.+from/i',
        '/<script/i',
        '/onerror=/i',
        '/base64_decode/i',
        '/\.\.\//'
    ];

    foreach ($patterns as $p) {
        if (preg_match($p, $input)) return true;
    }
    return false;
}

$score = 0;

// scan GET/POST
foreach ($_REQUEST as $k => $v) {
    if (detect_attack($v)) $score += 50;
}

// bad UA
if (preg_match('/curl|python|wget/i', $ua)) {
    $score += 20;
}

// ===== SESSION PROTECTION =====
if (!isset($_SESSION['ua'])) {
    $_SESSION['ua'] = $ua;
    $_SESSION['ip'] = $ip;
} else {
    if ($_SESSION['ua'] !== $ua) $score += 30;
    if ($_SESSION['ip'] !== $ip) $score += 30;
}

// ===== FINAL DECISION =====
if ($score > 60) {
    $blocked[$ip] = $now + $BLOCK_TIME;

    file_put_contents(__DIR__."/logs.txt",
        date("Y-m-d H:i:s") . " | $ip | SCORE:$score | " . json_encode($_REQUEST) . "\n",
        FILE_APPEND
    );

    http_response_code(403);
    exit("Blocked by security system");
}

// ===== SAVE FILES =====
file_put_contents($blockFile, json_encode($blocked));
file_put_contents($rateFile, json_encode($rate));
