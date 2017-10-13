<?php
/*this is the model class for table "{{mv_userrecord}}".
 *
 * The followings are the available columns in table '{{mv_userrecord}}':
 * @property string $id
 * @property string $adminId
 * @property string $type
 * @property string $recordType
 * @property string $content
 * @property string $recordName
 * @property string $userId
 * @property string $addTime
 */
class MvUserrecord extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mv_userrecord}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('adminId, type, recordType, recordName, userId, addTime', 'required'),
			array('adminId, userId', 'length', 'max'=>10),
			array('type, recordType, recordName', 'length', 'max'=>30),
			array('addTime', 'length', 'max'=>11),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, adminId, type, recordType, content, recordName, userId, addTime', 'safe', 'on'=>'search'),
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
			'adminId' => 'Admin',
			'type' => 'Type',
			'recordType' => 'Record Type',
			'content' => 'Content',
			'recordName' => 'Record Name',
			'userId' => 'User',
			'addTime' => 'Add Time',
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
		$criteria->compare('adminId',$this->adminId,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('recordType',$this->recordType,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('recordName',$this->recordName,true);
		$criteria->compare('userId',$this->userId,true);
		$criteria->compare('addTime',$this->addTime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MvUserrecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

