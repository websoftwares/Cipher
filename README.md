# Cipher

Encrypts/decrypts text with RIJNDAEL 256 Cipher.

## Usuage

```
    $securekey = '4s05Gim69k6Cn7E4Wl03cEI5v9K49l95';
    
    $size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CFB);
    $iv = mcrypt_create_iv($size, MCRYPT_DEV_URANDOM);

    $cipher = new Cipher($securekey, $iv);

    $encrypted = $cipher->encrypt('MySuperSecretText');
    $decrypted = $chipher->decrypt($encrypted);

    echo $decrypted;
```