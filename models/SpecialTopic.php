<?php

/**
 * This is the model class for table "{{special_topic}}".
 *
 * The followings are the available columns in table '{{special_topic}}':
 * @property string $id
 * @property string $title
 * @property integer $type
 * @property integer $tType
 * @property integer $uType
 * @property string $action
 * @property string $param
 * @property string $cid
 * @property string $x
 * @property string $y
 * @property string $width
 * @property string $height
 * @property integer $order
 * @property string $videoUrl
 * @property string $sid
 * @property string $picSrc
 */
class SpecialTopic extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{special_topic}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, type, tType, x, y, width, height, order, sid, picSrc', 'required'),
			array('type, tType, uType, order', 'numerical', 'integerOnly'=>true),
			array('title, action, param, cid, x, y, width, height, videoUrl, picSrc', 'length', 'max'=>255),
			array('sid', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, type, tType, uType, action, param, cid, x, y, width, height, order, videoUrl, sid, picSrc', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
			'tType' => 'T Type',
			'uType' => 'U Type',
			'action' => 'Action',
			'param' => 'Param',
			'cid' => 'Cid',
			'x' => 'X',
			'y' => 'Y',
			'width' => 'Width',
			'height' => 'Height',
			'order' => 'Order',
			'videoUrl' => 'Video Url',
			'sid' => 'Sid',
			'picSrc' => 'Pic Src',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('tType',$this->tType);
		$criteria->compare('uType',$this->uType);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('param',$this->param,true);
		$criteria->compare('cid',$this->cid,true);
		$criteria->compare('x',$this->x,true);
		$criteria->compare('y',$this->y,true);
		$criteria->compare('width',$this->width,true);
		$criteria->compare('height',$this->height,true);
		$criteria->compare('order',$this->order);
		$criteria->compare('videoUrl',$this->videoUrl,true);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('picSrc',$this->picSrc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SpecialTopic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

