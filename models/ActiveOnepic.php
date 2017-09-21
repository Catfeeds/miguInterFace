<?php

/**
 * This is the model class for table "{{active_onepic}}".
 *
 * The followings are the available columns in table '{{active_onepic}}':
 * @property string $id
 * @property string $uid
 * @property string $type
 * @property string $province
 * @property string $city
 * @property string $cp
 * @property string $epg
 * @property string $cid
 * @property string $cTime
 * @property string $vname
 * @property string $title
 * @property integer $pos
 * @property integer $rand
 * @property string $usergroup
 * @property string $epgcode
 */
class ActiveOnepic extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{active_onepic}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, type, province, city, cp, epg, cid, cTime, vname', 'required'),
			array('pos, rand', 'numerical', 'integerOnly'=>true),
			array('uid', 'length', 'max'=>10),
			array('type, cp', 'length', 'max'=>20),
			array('province', 'length', 'max'=>2),
			array('city', 'length', 'max'=>5),
			array('epg', 'length', 'max'=>9),
			array('cid, vname', 'length', 'max'=>50),
			array('cTime', 'length', 'max'=>11),
			array('title', 'length', 'max'=>100),
			array('usergroup, epgcode', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, uid, type, province, city, cp, epg, cid, cTime, vname, title, pos, rand, usergroup, epgcode', 'safe', 'on'=>'search'),
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
			'uid' => 'Uid',
			'type' => 'Type',
			'province' => 'Province',
			'city' => 'City',
			'cp' => 'Cp',
			'epg' => 'Epg',
			'cid' => 'Cid',
			'cTime' => 'C Time',
			'vname' => 'Vname',
			'title' => '标题',
			'pos' => 'Pos',
			'rand' => 'Rand',
			'usergroup' => 'Usergroup',
			'epgcode' => 'Epgcode',
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
		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('cp',$this->cp,true);
		$criteria->compare('epg',$this->epg,true);
		$criteria->compare('cid',$this->cid,true);
		$criteria->compare('cTime',$this->cTime,true);
		$criteria->compare('vname',$this->vname,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('rand',$this->rand);
		$criteria->compare('usergroup',$this->usergroup,true);
		$criteria->compare('epgcode',$this->epgcode,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ActiveOnepic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

