<?php

/**
 * This is the model class for table "{{yd_user}}".
 *
 * The followings are the available columns in table '{{yd_user}}':
 * @property integer $id
 * @property string $name
 * @property string $stbid
 * @property string $type
 * @property string $province
 * @property string $city
 * @property string $cp
 * @property string $group
 * @property string $pay
 * @property string $mobileUser
 * @property string $mobileDevice
 * @property string $delFlag
 * @property integer $cTime
 */
class User extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cTime', 'numerical', 'integerOnly'=>true),
            array('cp', 'length', 'max'=>1),
            array('name,type', 'length', 'max'=>50),
            array('stbid', 'length', 'max'=>40),
            array('group,mobileUser,mobileDevice', 'length', 'max'=>20),
            array('pay', 'length', 'max'=>30),
            array('province', 'length', 'max'=>2),
            array('city', 'length', 'max'=>5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,name,stbid,type,province,city,cp,group,pay,mobileUser,mobileDevice,delFlag,cTime', 'safe', 'on'=>'search'),
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
            'name' => '用户名',
            'stbid' => '盒子序列号',
            'type' => '盒子型号',
            'province' => '省份编码',
            'city' => '地市编码',
            'cp' => '牌照方标识',
            'group' => '用户组标识',
            'pay' => '计费标识',
            'mobileUser' => '配对设备的用户id',
            'mobileDevice' => '配对设备的设备id',
            'delFlag' => '删除标识',
            'cTime' => '创建时间',
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
        $criteria->compare('name',$this->name,true);
        $criteria->compare('stbid',$this->stbid,true);
        $criteria->compare('type',$this->type,true);
        $criteria->compare('province',$this->province,true);
        $criteria->compare('city',$this->city,true);
        $criteria->compare('cp',$this->cp,true);
        $criteria->compare('group',$this->group,true);
        $criteria->compare('pay',$this->pay,true);
        $criteria->compare('mobileUser',$this->mobileUser,true);
        $criteria->compare('mobileDevice',$this->mobileDevice,true);
        $criteria->compare('delFlag',$this->delFlag,true);
        $criteria->compare('cTime',$this->cTime);

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
