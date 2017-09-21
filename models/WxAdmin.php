<?php

/**
 * This is the model class for table "{{wx_admin}}".
 *
 * The followings are the available columns in table '{{wx_admin}}':
 * @property integer $id
 * @property string $nickname
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $auth
 * @property integer $addTime
 * @property integer $upTime
 */
class WxAdmin extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{wx_admin}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('auth, addTime, upTime', 'numerical', 'integerOnly'=>true),
            array('nickname, username', 'length', 'max'=>20),
            array('password', 'length', 'max'=>32),
            array('email', 'length', 'max'=>30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nickname, username, password, email, auth, addTime, upTime', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'nickname' => '昵称',
            'username' => '用户名',
            'password' => '密码',
            'email' => '用户邮箱',
            'auth' => '权限组',
            'addTime' => '添加时间',
            'upTime' => '修改时间',
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('nickname',$this->nickname,true);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('auth',$this->auth);
        $criteria->compare('addTime',$this->addTime);
        $criteria->compare('upTime',$this->upTime);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return WxAdmin the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}