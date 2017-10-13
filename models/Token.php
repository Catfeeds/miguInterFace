<?php

/**
 * This is the model class for table "{{token}}".
 *
 * The followings are the available columns in table '{{token}}':
 * @property integer $id
 * @property string $token
 * @property integer $uid
 * @property string $bulletin
 * @property string $reToken
 * @property integer $start
 * @property integer $end
 * @property integer $addTime
 * @property integer $upTime
 */
class Token extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{token}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, start, end, addTime, upTime', 'numerical', 'integerOnly'=>true),
			array('token, reToken', 'length', 'max'=>32),
			array('bulletin', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, token, uid, bulletin, reToken, start, end, addTime, upTime', 'safe', 'on'=>'search'),
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
			'token' => 'Token',
			'uid' => 'Uid',
			'bulletin' => 'Bulletin',
			'reToken' => 'Re Token',
			'start' => 'Start',
			'end' => 'End',
			'addTime' => 'Add Time',
			'upTime' => 'Up Time',
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
		$criteria->compare('token',$this->token,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('bulletin',$this->bulletin,true);
		$criteria->compare('reToken',$this->reToken,true);
		$criteria->compare('start',$this->start);
		$criteria->compare('end',$this->end);
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
	 * @return Token the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
