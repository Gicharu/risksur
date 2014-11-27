<?php

require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'phpmailer/JPhpMailer.php';

/**
 * TTMailer
 *
 * @uses CApplicationComponent
 * @package
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com>
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class TTMailer extends CApplicationComponent {

	public $resources = array();

	const LOG_CAT = "extensions.TTMailer";

	/* public $toAddress;
	  public $toName;
	  public $Subject;
	  public $AltBody;
	  public $Message; */

	/**
	 * __construct
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
	}

	/**
	 * ttSendMail
	 *
	 * @param mixed   $subject
	 * @param mixed   $altBody
	 * @param mixed   $message
	 * @param mixed   $toAddress
	 * @param mixed   $toName
	 * @access public
	 * @return void
	 */
	public function ttSendMail($subject, $altBody, $message, $toAddress, $toName) {
		$mailResource = Yii::app()->mailresource;
		$mailResource->resources['Host'] = Yii::app()->params->mail['host'];
		$mailResource->resources['SMTPAuth'] = Yii::app()->params->mail['smtpauth'];
		$mailResource->resources['Username'] = Yii::app()->params->mail['username'];
		$mailResource->resources['Password'] = Yii::app()->params->mail['password'];
		$mailResource->resources['Port'] = Yii::app()->params->mail['port'];
		$mailResource->resources['From'] = Yii::app()->params->mail['from'];
		$mailResource->resources['FromName'] = Yii::app()->params->mail['fromname'];
		$mailResource->resources['CharSet'] = Yii::app()->params->mail['charset'];
		$mailResource->resources['SMTPSecure'] = Yii::app()->params->mail['smtpsecure'];

		$phpMailer = new JPhpMailer();
		foreach ($mailResource->resources as $mailVar => $value) {
			$phpMailer->{ $mailVar } = $value;
		}
		$phpMailer->Subject = $subject;
		$phpMailer->AltBody = $altBody;
		$phpMailer->MsgHTML($message);
		$phpMailer->AddAddress($toAddress, $toName);
		$phpMailer->SetFrom($phpMailer->From, $phpMailer->FromName);
		$phpMailer->IsSMTP();
		if (!$phpMailer->Send()) {
			Yii::log("Mail cannot be sent, check whether a mail agent is installed", "error", self::LOG_CAT);
			return false;
		}

		return true;
	}

}

?>
