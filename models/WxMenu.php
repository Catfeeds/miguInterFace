<?php

/**
 * This is the model class for table "{{wx_menu}}".
 *
 * The followings are the available columns in table '{{wx_menu}}':
 * @property integer $id
 * @property integer $father_id
 * @property string $title
 * @property string $description
 * @property string $url
 * @property string $btn_key
 * @property string $media_id
 * @property integer $data_sort
 * @property string $data_type
 * @property integer $data_status
 * @property integer $create_time
 * @property integer $update_time
 * @property string $ChildrenList
 * @property string $MaterialTitle
 * @property string $state
 */
class WxMenu extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{wx_menu}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('father_id, data_sort, data_status, create_time, update_time', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>24),
			array('description, data_type, ChildrenList, MaterialTitle', 'length', 'max'=>32),
			array('url', 'length', 'max'=>255),
			array('btn_key, media_id', 'length', 'max'=>128),
			array('state', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, father_id, title, description, url, btn_key, media_id, data_sort, data_type, data_status, create_time, update_time, ChildrenList, MaterialTitle, state', 'safe', 'on'=>'search'),
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
			'father_id' => 'Father',
			'title' => 'Title',
			'description' => 'Description',
			'url' => 'Url',
			'btn_key' => 'Btn Key',
			'media_id' => 'Media',
			'data_sort' => 'Data Sort',
			'data_type' => 'Data Type',
			'data_status' => 'Data Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'ChildrenList' => 'Children List',
			'MaterialTitle' => 'Material Title',
			'state' => 'State',
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
		$criteria->compare('father_id',$this->father_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('btn_key',$this->btn_key,true);
		$criteria->compare('media_id',$this->media_id,true);
		$criteria->compare('data_sort',$this->data_sort);
		$criteria->compare('data_type',$this->data_type,true);
		$criteria->compare('data_status',$this->data_status);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('ChildrenList',$this->ChildrenList,true);
		$criteria->compare('MaterialTitle',$this->MaterialTitle,true);
		$criteria->compare('state',$this->state,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WxMenu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
