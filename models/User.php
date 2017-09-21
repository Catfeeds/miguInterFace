<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property string $id
 * @property string $name
 * @property string $stbid
 * @property string $type
 * @property string $province
 * @property string $city
 * @property string $cp
 * @property string $group
 * @property string $pay
 * @property string $mobileUser
 * @property string $mobileDevice
 * @property string $delFlag
 * @property string $cTime
 * @property string $epgcode
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, stbid, type, province, city, cp, group, pay, cTime', 'required'),
			array('name, type, pay', 'length', 'max'=>50),
			array('stbid', 'length', 'max'=>40),
			array('province', 'length', 'max'=>2),
			array('city', 'length', 'max'=>5),
			array('cp, delFlag', 'length', 'max'=>1),
			array('group, mobileUser, mobileDevice', 'length', 'max'=>20),
			array('cTime', 'length', 'max'=>11),
			array('epgcode', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, stbid, type, province, city, cp, group, pay, mobileUser, mobileDevice, delFlag, cTime, epgcode', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'stbid' => 'Stbid',
			'type' => 'Type',
			'province' => 'Province',
			'city' => 'City',
			'cp' => 'Cp',
			'group' => 'Group',
			'pay' => 'Pay',
			'mobileUser' => 'Mobile User',
			'mobileDevice' => 'Mobile Device',
			'delFlag' => 'Del Flag',
			'cTime' => 'C Time',
			'epgcode' => 'Epgcode',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('stbid',$this->stbid,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('cp',$this->cp,true);
		$criteria->compare('group',$this->group,true);
		$criteria->compare('pay',$this->pay,true);
		$criteria->compare('mobileUser',$this->mobileUser,true);
		$criteria->compare('mobileDevice',$this->mobileDevice,true);
		$criteria->compare('delFlag',$this->delFlag,true);
		$criteria->compare('cTime',$this->cTime,true);
		$criteria->compare('epgcode',$this->epgcode,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

