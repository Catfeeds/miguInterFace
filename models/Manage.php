<?php

/**
 * This is the model class for table "{{manage}}".
 *
 * The followings are the available columns in table '{{manage}}':
 * @property integer $id
 * @property string $cp
 * @property string $province
 * @property string $city
 * @property string $plate
 * @property string $position
 * @property string $content
 * @property integer $time
 * @property string $editor
 */
class Manage extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{manage}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('time', 'numerical', 'integerOnly'=>true),
            array('cp, plate', 'length', 'max'=>10),
            array('province, city, editor', 'length', 'max'=>20),
            array('position', 'length', 'max'=>15),
            array('content', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cp, province, city, plate, position, content, time, editor', 'safe', 'on'=>'search'),
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
            'cp' => '牌照方',
            'province' => '省',
            'city' => '市',
            'plate' => '板块',
            'position' => '位置',
            'content' => '内容描述',
            'time' => '有效期',
            'editor' => '编辑人',
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
        $criteria->compare('cp',$this->cp,true);
        $criteria->compare('province',$this->province,true);
        $criteria->compare('city',$this->city,true);
        $criteria->compare('plate',$this->plate,true);
        $criteria->compare('position',$this->position,true);
        $criteria->compare('content',$this->content,true);
        $criteria->compare('time',$this->time);
        $criteria->compare('editor',$this->editor,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Manage the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}