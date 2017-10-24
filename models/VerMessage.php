<?php

/**
 * This is the model class for table "{{ver_message}}".
 *
 * The followings are the available columns in table '{{ver_message}}':
 * @property string $id
 * @property string $vid
 * @property string $type
 * @property string $param
 * @property string $action
 * @property string $url
 * @property string $info
 * @property string $cTime
 * @property string $pic
 * @property string $firstTime
 * @property string $endTime
 * @property string $title
 * @property string $cp
 * @property string $gid
 * @property string $uType
 * @property integer $flag
 * @property integer $workid
 * @property integer $delFlag
 */
class VerMessage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ver_message}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, info', 'required'),
			array('flag, workid, delFlag', 'numerical', 'integerOnly'=>true),
			array('vid', 'length', 'max'=>30),
			array('type, gid, uType', 'length', 'max'=>20),
			array('param, action, url', 'length', 'max'=>300),
			array('cTime', 'length', 'max'=>11),
			array('pic, firstTime, endTime, title', 'length', 'max'=>255),
			array('cp', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vid, type, param, action, url, info, cTime, pic, firstTime, endTime, title, cp, gid, uType, flag, workid, delFlag', 'safe', 'on'=>'search'),
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
			'vid' => 'Vid',
			'type' => 'Type',
			'param' => 'Param',
			'action' => 'Action',
			'url' => 'Url',
			'info' => '信息',
			'cTime' => '添加时间',
			'pic' => 'Pic',
			'firstTime' => 'First Time',
			'endTime' => 'End Time',
			'title' => 'Title',
			'cp' => '牌照方',
			'gid' => 'Gid',
			'uType' => 'U Type',
			'flag' => 'Flag',
			'workid' => 'Workid',
			'delFlag' => '删除标识 delFlag=1并且flag=6删除成功',
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
		$criteria->compare('vid',$this->vid,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('param',$this->param,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('cTime',$this->cTime,true);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('firstTime',$this->firstTime,true);
		$criteria->compare('endTime',$this->endTime,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('cp',$this->cp,true);
		$criteria->compare('gid',$this->gid,true);
		$criteria->compare('uType',$this->uType,true);
		$criteria->compare('flag',$this->flag);
		$criteria->compare('workid',$this->workid);
		$criteria->compare('delFlag',$this->delFlag);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VerMessage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

