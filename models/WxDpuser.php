<?php

/**
 * This is the model class for table "{{wx_dpuser}}".
 *
 * The followings are the available columns in table '{{wx_dpuser}}':
 * @property string $id
 * @property string $cid
 * @property string $type
 * @property string $province
 * @property string $city
 * @property string $cp
 * @property string $stbid
 * @property string $cTime
 * @property string $typeName
 * @property string $title
 */
class WxDpuser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{wx_dpuser}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cid, type, province, city, cp, stbid, cTime, typeName', 'required'),
			array('cid', 'length', 'max'=>10),
			array('type, province, cp', 'length', 'max'=>20),
			array('city', 'length', 'max'=>5),
			array('stbid, title', 'length', 'max'=>100),
			array('cTime', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cid, type, province, city, cp, stbid, cTime, typeName, title', 'safe', 'on'=>'search'),
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
			'cid' => 'Cid',
			'type' => 'Type',
			'province' => 'Province',
			'city' => 'City',
			'cp' => 'Cp',
			'stbid' => 'Stbid',
			'cTime' => 'C Time',
			'typeName' => 'Type Name',
			'title' => '标题',
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
		$criteria->compare('cid',$this->cid,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('cp',$this->cp,true);
		$criteria->compare('stbid',$this->stbid,true);
		$criteria->compare('cTime',$this->cTime,true);
		$criteria->compare('typeName',$this->typeName,true);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WxDpuser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

