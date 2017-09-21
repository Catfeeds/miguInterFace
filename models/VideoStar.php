<?php

/**
 * This is the model class for table "{{video_star}}".
 *
 * The followings are the available columns in table '{{video_star}}':
 * @property string $id
 * @property integer $starId
 * @property string $name
 * @property string $alias
 * @property string $nameEn
 * @property integer $sex
 * @property string $professon
 * @property string $birthplace
 * @property string $birth
 * @property string $constellation
 * @property string $tall
 * @property string $blood
 * @property string $brief
 * @property string $evaluate
 * @property string $sexual
 * @property string $nationality
 * @property string $weight
 * @property string $nation
 * @property string $company
 * @property string $orgIds
 * @property integer $applyUserId
 * @property string $applyTime
 * @property integer $applyPassTime
 * @property integer $status
 * @property integer $publishStatus
 * @property integer $availStatus
 * @property integer $lang
 */
class VideoStar extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{video_star}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('starId, sex, applyUserId, applyPassTime, status, publishStatus, availStatus, lang', 'numerical', 'integerOnly'=>true),
			array('name, tall, blood, weight', 'length', 'max'=>30),
			array('alias, nameEn, professon, birthplace, birth, sexual, nationality, nation', 'length', 'max'=>100),
			array('constellation', 'length', 'max'=>3),
			array('company', 'length', 'max'=>255),
			array('orgIds', 'length', 'max'=>500),
			array('applyTime', 'length', 'max'=>150),
			array('brief, evaluate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, starId, name, alias, nameEn, sex, professon, birthplace, birth, constellation, tall, blood, brief, evaluate, sexual, nationality, weight, nation, company, orgIds, applyUserId, applyTime, applyPassTime, status, publishStatus, availStatus, lang', 'safe', 'on'=>'search'),
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
			'starId' => '人物ID',
			'name' => '名字',
			'alias' => '人物别名',
			'nameEn' => '英文名',
			'sex' => '性别 0：女 1：男 2：变性',
			'professon' => '职业 1 : 演员 2 : 导演 3 : 编剧 4 : 制片 5 : 配音 6 : 主持人 7 : 主播 8 : 模特 9 : 运动员 10 : 歌手 可多选，以 英文标点逗号分隔',
			'birthplace' => '出生地',
			'birth' => '出生',
			'constellation' => '星座 0 : 白羊座 1 : 金牛座 2 : 双子座 3 : 巨蟹座 4 : 狮子座 5 : 处女座 6 : 天秤座 7 : 天蝎座 8 : 射手座 9 : 摩羯座 10 : 水瓶座 11 : 双鱼座',
			'tall' => '身高',
			'blood' => '血型 0 : A    1 : B 2 : AB   3 : O',
			'brief' => 'Brief',
			'evaluate' => '人物评价',
			'sexual' => '性取向, 0 : 异性恋 1 : 同性恋2 : 双性恋',
			'nationality' => '国籍',
			'weight' => '体重',
			'nation' => '民族',
			'company' => '经纪公司',
			'orgIds' => '组织ID',
			'applyUserId' => '申请人物入库 操作员账号名称',
			'applyTime' => '申请入库时间',
			'applyPassTime' => '申请入库通过时间',
			'status' => '人物状态 0 : 新增(默认) 1 : 提交入库 2 : 已入库 3 : 驳回',
			'publishStatus' => '人物发布状态 0 : 未发布 1：已发布',
			'availStatus' => '人物可用状态 0 : 不可用 1 : 可用',
			'lang' => '国际化语言 0 : 简体 1 : 繁体 2 : 英文',
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
		$criteria->compare('starId',$this->starId);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('nameEn',$this->nameEn,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('professon',$this->professon,true);
		$criteria->compare('birthplace',$this->birthplace,true);
		$criteria->compare('birth',$this->birth,true);
		$criteria->compare('constellation',$this->constellation,true);
		$criteria->compare('tall',$this->tall,true);
		$criteria->compare('blood',$this->blood,true);
		$criteria->compare('brief',$this->brief,true);
		$criteria->compare('evaluate',$this->evaluate,true);
		$criteria->compare('sexual',$this->sexual,true);
		$criteria->compare('nationality',$this->nationality,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('nation',$this->nation,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('orgIds',$this->orgIds,true);
		$criteria->compare('applyUserId',$this->applyUserId);
		$criteria->compare('applyTime',$this->applyTime,true);
		$criteria->compare('applyPassTime',$this->applyPassTime);
		$criteria->compare('status',$this->status);
		$criteria->compare('publishStatus',$this->publishStatus);
		$criteria->compare('availStatus',$this->availStatus);
		$criteria->compare('lang',$this->lang);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VideoStar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
