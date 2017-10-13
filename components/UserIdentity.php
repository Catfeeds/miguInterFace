<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $name;
	private $pass;

	public function __construct($name, $pass)
	{
		if (!empty($name)) $this->name = $name;
		if (!empty($pass)) $this->pass = $pass;
	}

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$users = AdminManager::getAdmin($this->name);
		if (!$users) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} elseif ($users['password'] !== $this->pass) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else {
			unset($users['password']);
			Yii::app()->user->setState('admin',$users);
			$this->errorCode = self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
	public function authenticates()
    	{
        $users = WxAdminManager::getAdmin($this->name);
        if (!$users) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif ($users->password !== md5($this->pass)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            unset($users->password);
            Yii::app()->user->setState('admin',$users->getAttributes());
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }
    public function authenticatess()
    {
        $users = MvAdminManager::getAdmin($this->name);
        if (!$users) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif ($users->password !== $this->pass) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            unset($users->password);
            Yii::app()->user->setState('admin',$users->getAttributes());
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }
}
