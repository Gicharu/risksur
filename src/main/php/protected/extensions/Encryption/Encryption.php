<?php
DEFINE('ALGORITHM', MCRYPT_RIJNDAEL_128); // Encryption Algorithm
DEFINE('DEFAULT_SECONDS', -1);
DEFINE('DEFAULT_SALT', "TraceTrackerSuck");
DEFINE('DATE_DIVIDER', "__D__");
/**
 * Encryption 
 * 
 * @uses CApplicationComponent
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Eric Thuku <eric@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class Encryption extends CApplicationComponent {
	private $value;
	private $expiryTime;
	//public function __construct($value, $expiryTime = 0 ) {
	//$this->value = $value;
	//$this->expiryTime = $expiryTime;
	//}
	/**
	 * Get decrypted value.
	 *
	 * @return String.
	 */
	public function getValue() {
		return $this->value;
	}
	/**
	 * Check if descrypted value is expired.
	 *
	 * @return boolean
	 */
	public function isExpired() {
		//echo "expiry time: " . $this->expiryTime . "<br>" ;
		//echo "micro time: " . microtime(TRUE) * 1000 . "<br>" ;
		return isset($this->expiryTime) && $this->expiryTime < microtime(TRUE) * 1000;
	}
	/**
	 * encrypt 
	 * 
	 * @param mixed $string 
	 * @param int $expires 
	 * @param mixed $salt 
	 * @access public
	 * @return void
	 */
	public function encrypt($string, $expires = 0, $salt = DEFAULT_SALT) {
		if ($expires > 0) {
			$string .= DATE_DIVIDER . ((((int)microtime(TRUE)) * 1000) + ($expires * 1000));
		}
		// Encrypt $string
		$encrypted_string = mcrypt_encrypt(ALGORITHM, $salt, $string, MCRYPT_MODE_CBC, $salt);
		return base64_encode($encrypted_string);
	}
	/**
	 * decrypt 
	 * 
	 * @param mixed $string 
	 * @param mixed $salt 
	 * @access public
	 * @return void
	 */
	public function decrypt($string, $salt = DEFAULT_SALT) {
		$decrypted_string = mcrypt_decrypt(ALGORITHM, $salt, base64_decode($string), MCRYPT_MODE_CBC, $salt);
		// Remove padding
		while (ord(substr($decrypted_string, -1)) == 0) {
			$decrypted_string = substr($decrypted_string, 0, strlen($decrypted_string) - 1);
		}
		// Check if String contains date divider. If so, validate expiry!
		$dateIndex = strpos($decrypted_string, DATE_DIVIDER);
		$this->expiryTime = NULL;
		$this->value = $decrypted_string;
		if ($dateIndex) {
			$this->expiryTime = substr($this->value, $dateIndex + strlen(DATE_DIVIDER));
			$this->value = substr($this->value, 0, $dateIndex);
		}
		return $this->value; //new TTixResourceEncryption( $value, $expiryTime );
		
	}
}
?>

