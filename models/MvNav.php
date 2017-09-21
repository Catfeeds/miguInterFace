<?php

/**
 * This is the model class for table "{{mv_nav}}".
 *
 * The followings are the available columns in table '{{mv_nav}}':
 * @property string $id
 * @property string $gid
 * @property string $province
 * @property string $city
 * @property string $cp
 * @property string $usergroup
 * @property string $epgcode
 */
class MvNav extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mv_nav}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gid, province, city', 'required'),
			array('gid', 'length', 'max'=>11),
			array('province', 'length', 'max'=>5),
			array('city', 'length', 'max'=>10),
			array('cp', 'length', 'max'=>2),
			array('usergroup, epgcode', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gid, province, city, cp, usergroup, epgcode', 'safe', 'on'=>'search'),
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
			'gid' => 'Gid',
			'province' => 'Province',
			'city' => 'City',
			'cp' => 'Cp',
			'usergroup' => 'Usergroup',
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
		$criteria->compare('gid',$this->gid,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('cp',$this->cp,true);
		$criteria->compare('usergroup',$this->usergroup,true);
		$criteria->compare('epgcode',$this->epgcode,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MvNav the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

