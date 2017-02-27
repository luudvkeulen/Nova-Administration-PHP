<?php
ob_start();
session_start();

if (isset($_GET['login'])) {
    require 'openid.php';
    try {
        require('SteamConfig.php');
        $openid = new LightOpenID($steamauth['domain']);

        if (!$openid->mode) {
            $openid->identity = 'https://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
        } elseif ($openid->mode == 'cancel') {
            echo 'User has canceled authentication!';
        } else {
            if ($openid->validate()) {
                $id = $openid->identity;
                $ptn = '/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/';
                preg_match($ptn, $id, $matches);

                $db = new PDO('mysql:host=localhost;dbname=nova_administration;charset=utf8mb4', 'novaadmin', 'Nova2016');
                $stmt = $db->prepare('SELECT * FROM steamid_whitelist WHERE steamid = ?');
                $stmt->execute([$matches[1]]);
                $result = $stmt->fetch(PDO::FETCH_OBJ);
                $success = false;
                if (!isset($result->id)) {
                    $stmt = $db->prepare('INSERT INTO logins (steamid, success, ip) VALUES (?, \'0\', ?);');
                    $stmt->execute([$matches[1], $_SERVER['REMOTE_ADDR']]);
                } else {
                    $success = true;
                    $_SESSION['id'] = $result->id;
                    $stmt = $db->prepare('INSERT INTO logins (steamid, success, ip) VALUES (?, \'1\', ?);');
                    $stmt->execute([$matches[1], $_SERVER['REMOTE_ADDR']]);
                }

                if ($success) {
                    header('Location: players.php');
                } else {
                    header('Location: /');
                }
                exit;
            } else {
                echo "User is not logged in.\n";
            }
        }
    } catch (ErrorException $e) {
        echo $e->getMessage();
    }
}

if (isset($_GET['verify'])) {

}

if (isset($_GET['logout'])) {
    require 'SteamConfig.php';
    session_unset();
    session_destroy();
    header('Location: ' . $steamauth['logoutpage']);
    exit;
}
?>