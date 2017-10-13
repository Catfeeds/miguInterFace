<?php
/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/5 0005
 * Time: 9:01
 */

class WxAdminForm extends CFormModel
{
    public $username;
    public $password;
    public $code;

    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('username, code, password', 'required'),
            array('code', 'CheckCode'),
            array('password','authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'rememberMe'=>'Remember me next time',
        );
    }

    public function CheckCode(){
        if(!Verification::check($this->code)){
            throw new ExceptionEx('验证码错误');
        }
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            $this->_identity=new UserIdentity($this->username,$this->password);
            if(!$this->_identity->authenticates()){
                switch($this->_identity->errorCode){
                    case 1:
                        throw new ExceptionEx('用户不存在');
                        break;
                    case 2:
                        throw new ExceptionEx('用户/密码错误');
                        break;
                    default:
                        throw new ExceptionEx('未知错误');
                        break;
                }
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if($this->_identity===null)
        {
            $this->_identity=new UserIdentity($this->username,$this->password);
            $this->_identity->authenticates();
        }
        if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
        {
            $duration= 3600; // 30 days
            Yii::app()->user->login($this->_identity,$duration);
            return true;
        }
        else
            return false;
    }
}
