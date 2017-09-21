<?php

/**
 * This is the model class for table "{{wx_version}}".
 *
 * The followings are the available columns in table '{{wx_version}}':
 * @property string $id
 * @property string $app
 * @property string $version
 * @property string $verStr
 * @property string $pname
 * @property string $path
 * @property string $per
 * @property string $size
 * @property string $delFlag
 * @property string $cTime
 */
class WxVersion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{wx_version}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('app, version, verStr, pname, path, per, size, cTime', 'required'),
			array('app, version, size', 'length', 'max'=>10),
			array('verStr', 'length', 'max'=>15),
			array('pname', 'length', 'max'=>80),
			array('path', 'length', 'max'=>150),
			array('per', 'length', 'max'=>255),
			array('delFlag', 'length', 'max'=>1),
			array('cTime', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, app, version, verStr, pname, path, per, size, delFlag, cTime', 'safe', 'on'=>'search'),
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
			'app' => 'App',
			'version' => 'Version',
			'verStr' => 'Ver Str',
			'pname' => 'Pname',
			'path' => 'Path',
			'per' => 'Per',
			'size' => 'Size',
			'delFlag' => 'Del Flag',
			'cTime' => 'C Time',
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
		$criteria->compare('app',$this->app,true);
		$criteria->compare('version',$this->version,true);
		$criteria->compare('verStr',$this->verStr,true);
		$criteria->compare('pname',$this->pname,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('per',$this->per,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('delFlag',$this->delFlag,true);
		$criteria->compare('cTime',$this->cTime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WxVersion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

