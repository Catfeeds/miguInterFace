<?php

/**
 * This is the model class for table "{{guide}}".
 *
 * The followings are the available columns in table '{{guide}}':
 * @property integer $id
 * @property integer $pid
 * @property string $module
 * @property string $name
 * @property string $url
 * @property integer $uType
 * @property integer $status
 * @property integer $order
 * @property integer $addTime
 */
class Guide extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{guide}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pid, uType, status, order, addTime', 'numerical', 'integerOnly'=>true),
			array('module', 'length', 'max'=>50),
			array('name', 'length', 'max'=>100),
			array('url', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pid, module, name, url, uType, status, order, addTime', 'safe', 'on'=>'search'),
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
			'pid' => '父类',
			'module' => '所属模块',
			'name' => '导航名称',
			'url' => '地址',
			'uType' => '地址类型   1.本站   2.外链',
			'status' => '状态 1.正常  2.隐藏  3.删除',
			'order' => '排序',
			'addTime' => '添加时间',
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
		$criteria->compare('pid',$this->pid);
		$criteria->compare('module',$this->module,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('uType',$this->uType);
		$criteria->compare('status',$this->status);
		$criteria->compare('order',$this->order);
		$criteria->compare('addTime',$this->addTime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Guide the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
