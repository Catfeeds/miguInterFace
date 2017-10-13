<?php

/**
 * This is the model class for table "{{mv_user}}".
 *
 * The followings are the available columns in table '{{mv_user}}':
 * @property string $id
 * @property integer $uid
 * @property string $delFlag
 * @property string $cTime
 * @property string $vname
 * @property string $province
 */
class MvUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mv_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, cTime, vname', 'required'),
			array('uid', 'numerical', 'integerOnly'=>true),
			array('delFlag', 'length', 'max'=>1),
			array('cTime', 'length', 'max'=>11),
			array('vname', 'length', 'max'=>50),
			array('province', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, uid, delFlag, cTime, vname, province', 'safe', 'on'=>'search'),
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
			'uid' => 'Uid',
			'delFlag' => 'Del Flag',
			'cTime' => 'C Time',
			'vname' => 'Vname',
			'province' => '省份名称',
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
		$criteria->compare('uid',$this->uid);
		$criteria->compare('delFlag',$this->delFlag,true);
		$criteria->compare('cTime',$this->cTime,true);
		$criteria->compare('vname',$this->vname,true);
		$criteria->compare('province',$this->province,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MvUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

