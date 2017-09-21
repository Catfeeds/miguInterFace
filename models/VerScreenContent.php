<?php

/**
 * This is the model class for table "{{ver_screen_content}}".
 *
 * The followings are the available columns in table '{{ver_screen_content}}':
 * @property integer $id
 * @property string $title
 * @property string $type
 * @property string $tType
 * @property string $param
 * @property string $action
 * @property string $pic
 * @property string $cp
 * @property string $epg
 * @property integer $addTime
 * @property integer $upTime
 * @property integer $screenGuideid
 * @property string $cid
 * @property integer $width
 * @property integer $height
 * @property string $x
 * @property string $y
 * @property integer $delFlag
 * @property integer $order
 * @property string $uType
 */
class VerScreenContent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ver_screen_content}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('addTime, upTime, screenGuideid, width, height, delFlag, order', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>300),
			array('type, tType', 'length', 'max'=>5),
			array('param', 'length', 'max'=>200),
			array('action', 'length', 'max'=>255),
			array('pic', 'length', 'max'=>600),
			array('cp', 'length', 'max'=>2),
			array('epg', 'length', 'max'=>1),
			array('cid', 'length', 'max'=>50),
			array('x, y, uType', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, type, tType, param, action, pic, cp, epg, addTime, upTime, screenGuideid, cid, width, height, x, y, delFlag, order, uType', 'safe', 'on'=>'search'),
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
			'title' => '����',
			'type' => 'ͼƬ���� 1��Сͼ��99����ͼ',
			'tType' => '�ϴ�����',
			'param' => '��תʱ���Ĳ���',
			'action' => '��ת��action��',
			'pic' => 'ͼƬ��ַ',
			'cp' => '���շ�',
			'epg' => '�����ʶ',
			'addTime' => '���ʱ��',
			'upTime' => '����ʱ��',
			'screenGuideid' => '����id',
			'cid' => 'Cid',
			'width' => '��С��Ԫ���',
			'height' => '��С��Ԫ���',
			'x' => '�������ԭ���X����',
			'y' => '�������ԭ���Y����',
			'delFlag' => '����״̬1����,0������',
			'order' => 'ǰ����ʾ��������',
			'uType' => 'U Type',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('tType',$this->tType,true);
		$criteria->compare('param',$this->param,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('cp',$this->cp,true);
		$criteria->compare('epg',$this->epg,true);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('upTime',$this->upTime);
		$criteria->compare('screenGuideid',$this->screenGuideid);
		$criteria->compare('cid',$this->cid,true);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('x',$this->x,true);
		$criteria->compare('y',$this->y,true);
		$criteria->compare('delFlag',$this->delFlag);
		$criteria->compare('order',$this->order);
		$criteria->compare('uType',$this->uType,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VerScreenContent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

