<?php

/**
 * This is the model class for table "{{ui}}".
 *
 * The followings are the available columns in table '{{ui}}':
 * @property integer $id
 * @property string $title
 * @property string $position
 * @property string $url
 * @property string $bigImg
 * @property string $type
 * @property integer $addTime
 * @property integer $upTime
 * @property string $provinceCode
 * @property string $cityCode
 * @property string $delFlag
 * @property string $cp
 * @property string $epg
 * @property string $tType
 */
class Ui extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{ui}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cp', 'required'),
            array('addTime, upTime', 'numerical', 'integerOnly'=>true),
            array('title, provinceCode, cityCode', 'length', 'max'=>100),
            array('position', 'length', 'max'=>5),
            array('url', 'length', 'max'=>500),
            array('bigImg', 'length', 'max'=>255),
            array('type', 'length', 'max'=>15),
            array('delFlag, epg, tType', 'length', 'max'=>1),
            array('cp', 'length', 'max'=>2),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, position, url, bigImg, type, addTime, upTime, provinceCode, cityCode, delFlag, cp, epg, tType', 'safe', 'on'=>'search'),
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
            'title' => '标题',
            'position' => '定位',
            'url' => '连接',
            'bigImg' => '背景图片',
            'type' => '所属分类',
            'addTime' => '添加时间',
            'upTime' => '更新时间',
            'provinceCode' => '省编码',
            'cityCode' => '地市编码',
            'delFlag' => '删除标识',
            'cp' => '牌照方标识',
            'epg' => '界面标识',
            'tType' => '上传类型',
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
        $criteria->compare('title',$this->title,true);
        $criteria->compare('position',$this->position,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('bigImg',$this->bigImg,true);
        $criteria->compare('type',$this->type,true);
        $criteria->compare('addTime',$this->addTime);
        $criteria->compare('upTime',$this->upTime);
        $criteria->compare('provinceCode',$this->provinceCode,true);
        $criteria->compare('cityCode',$this->cityCode,true);
        $criteria->compare('delFlag',$this->delFlag,true);
        $criteria->compare('cp',$this->cp,true);
        $criteria->compare('epg',$this->epg,true);
        $criteria->compare('tType',$this->tType,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Ui the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
