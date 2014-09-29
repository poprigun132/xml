<?php

namespace app\models;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
	public $id;
	public $username;
	public $password;
	public $authKey;
	public $accessToken;

	private static $users = [
		'100' => [
			'id' => '100',
			'username' => 'admin',
			'password' => 'admin',
			'authKey' => 'test100key',
			'accessToken' => '100-token',
		],
		'101' => [
			'id' => '101',
			'username' => 'demo',
			'password' => 'demo',
			'authKey' => 'test101key',
			'accessToken' => '101-token',
		],
	];

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id)
	{
		$user = Users::find()->where(['id_user'=>$id] )->one();
		$_user = [
			'id'=>$user->id_user,
			'username'=>$user->login,
			'password'=>$user->password,
			'authKey'=>MD5($user->hash),
			'accessToken'=>$user->hash
		];
		return isset($_user) ? new static($_user) : null;
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		$user = Users::find()->where(['hash'=>$token] )->one();
		if(!empty($user)){
			return new static([
					'id'=>$user->id_user,
					'username'=>$user->login,
					'password'=>$user->password,
					'authKey'=>MD5($user->hash),
					'accessToken'=>$user->hash
				]);
		}

		return null;
	}

	/**
	 * Finds user by username
	 *
	 * @param  string      $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{

		$user = Users::find()->where(['login'=>$username] )->one();
		if( !empty($user) ){
			return new static([
					'id'=>$user->id_user,
					'username'=>$user->login,
					'password'=>$user->password,
					'authKey'=>MD5($user->hash),
					'accessToken'=>$user->hash
				]);
		}

		return null;
	}

	/**
	 * @inheritdoc
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey()
	{
		return $this->authKey;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey)
	{
		return $this->authKey === MD5($authKey);
	}

	/**
	 * Validates password
	 *
	 * @param  string  $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return $this->password === MD5($password);
	}
}
