<?php

/**
 * This is the model class for table "{{video_extra}}".
 *
 * The followings are the available columns in table '{{video_extra}}':
 * @property string $id
 * @property string $vid
 * @property string $cp
 * @property string $prize
 * @property string $boxoffice
 * @property string $subtitles
 * @property string $comment
 * @property string $orders
 * @property string $end
 * @property string $score
 * @property string $bftime
 * @property string $total
 * @property string $tvstation
 */
class VideoExtra extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{video_extra}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vid, cp, prize, boxoffice, comment', 'required'),
			array('vid', 'length', 'max'=>20),
			array('cp', 'length', 'max'=>15),
			array('prize, boxoffice, subtitles', 'length', 'max'=>50),
			array('comment', 'length', 'max'=>400),
			array('orders, score', 'length', 'max'=>30),
			array('end', 'length', 'max'=>6),
			array('bftime', 'length', 'max'=>40),
			array('total', 'length', 'max'=>60),
			array('tvstation', 'length', 'max'=>70),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vid, cp, prize, boxoffice, subtitles, comment, orders, end, score, bftime, total, tvstation', 'safe', 'on'=>'search'),
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
			'vid' => 'Vid',
			'cp' => 'Cp',
			'prize' => 'Prize',
			'boxoffice' => 'Boxoffice',
			'subtitles' => 'Subtitles',
			'comment' => 'Comment',
			'orders' => 'Orders',
			'end' => 'End',
			'score' => 'Score',
			'bftime' => 'Bftime',
			'total' => 'Total',
			'tvstation' => 'Tvstation',
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
		$criteria->compare('vid',$this->vid,true);
		$criteria->compare('cp',$this->cp,true);
		$criteria->compare('prize',$this->prize,true);
		$criteria->compare('boxoffice',$this->boxoffice,true);
		$criteria->compare('subtitles',$this->subtitles,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('orders',$this->orders,true);
		$criteria->compare('end',$this->end,true);
		$criteria->compare('score',$this->score,true);
		$criteria->compare('bftime',$this->bftime,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('tvstation',$this->tvstation,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VideoExtra the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

