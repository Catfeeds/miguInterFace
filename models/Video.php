<?php

/**
 * This is the model class for table "{{video}}".
 *
 * The followings are the available columns in table '{{video}}':
 * @property string $id
 * @property string $vid
 * @property string $cp
 * @property string $title
 * @property string $info
 * @property string $short
 * @property string $keyword
 * @property string $actor
 * @property string $director
 * @property string $language
 * @property string $year
 * @property string $type
 * @property string $cate
 * @property string $status
 * @property string $cTime
 * @property string $endDateTime
 * @property string $startDateTime
 * @property integer $IsAdvertise
 * @property string $ShowType
 * @property integer $flag
 * @property string $initial
 * @property integer $CountryOfOrigin
 * @property string $bitrate
 * @property string $duration
 * @property string $targetgroupassetid
 * @property string $order
 * @property string $delFlag
 * @property string $upTime
 * @property string $score
 * @property integer $simple_set
 * @property string $templateType
 * @property string $workid
 */
class Video extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{video}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vid, cp, title, type, cTime, IsAdvertise, ShowType, upTime', 'required'),
			array('IsAdvertise, flag, CountryOfOrigin, simple_set', 'numerical', 'integerOnly'=>true),
			array('vid, order', 'length', 'max'=>60),
			array('cp', 'length', 'max'=>15),
			array('title', 'length', 'max'=>300),
			array('keyword, actor', 'length', 'max'=>150),
			array('director, bitrate, duration', 'length', 'max'=>90),
			array('language, cate, ShowType', 'length', 'max'=>20),
			array('year', 'length', 'max'=>4),
			array('type', 'length', 'max'=>50),
			array('status', 'length', 'max'=>1),
			array('cTime, upTime', 'length', 'max'=>11),
			array('endDateTime, startDateTime, score', 'length', 'max'=>30),
			array('initial', 'length', 'max'=>100),
			array('targetgroupassetid', 'length', 'max'=>45),
			array('delFlag', 'length', 'max'=>6),
			array('templateType', 'length', 'max'=>2),
			array('workid', 'length', 'max'=>25),
			array('info, short', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vid, cp, title, info, short, keyword, actor, director, language, year, type, cate, status, cTime, endDateTime, startDateTime, IsAdvertise, ShowType, flag, initial, CountryOfOrigin, bitrate, duration, targetgroupassetid, order, delFlag, upTime, score, simple_set, templateType, workid', 'safe', 'on'=>'search'),
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
			'cp' => 'Cp',
			'title' => 'Title',
			'info' => 'Info',
			'short' => 'Short',
			'keyword' => 'Keyword',
			'actor' => 'Actor',
			'director' => 'Director',
			'language' => 'Language',
			'year' => 'Year',
			'type' => 'Type',
			'cate' => 'Cate',
			'status' => 'Status',
			'cTime' => 'C Time',
			'endDateTime' => 'End Date Time',
			'startDateTime' => 'Start Date Time',
			'IsAdvertise' => 'Is Advertise',
			'ShowType' => 'Show Type',
			'flag' => 'Flag',
			'initial' => 'Initial',
			'CountryOfOrigin' => 'Country Of Origin',
			'bitrate' => 'Bitrate',
			'duration' => 'Duration',
			'targetgroupassetid' => 'Targetgroupassetid',
			'order' => 'Order',
			'delFlag' => 'Del Flag',
			'upTime' => 'Up Time',
			'score' => 'Score',
			'simple_set' => 'Simple Set',
			'templateType' => 'Template Type',
			'workid' => 'Workid',
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
		$criteria->compare('cp',$this->cp,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('short',$this->short,true);
		$criteria->compare('keyword',$this->keyword,true);
		$criteria->compare('actor',$this->actor,true);
		$criteria->compare('director',$this->director,true);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('year',$this->year,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('cate',$this->cate,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('cTime',$this->cTime,true);
		$criteria->compare('endDateTime',$this->endDateTime,true);
		$criteria->compare('startDateTime',$this->startDateTime,true);
		$criteria->compare('IsAdvertise',$this->IsAdvertise);
		$criteria->compare('ShowType',$this->ShowType,true);
		$criteria->compare('flag',$this->flag);
		$criteria->compare('initial',$this->initial,true);
		$criteria->compare('CountryOfOrigin',$this->CountryOfOrigin);
		$criteria->compare('bitrate',$this->bitrate,true);
		$criteria->compare('duration',$this->duration,true);
		$criteria->compare('targetgroupassetid',$this->targetgroupassetid,true);
		$criteria->compare('order',$this->order,true);
		$criteria->compare('delFlag',$this->delFlag,true);
		$criteria->compare('upTime',$this->upTime,true);
		$criteria->compare('score',$this->score,true);
		$criteria->compare('simple_set',$this->simple_set);
		$criteria->compare('templateType',$this->templateType,true);
		$criteria->compare('workid',$this->workid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Video the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

