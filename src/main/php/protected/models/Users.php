<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 *
 * @property string $userId
 * @property string $userName
 * @property string $password
 * @property string $email
 * @property integer $active
 * @property integer $passReset
 * @property string $cookie
 * @property string $session
 * @property string $ip
 *
 * The followings are the available model relations:
 * @property Branches[] $branches
 * @property Branchtags[] $branchtags
 * @property Categories[] $categories
 * @property Fields[] $fields
 * @property Fieldtypes[] $fieldtypes
 * @property Nodes[] $nodes
 * @property Tags[] $tags
 * @property Tools[] $tools
 * @property Tooltags[] $tooltags
 */
class Users extends CActiveRecord {

	public $salt = '#fxdHJ&^%DS';
	public $confirmPassword;
	/**
	 *
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'users';
	}

	/**
	 *
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array( 'active, passReset', 'numerical', 'integerOnly' => true ),
			array( 'userName', 'length', 'max' => 20 ),
			array( 'password, email, confirmPassword', 'length', 'max' => 40 ),
			array( 'cookie, session', 'length', 'max' => 32 ),
			array( 'ip', 'length', 'max' => 15 ),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array( 'userId, userName, password, email, active, passReset, cookie, session, ip', 'safe', 'on' => 'search' ),
		);
	}


	/**
	 *
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'userId' => 'User',
			'userName' => 'User Name',
			'password' => 'Password',
			'confirmPassword' => Yii::t("translation", "Re-Type Password"),
			'email' => 'Email',
			'active' => 'Active',
			'passReset' => 'Pass Reset',
			'cookie' => 'Cookie',
			'session' => 'Session',
			'ip' => 'Ip',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare( 'userId', $this->userId, true );
		$criteria->compare( 'userName', $this->userName, true );
		$criteria->compare( 'password', $this->password, true );
		$criteria->compare( 'email', $this->email, true );
		$criteria->compare( 'active', $this->active );
		$criteria->compare( 'passReset', $this->passReset );
		$criteria->compare( 'cookie', $this->cookie, true );
		$criteria->compare( 'session', $this->session, true );
		$criteria->compare( 'ip', $this->ip, true );

		return new CActiveDataProvider( $this, array(
				'criteria' => $criteria,
			) );
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string  $className active record class name.
	 * @return Users the static model class
	 */
	public static function model( $className = __CLASS__ ) {
		return parent::model( $className );
	}
	/**
	 * hashPassword
	 * @param string $password
	 * @param string $salt
	 * @return string
	 */
	public function hashPassword( $password, $salt ) {
		return md5( $salt . $password );
	}

	/**
	 * validatePassword
	 * @param  string $password
	 * @return bool
	 */
	public function validatePassword( $password ) {
		return $this->hashPassword( $password, $this->salt ) === $this->password;
	}

	/**
	 * beforeSave
	 * @return bool
	 */
	public function beforeSave() {
		$this->password = $this->hashPassword( $this->password, $this->salt );
		return parent::beforeSave();
	}
}
