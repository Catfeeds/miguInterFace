<?php

/**
 * This is the model class for table "{{wx_app}}".
 *
 * The followings are the available columns in table '{{wx_app}}':
 * @property integer $id
 * @property string $name
 * @property string $creatorName
 * @property string $description
 * @property string $imageUrl
 * @property string $type
 * @property string $size
 * @property string $downloadUrl
 * @property integer $addTime
 * @property integer $appid
 * @property string $packageName
 * @property string $version
 * @property string $action
 * @property string $param
 * @property integer $tType
 */
class WxApp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{wx_app}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('addTime, appid, tType', 'numerical', 'integerOnly'=>true),
			array('name, type', 'length', 'max'=>100),
			array('creatorName, downloadUrl, packageName, action', 'length', 'max'=>255),
			array('description, imageUrl, param', 'length', 'max'=>600),
			array('size', 'length', 'max'=>20),
			array('version', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, creatorName, description, imageUrl, type, size, downloadUrl, addTime, appid, packageName, version, action, param, tType', 'safe', 'on'=>'search'),
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
			'name' => '片名',
			'creatorName' => '演员',
			'description' => '简介',
			'imageUrl' => '图片',
			'type' => '上传类型',
			'size' => '分类',
			'downloadUrl' => '跳转的action',
			'addTime' => '添加时间',
			'appid' => 'Appid',
			'packageName' => 'Package Name',
			'version' => '版本号',
			'action' => '跳转的action',
			'param' => 'Param',
			'tType' => 'T Type',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('creatorName',$this->creatorName,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('imageUrl',$this->imageUrl,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('downloadUrl',$this->downloadUrl,true);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('appid',$this->appid);
		$criteria->compare('packageName',$this->packageName,true);
		$criteria->compare('version',$this->version,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('param',$this->param,true);
		$criteria->compare('tType',$this->tType);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WxApp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

