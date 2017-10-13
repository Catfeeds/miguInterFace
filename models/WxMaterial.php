<?php

/**
 * This is the model class for table "{{wx_material}}".
 *
 * The followings are the available columns in table '{{wx_material}}':
 * @property string $media_id
 * @property string $title
 * @property string $url
 * @property string $introduction
 * @property string $atricles_id
 * @property string $local_path
 * @property string $data_type
 * @property integer $data_status
 * @property string $create_time
 * @property string $update_time
 */
class WxMaterial extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{wx_material}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('media_id', 'required'),
            array('data_status', 'numerical', 'integerOnly'=>true),
            array('media_id, title, url, atricles_id, local_path', 'length', 'max'=>255),
            array('data_type', 'length', 'max'=>32),
            array('create_time, update_time', 'length', 'max'=>11),
            array('introduction', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('media_id, title, url, introduction, atricles_id, local_path, data_type, data_status, create_time, update_time', 'safe', 'on'=>'search'),
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
            'media_id' => 'Media',
            'title' => 'Title',
            'url' => 'Url',
            'introduction' => 'Introduction',
            'atricles_id' => 'Atricles',
            'local_path' => 'Local Path',
            'data_type' => 'Data Type',
            'data_status' => 'Data Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
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

        $criteria->compare('media_id',$this->media_id,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('introduction',$this->introduction,true);
        $criteria->compare('atricles_id',$this->atricles_id,true);
        $criteria->compare('local_path',$this->local_path,true);
        $criteria->compare('data_type',$this->data_type,true);
        $criteria->compare('data_status',$this->data_status);
        $criteria->compare('create_time',$this->create_time,true);
        $criteria->compare('update_time',$this->update_time,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return WxMaterial the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}