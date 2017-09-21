<?php

/**
 * This is the model class for table "{{ver_wall}}".
 *
 * The followings are the available columns in table '{{ver_wall}}':
 * @property integer $id
 * @property string $title
 * @property string $pic
 * @property string $thum
 * @property string $province
 * @property string $city
 * @property integer $addTime
 * @property string $userGroup
 * @property string $epgCode
 */
class VerWall extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ver_wall}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, pic, thum', 'required'),
			array('addTime', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>50),
			array('pic, thum', 'length', 'max'=>200),
			array('province, city', 'length', 'max'=>100),
			array('userGroup, epgCode', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, pic, thum, province, city, addTime, userGroup, epgCode', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'pic' => 'Pic',
			'thum' => 'Thum',
			'province' => 'ʡ',
			'city' => 'City',
			'addTime' => 'Add Time',
			'userGroup' => 'User Group',
			'epgCode' => 'Epg Code',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('thum',$this->thum,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('userGroup',$this->userGroup,true);
		$criteria->compare('epgCode',$this->epgCode,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VerWall the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

