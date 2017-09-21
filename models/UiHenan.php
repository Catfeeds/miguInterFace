<?php

/**
 * This is the model class for table "{{ui_henan}}".
 *
 * The followings are the available columns in table '{{ui_henan}}':
 * @property integer $id
 * @property string $title
 * @property string $pos
 * @property string $url
 * @property string $pic
 * @property string $type
 * @property string $cp
 * @property string $delFlag
 * @property integer $cTime
 * @property integer $upTime
 */
class UiHenan extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{ui_henan}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cTime, upTime', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>100),
            array('pos', 'length', 'max'=>5),
            array('url', 'length', 'max'=>200),
            array('pic', 'length', 'max'=>600),
            array('type, cp, delFlag', 'length', 'max'=>1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, pos, url, pic, type, cp, delFlag, cTime, upTime', 'safe', 'on'=>'search'),
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
            'pos' => 'Pos',
            'url' => '跳转地址',
            'pic' => '图片地址',
            'type' => '上传类型',
            'cp' => '牌照方标识',
            'delFlag' => '删除标识',
            'cTime' => '创建时间',
            'upTime' => '修改时间',
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
        $criteria->compare('pos',$this->pos,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('pic',$this->pic,true);
        $criteria->compare('type',$this->type,true);
        $criteria->compare('cp',$this->cp,true);
        $criteria->compare('delFlag',$this->delFlag,true);
        $criteria->compare('cTime',$this->cTime);
        $criteria->compare('upTime',$this->upTime);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UiHenan the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}