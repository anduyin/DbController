<?php
//专门用于普惠接口的加密类
class OpenSSLAES
{
	/**
	 * var string $method 加解密方法，可通过openssl_get_cipher_methods()获得
	 */
	protected $method;

	/**
	 * var string $secret_key 加解密的密钥
	 */
	protected $secret_key;

	/**
	 * var string $iv 加解密的向量，有些方法需要设置比如CBC
	 */
	protected $iv;

	/**
	 * var string $options （不知道怎么解释，目前设置为0没什么问题）
	 */
	protected $options;

	/**
	 * 构造函数
	 *
	 * @param string $key 密钥
	 * @param string $method 加密方式
	 * @param string $iv iv向量
	 * @param mixed $options 
	 *
	 */
	public function __construct($key = 'IHRHGBLK7SJASFTT', $method = 'AES-128-ECB', $iv = '', $options = 0)
	{
		// key是必须要设置的
		$this->secret_key = isset($key) ? $key : exit('key为必须项');

		$this->method = $method;

		$this->iv = $iv;

		$this->options = $options;
	}

	/**
	 * 加密方法，对数据进行加密，返回加密后的数据
	 *
	 * @param string $data 要加密的数据
	 *
	 * @return string
	 *
	 */
	public function encrypt($data)
	{
		return openssl_encrypt($data, $this->method, $this->secret_key, $this->options, $this->iv);
	}

	/**
	 * 解密方法，对数据进行解密，返回解密后的数据
	 *
	 * @param string $data 要解密的数据
	 *
	 * @return string
	 *
	 */
	public function decrypt($data)
	{
		return openssl_decrypt($data, $this->method, $this->secret_key, $this->options, $this->iv);
	}
}
/* $str = "{\"telno\":\"15208999843\",\"real\": 1,\"sesame\": 1,\"family\": 1,\"work\": 1,\"rong360\": 1,\"mail\": 1,\"tongdun\": 1}";
$key = "IHRHGBLK7SJASFTT";
$s = new OpenSSLAES($key);
echo $d = $s->encrypt($str); */
