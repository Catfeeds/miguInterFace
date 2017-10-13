<?php

/**
 * This is the model class for table "{{yd_notice}}".
 *
 * The followings are the available columns in table '{{yd_notice}}':
 * @property integer $id
 * @property string $notice
 * @property string $cp
 * @property string $province
 * @property string $city
 * @property string $delFlag
 * @property integer $cTime
 * @property integer $sTime
 * @property integer $eTime
 */
class Notice extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{notice}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cTime, sTime, eTime', 'numerical', 'integerOnly'=>true),
            array('cp,delFlag', 'length', 'max'=>1),
            array('notice', 'length', 'max'=>150),
            array('province', 'length', 'max'=>2),
            array('city', 'length', 'max'=>5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,notice,cp,province,city,delFlag,cTime,sTime,eTime', 'safe', 'on'=>'search'),
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
            'id' => '编号',
            'notice' => '公告内容',
            'cp' => '牌照方标识',
            'province' => '省份编码',
            'city' => '地市编码',
            'delFlag' => '删除标识',
            'cTime' => '创建时间',
            'sTime' => '有效时间-开始',
            'eTime' => '有效时间-结束',
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
        $criteria->compare('notice',$this->notice,true);
        $criteria->compare('cp',$this->cp,true);
        $criteria->compare('province',$this->province,true);
        $criteria->compare('city',$this->city,true);
        $criteria->compare('delFlag',$this->delFlag,true);
        $criteria->compare('cTime',$this->cTime);
        $criteria->compare('sTime',$this->sTime);
        $criteria->compare('eTime',$this->eTime);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return VideoInfo the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
