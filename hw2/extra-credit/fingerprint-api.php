<?php
header("Cache-Control: no-cache");
header("Content-Type: application/json");

$dataDir = "/var/lib/hw2-fingerprint-demo";
$dataFile = $dataDir . "/records.json";
$cookieName = "fp_demo_sid";

function load_records($dataFile) {
    if (!file_exists($dataFile)) {
        return [];
    }
    $fp = fopen($dataFile, "r");
    flock($fp, LOCK_SH);
    $contents = stream_get_contents($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    $records = json_decode($contents, true);
    return is_array($records) ? $records : [];
}

function save_records($dataFile, $records) {
    $fp = fopen($dataFile, "c");
    flock($fp, LOCK_EX);
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode($records, JSON_PRETTY_PRINT));
    flock($fp, LOCK_UN);
    fclose($fp);
}

function find_by_cookie($records, $cookieSid) {
    if (!$cookieSid) {
        return null;
    }
    foreach ($records as $i => $r) {
        if ($r['cookieSid'] === $cookieSid) {
            return $i;
        }
    }
    return null;
}

function find_by_fingerprint($records, $visitorId) {
    if (!$visitorId) {
        return null;
    }
    foreach ($records as $i => $r) {
        if ($r['visitorId'] === $visitorId) {
            return $i;
        }
    }
    return null;
}

$action = $_GET['action'] ?? '';
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    $input = [];
}

$visitorId = $input['visitorId'] ?? '';
$currentCookieSid = $_COOKIE[$cookieName] ?? null;

$records = load_records($dataFile);

if ($action === 'identify') {
    $idx = find_by_cookie($records, $currentCookieSid);
    if ($idx !== null) {
        echo json_encode([
            'status' => 'known-cookie',
            'name' => $records[$idx]['name'],
            'note' => $records[$idx]['note'],
            'savedAt' => $records[$idx]['savedAt'],
        ]);
        exit;
    }

    $idx = find_by_fingerprint($records, $visitorId);
    if ($idx !== null) {
        $newSid = bin2hex(random_bytes(16));
        $records[$idx]['cookieSid'] = $newSid;
        save_records($dataFile, $records);
        setcookie($cookieName, $newSid, time() + 86400 * 30, "/hw2/extra-credit/");
        echo json_encode([
            'status' => 'reassociated',
            'name' => $records[$idx]['name'],
            'note' => $records[$idx]['note'],
            'savedAt' => $records[$idx]['savedAt'],
        ]);
        exit;
    }

    echo json_encode(['status' => 'new']);
    exit;
}

if ($action === 'save') {
    $name = $input['name'] ?? '';
    $note = $input['note'] ?? '';

    $idx = find_by_cookie($records, $currentCookieSid);
    if ($idx === null) {
        $idx = find_by_fingerprint($records, $visitorId);
    }

    $newSid = bin2hex(random_bytes(16));
    $now = date("D M j H:i:s Y");

    if ($idx !== null) {
        $records[$idx]['name'] = $name;
        $records[$idx]['note'] = $note;
        $records[$idx]['visitorId'] = $visitorId;
        $records[$idx]['cookieSid'] = $newSid;
        $records[$idx]['savedAt'] = $now;
    } else {
        $records[] = [
            'visitorId' => $visitorId,
            'cookieSid' => $newSid,
            'name' => $name,
            'note' => $note,
            'savedAt' => $now,
        ];
    }

    save_records($dataFile, $records);
    setcookie($cookieName, $newSid, time() + 86400 * 30, "/hw2/extra-credit/");

    echo json_encode(['status' => 'saved', 'name' => $name, 'note' => $note, 'savedAt' => $now]);
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'unknown action']);
