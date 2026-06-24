<?php
//NimaDArk045
header('Content-Type: application/json; charset=utf-8');
function unhide(string $input): string {
    $decodedBase64 = base64_decode($input);
    $key = "**rVg7EkL~c2`D[aNn";
    $keyLength = strlen($key);
    $strLength = strlen($decodedBase64);
    $output = "";
    for ($i = 0; $i < $strLength; $i++) {
        $keyIndex = $i % $keyLength;
        $xorResult = ord($decodedBase64[$i]) ^ ord($key[$keyIndex]);
        $output .= chr($xorResult);
    }
    return $output;
}
function decrypt($str){
    $sha1Hash = hash('sha1','8515D40BD04D8C97',true);
    $key = substr($sha1Hash, 0, 16);
    if (strlen($key) < 16) {
        $key = str_pad($key, 16, "\x00");
    }
    $encryptedBytes =base64_decode($str);
    return openssl_decrypt($encryptedBytes, 'aes-128-ecb', $key,OPENSSL_RAW_DATA );


}
function decryptConfig($str){
    $s = decrypt($str);
    $data = json_decode($s, true);
    if (isset($data['profilev5'])) {
        $fieldsToDecrypt = ['connection_mode', 'custom_payload', 'custom_host', 'custom_sni'];
        foreach ($fieldsToDecrypt as $field) {
            if (!empty($data['profilev5'][$field])) {
                $data['profilev5'][$field] = unhide($data['profilev5'][$field]);
            }
        }
    }
    return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

//======نحوه لستفاده=======
echo decryptConfig('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');



?>