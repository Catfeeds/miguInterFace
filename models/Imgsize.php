<?php

/**
 * This is the model class for table "{{imgsize}}".
 *
 * The followings are the available columns in table '{{imgsize}}':
 * @property string $id
 * @property string $type
 * @property string $position
 * @property string $width
 * @property string $height
 * @property string $sequence
 */
class Imgsize extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{imgsize}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type, width, height', 'length', 'max'=>15),
            array('position, sequence', 'length', 'max'=>5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, type, position, width, height, sequence', 'safe', 'on'=>'search'),
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
            'type' => '所属分类',
            'position' => '定位',
            'width' => '图片宽度',
            'height' => '图片高度',
            'sequence' => '排列序号',
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
        $criteria->compare('type',$this->type,true);
        $criteria->compare('position',$this->position,true);
        $criteria->compare('width',$this->width,true);
        $criteria->compare('height',$this->height,true);
        $criteria->compare('sequence',$this->sequence,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Imgsize the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}