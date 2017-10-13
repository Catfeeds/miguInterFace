<?php

/**
 * This is the model class for table "{{actor}}".
 *
 * The followings are the available columns in table '{{actor}}':
 * @property integer $vid
 * @property string $actor
 * @property string $sex
 * @property string $allName
 * @property string $superviser
 * @property string $background
 * @property string $director
 */
class Actor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{actor}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('actor, sex, allName, superviser, background, director', 'required'),
			array('vid', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('vid, actor, sex, allName, superviser, background, director', 'safe', 'on'=>'search'),
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
			'vid' => '视频主键',
			'actor' => '演员',
			'sex' => '性别',
			'allName' => '演员全名',
			'superviser' => '监制',
			'background' => '幕后人员',
			'director' => '导演',
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

		$criteria->compare('vid',$this->vid);
		$criteria->compare('actor',$this->actor,true);
		$criteria->compare('sex',$this->sex,true);
		$criteria->compare('allName',$this->allName,true);
		$criteria->compare('superviser',$this->superviser,true);
		$criteria->compare('background',$this->background,true);
		$criteria->compare('director',$this->director,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Actor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
