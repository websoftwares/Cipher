<?php

use Websoftwares\Cipher;

class CipherTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->securekey = '4s05Gim69k6Cn7E4Wl03cEI5v9K49l95';
        $size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CFB);
        $this->iv = mcrypt_create_iv($size, MCRYPT_DEV_URANDOM);

        $this->lorem = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere, enim non rutrum ullamcorper, nisi dui faucibus enim, quis feugiat risus risus sollicitudin est. Fusce et sem a ligula mattis laoreet id nec leo. Aenean vitae sagittis mi. Integer sapien sem, sagittis sit amet facilisis vitae, congue et arcu. Aenean pretium iaculis placerat. Fusce rhoncus congue lacinia. Integer dictum dictum velit, quis accumsan mi iaculis in. Suspendisse id tortor placerat nibh bibendum tempor sit amet quis ipsum. In aliquet suscipit augue, id consequat est elementum non. Donec eu ligula a ipsum ornare scelerisque tempor nec augue.";
        $this->cipher = new Cipher($this->securekey, $this->iv);
    }

    public function testInstantiateAsObjectSucceeds()
    {
        $this->assertInstanceOf('Websoftwares\Cipher', $this->cipher);
    }

    public function testHasAttributeSucceeds()
    {
        $this->assertObjectHasAttribute('securekey', $this->cipher);
        $this->assertObjectHasAttribute('iv', $this->cipher);
    }

    public function testPropertyValuesSucceeds()
    {
        $cipher = new ReflectionClass($this->cipher);

        foreach ($cipher->getProperties() as $property) {

            $property->setAccessible(true);
            $propertyName = $property->name;
            $this->assertEquals($this->$propertyName, $property->getValue($this->cipher));
        }
    }

    public function testEncryptDecryptSucceeds()
    {
        $encrypted = $this->cipher->encrypt($this->lorem);
        $this->cipher->decrypt($encrypted);
        $this->assertEquals($this->lorem,$this->cipher->decrypt($encrypted));
    }

    public function testEncryptDecryptFailsWrongSecurekey()
    {
        $encrypted = $this->cipher->encrypt($this->lorem);
        $cipher = new Cipher('f9tsChD5vy6NdN8093D3zPjfbeR83t30', $this->iv);
        $this->assertNotEquals($this->lorem,$cipher->decrypt($encrypted));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentExceptionEncrypt()
    {
         $this->cipher->encrypt();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentExceptionDecrypt()
    {
         $this->cipher->decrypt();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentExceptionConstructor()
    {
         new Cipher();
    }
}
