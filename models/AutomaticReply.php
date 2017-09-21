<?php

/**
 * This is the model class for table "{{automatic_reply}}".
 *
 * The followings are the available columns in table '{{automatic_reply}}':
 * @property integer $id
 * @property string $msgtype
 * @property string $key_word
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $link_url
 * @property string $hq_link_url
 * @property string $thumb_media_id
 * @property string $media_id
 * @property string $url
 * @property integer $data_type
 * @property integer $data_status
 * @property integer $create_time
 * @property integer $update_time
 */
class AutomaticReply extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{automatic_reply}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('data_type, data_status, create_time, update_time', 'numerical', 'integerOnly'=>true),
            array('msgtype', 'length', 'max'=>10),
            array('key_word, media_id', 'length', 'max'=>64),
            array('title', 'length', 'max'=>128),
            array('description', 'length', 'max'=>500),
            array('link_url, hq_link_url, thumb_media_id, url', 'length', 'max'=>256),
            array('content', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, msgtype, key_word, title, description, content, link_url, hq_link_url, thumb_media_id, media_id, url, data_type, data_status, create_time, update_time', 'safe', 'on'=>'search'),
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
            'msgtype' => 'Msgtype',
            'key_word' => 'Key Word',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'link_url' => 'Link Url',
            'hq_link_url' => 'Hq Link Url',
            'thumb_media_id' => 'Thumb Media',
            'media_id' => 'Media',
            'url' => 'Url',
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

        $criteria->compare('id',$this->id);
        $criteria->compare('msgtype',$this->msgtype,true);
        $criteria->compare('key_word',$this->key_word,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('content',$this->content,true);
        $criteria->compare('link_url',$this->link_url,true);
        $criteria->compare('hq_link_url',$this->hq_link_url,true);
        $criteria->compare('thumb_media_id',$this->thumb_media_id,true);
        $criteria->compare('media_id',$this->media_id,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('data_type',$this->data_type);
        $criteria->compare('data_status',$this->data_status);
        $criteria->compare('create_time',$this->create_time);
        $criteria->compare('update_time',$this->update_time);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AutomaticReply the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}