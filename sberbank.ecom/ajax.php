<?
require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';
if ($_REQUEST['check_https'] == 'Y')
{
    echo "PHP version: " . phpversion() . "<br />";
    if (function_exists('curl_version')) {
        $curl = curl_version();
        echo "cURL version: " . $curl["version"] . "<br />";
        $ch = curl_init('https://www.howsmyssl.com/a/check');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($data);

        echo "TLS version: " . $json->tls_version . "<br />";
    } else {
        echo "cURL: Not installed!!! \n";
    }
    echo "OpenSSL version text: " . OPENSSL_VERSION_TEXT . "<br />";
    echo "OpenSSL version number: " . OPENSSL_VERSION_NUMBER . "<br />";
}
