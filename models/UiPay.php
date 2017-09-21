<?php

/**
 * This is the model class for table "{{ui_pay}}".
 *
 * The followings are the available columns in table '{{ui_pay}}':
 * @property integer $id
 * @property string $duration
 * @property string $year
 * @property string $country
 * @property string $form
 * @property string $hot
 * @property string $director
 * @property string $actor
 * @property string $epitasis
 * @property integer $u_id
 * @property string $link
 */
class UiPay extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{ui_pay}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('u_id', 'numerical', 'integerOnly'=>true),
            array('duration,year,hot', 'length', 'max'=>4),
            array('country,form', 'length', 'max'=>20),
            array('actor,director', 'length', 'max'=>80),
            array('epitasis', 'length', 'max'=>500),
            array('link', 'length', 'max'=>500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, duration, year, country, form, hot, director, actor, epitasis, u_id, link', 'safe', 'on'=>'search'),
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
            'duration' => '时长',
            'year' => '年份',
            'country' => '国家',
            'form' => '类型',
            'hot' => '热门指数',
            'director' => '导演',
            'actor' => '主演',
            'epitasis' => '剧情介绍',
            'u_id' => 'app页面布局id',
            'link' => '播放链接',
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
        $criteria->compare('duration',$this->duration,true);
        $criteria->compare('year',$this->year,true);
        $criteria->compare('country',$this->country,true);
        $criteria->compare('form',$this->form,true);
        $criteria->compare('hot',$this->hot,true);
        $criteria->compare('director',$this->director,true);
        $criteria->compare('actor',$this->actor,true);
        $criteria->compare('epitasis',$this->epitasis,true);
        $criteria->compare('u_id',$this->u_id);
        $criteria->compare('link',$this->link,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UiPay the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
