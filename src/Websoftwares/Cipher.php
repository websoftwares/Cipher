<?php
namespace Websoftwares;
/**
 * Cipher class
 * Encrypts/decrypts text with RIJNDAEL 256 Cipher
 *
 * @package Websoftwares
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 * @author Boris <boris@websoftwar.es>
 */
class Cipher
{
    /**
     * $securekey a random secure key to use
     * @var string
     */
    private $securekey = null;

    /**
     * $iv initialization vector
     * @var string
     */
    private $iv = null;

    public function __construct($securekey = null ,$iv = null)
    {
        if (! $securekey) {
            throw new \InvalidArgumentException('securekey is a required arguments');
        }

        if (! $iv) {
            throw new \InvalidArgumentException('iv is a required arguments');
        }

        $this->securekey = $securekey;
        $this->iv = $iv;
    }

    /**
     * encrypt some super secret text
     * @param  string $input
     * @return string
     */
    public function encrypt($input = null)
    {
        if (! $input) {
            throw new \InvalidArgumentException('input is a required argument');
        }

        return $this->base64safeEncode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->securekey, $input, MCRYPT_MODE_ECB, $this->iv));
    }

    /**
     * decrypt some super secret text
     * @param  string $input
     * @return string
     */
    public function decrypt($input = null)
    {
        if (! $input) {
            throw new \InvalidArgumentException('input is a required argument');
        }

        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->securekey, $this->base64safeDecode($input), MCRYPT_MODE_ECB, $this->iv));
    }

    private function base64safeEncode($input = null)
    {
        if (! $input) {
            throw new \InvalidArgumentException('input is a required argument');
        }

        return rtrim(strtr(base64_encode($input), '+/', '-_'), '=');
    }

    private function base64safeDecode($input = null)
    {
        if (! $input) {
            throw new \InvalidArgumentException('input is a required argument');
        }

        return base64_decode(str_pad(strtr($input, '-_', '+/'), strlen($input) % 4, '=', STR_PAD_RIGHT));
    }
}
