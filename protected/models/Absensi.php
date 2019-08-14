<?php

/**
 * This is the model class for table "absensi".
 *
 * The followings are the available columns in table 'absensi':
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $created_at
 * @property integer $status
 * @property string $alasan
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Absensi extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	protected $tbl_prefix = null;
	/*public function tableName()
	{
		return 'absensi';
	}*/

	public function tableName()
	{
		if ($this->tbl_prefix === null)
        {
            // Fetch prefix
            $this->tbl_prefix = Yii::app()->params['tablePrefix'];
        }
 
        // Prepend prefix, call our new method
        return ($this->tbl_prefix . $this->_tableName());
		//return 'absensi';
	}

	protected function _tableName()
    {
        // Call the original method for our table name stuff
        return 'absensi';
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, status, sync_status', 'numerical', 'integerOnly'=>true),
			array('type, alasan', 'length', 'max'=>255),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, type, created_at, status, alasan, sync_status', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
                        'lesson' => array(self::BELONGS_TO, 'Lesson', 'id_lesson'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'type' => 'Type',
			'created_at' => 'Created At',
			'status' => 'Status',
			'alasan' => 'Alasan',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('alasan',$this->alasan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Absensi the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
