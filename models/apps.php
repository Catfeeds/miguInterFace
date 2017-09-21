<?php

/**
 * This is the model class for table "{{yd_apps}}".
 *
 * The followings are the available columns in table '{{yd_apps}}':
 * @property integer $id
 * @property string $appId
 * @property string $name
 * @property string $typeId
 * @property string $typeName
 * @property string $pic
 * @property string $url
 * @property string $status
 * @property string $delFlag
 * @property integer $cTime
 */
class Apps extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{apps}}';
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
            array('status,delFlag', 'length', 'max'=>1),
            array('name,typeName', 'length', 'max'=>50),
            array('pic,url', 'length', 'max'=>150),
            array('appId', 'length', 'max'=>20),
            array('typeId', 'length', 'max'=>5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,appId,name,typeId,typeName,pic,url,status,delFlag,cTime', 'safe', 'on'=>'search'),
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
            'appId' => '应用编号',
            'name' => '应用名称',
            'typeId' => '分类编号',
            'typeName' => '省份编码',
            'pic' => '图片地址',
            'url' => '连接地址',
            'status' => '最新最热标识',
            'delFlag' => '删除标识',
            'cTime' => '入库时间',
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
        $criteria->compare('appId',$this->appId,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('typeId',$this->typeId,true);
        $criteria->compare('typeName',$this->typeName,true);
        $criteria->compare('pic',$this->pic,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('status',$this->status,true);
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