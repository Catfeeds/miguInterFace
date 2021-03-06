<?php

/**
 * This is the model class for table "{{ver_sitelist}}".
 *
 * The followings are the available columns in table '{{ver_sitelist}}':
 * @property integer $id
 * @property integer $pid
 * @property string $module
 * @property string $name
 * @property string $url
 * @property integer $order
 * @property integer $addTime
 * @property string $type
 * @property string $protype
 * @property string $xyType
 */
class VerSitelist extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ver_sitelist}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pid, order, addTime', 'numerical', 'integerOnly'=>true),
			array('module', 'length', 'max'=>50),
			array('name', 'length', 'max'=>100),
			array('url', 'length', 'max'=>200),
			array('type', 'length', 'max'=>30),
			array('protype', 'length', 'max'=>40),
			array('xyType', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pid, module, name, url, order, addTime, type, protype, xyType', 'safe', 'on'=>'search'),
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
			'pid' => 'Pid',
			'module' => 'Module',
			'name' => 'Name',
			'url' => 'Url',
			'order' => 'Order',
			'addTime' => 'Add Time',
			'type' => 'Type',
			'protype' => 'Protype',
			'xyType' => 'Xy Type',
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
		$criteria->compare('order',$this->order);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('protype',$this->protype,true);
		$criteria->compare('xyType',$this->xyType,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VerSitelist the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

