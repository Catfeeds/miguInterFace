<?php

/**
 * This is the model class for table "{{wx_userversion}}".
 *
 * The followings are the available columns in table '{{wx_userversion}}':
 * @property string $id
 * @property string $xmpp
 * @property string $province
 * @property string $city
 * @property string $stbid
 * @property string $cTime
 * @property integer $cp
 * @property string $vname
 * @property integer $flag
 */
class WxUserversion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{wx_userversion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('xmpp, province, city, stbid, cTime, cp, flag', 'required'),
			array('cp, flag', 'numerical', 'integerOnly'=>true),
			array('xmpp, stbid, vname', 'length', 'max'=>100),
			array('province', 'length', 'max'=>2),
			array('city', 'length', 'max'=>5),
			array('cTime', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, xmpp, province, city, stbid, cTime, cp, vname, flag', 'safe', 'on'=>'search'),
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
			'xmpp' => 'Xmpp',
			'province' => 'Province',
			'city' => 'City',
			'stbid' => 'Stbid',
			'cTime' => 'C Time',
			'cp' => 'Cp',
			'vname' => '标题',
			'flag' => 'Flag',
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
		$criteria->compare('xmpp',$this->xmpp,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('stbid',$this->stbid,true);
		$criteria->compare('cTime',$this->cTime,true);
		$criteria->compare('cp',$this->cp);
		$criteria->compare('vname',$this->vname,true);
		$criteria->compare('flag',$this->flag);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WxUserversion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

