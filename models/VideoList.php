<?php

/**
 * This is the model class for table "{{video_list}}".
 *
 * The followings are the available columns in table '{{video_list}}':
 * @property integer $id
 * @property string $vid
 * @property string $cp
 * @property string $title
 * @property integer $size
 * @property string $md5
 * @property string $url
 * @property integer $cTime
 */
class VideoList extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{video_list}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('size, cTime', 'numerical', 'integerOnly'=>true),
            array('vid', 'length', 'max'=>20),
            array('cp', 'length', 'max'=>15),
            array('title', 'length', 'max'=>80),
            array('md5', 'length', 'max'=>40),
            array('url', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, vid, cp, title, size, md5, url, cTime', 'safe', 'on'=>'search'),
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
            'vid' => '视频编号',
            'cp' => '牌照方标识',
            'title' => '标题',
            'size' => '文件大小',
            'md5' => '文件md5值',
            'url' => '图片地址',
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
        $criteria->compare('vid',$this->vid,true);
        $criteria->compare('cp',$this->cp,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('size',$this->size);
        $criteria->compare('md5',$this->md5,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('cTime',$this->cTime);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return VideoList the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
