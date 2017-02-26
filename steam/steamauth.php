<?php
ob_start();
session_start();
if (isset($_GET['login'])){
    require 'openid.php';
    try {
        require('SteamConfig.php');
        $openid = new LightOpenID($steamauth['domain']);

        if(!$openid->mode) {
            $openid->identity = 'https://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
        } elseif ($openid->mode == 'cancel') {
            echo 'User has canceled authentication!';
        } else {
            if($openid->validate()) {
                $id = $openid->identity;
                $ptn = '/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/';
                preg_match($ptn, $id, $matches);

                $_SESSION['steamid'] = $matches[1];
                if (!headers_sent()) {
                    header('Location: '.$steamauth['loginpage']);
                    exit;
                } else {
                    ?>
                    <script type="text/javascript">
                        window.location.href="<?=$steamauth['loginpage']?>";
                    </script>
                    <noscript>
                        <meta http-equiv="refresh" content="0;url=<?=$steamauth['loginpage']?>" />
                    </noscript>
                    <?php
                    exit;
                }
            } else {
                echo "User is not logged in.\n";
            }
        }
    } catch(ErrorException $e) {
        echo $e->getMessage();
    }
}

if(isset($_GET['verify'])) {

}

if (isset($_GET['logout'])){
    require 'SteamConfig.php';
    session_unset();
    session_destroy();
    header('Location: '.$steamauth['logoutpage']);
    exit;
}
?>