<?php

/**
 * This is the model class for table "{{wxbox}}".
 *
 * The followings are the available columns in table '{{wxbox}}':
 * @property integer $id
 * @property string $number
 * @property string $name
 * @property string $type
 * @property string $province
 * @property string $city
 * @property string $stbid
 */
class Wxbox extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{wxbox}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('number, name, type, province, city, stbid', 'required'),
            array('number, name, type', 'length', 'max'=>50),
            array('province', 'length', 'max'=>2),
            array('city', 'length', 'max'=>5),
            array('stbid', 'length', 'max'=>40),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, number, name, type, province, city, stbid', 'safe', 'on'=>'search'),
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
            'number' => 'Number',
            'name' => 'Name',
            'type' => 'Type',
            'province' => 'Province',
            'city' => 'City',
            'stbid' => 'Stbid',
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
        $criteria->compare('number',$this->number,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('type',$this->type,true);
        $criteria->compare('province',$this->province,true);
        $criteria->compare('city',$this->city,true);
        $criteria->compare('stbid',$this->stbid,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Wxbox the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}