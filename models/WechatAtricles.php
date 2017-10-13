<?php

/**
 * This is the model class for table "{{wechat_atricles}}".
 *
 * The followings are the available columns in table '{{wechat_atricles}}':
 * @property string $atr_id
 * @property string $title
 * @property string $digest
 * @property string $thumb_media_id
 * @property string $author
 * @property integer $show_cover_pic
 * @property string $content
 * @property string $content_source_url
 * @property string $thumb_url
 * @property string $data_type
 * @property integer $data_status
 * @property string $create_time
 * @property string $update_time
 */
class WechatAtricles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{wechat_atricles}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('show_cover_pic, data_status', 'numerical', 'integerOnly'=>true),
			array('title, thumb_media_id, author, content_source_url, thumb_url', 'length', 'max'=>255),
			array('data_type', 'length', 'max'=>32),
			array('create_time, update_time', 'length', 'max'=>11),
			array('digest, content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('atr_id, title, digest, thumb_media_id, author, show_cover_pic, content, content_source_url, thumb_url, data_type, data_status, create_time, update_time', 'safe', 'on'=>'search'),
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
			'atr_id' => 'Atr',
			'title' => 'Title',
			'digest' => 'Digest',
			'thumb_media_id' => 'Thumb Media',
			'author' => 'Author',
			'show_cover_pic' => 'Show Cover Pic',
			'content' => 'Content',
			'content_source_url' => 'Content Source Url',
			'thumb_url' => 'Thumb Url',
			'data_type' => 'Data Type',
			'data_status' => 'Data Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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

		$criteria->compare('atr_id',$this->atr_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('digest',$this->digest,true);
		$criteria->compare('thumb_media_id',$this->thumb_media_id,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('show_cover_pic',$this->show_cover_pic);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('content_source_url',$this->content_source_url,true);
		$criteria->compare('thumb_url',$this->thumb_url,true);
		$criteria->compare('data_type',$this->data_type,true);
		$criteria->compare('data_status',$this->data_status);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WechatAtricles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
