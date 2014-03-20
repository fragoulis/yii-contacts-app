<?php

Yii::import('ext.contacts.components.enums.*');
Yii::import('ext.contacts.components.interfaces.*');
Yii::import('ext.contacts.components.behaviors.*');

/**
 * 
 * 
 * @author John Fragkoulis <john.fragkoulis@gmail.com>
 * @since 0.1
 */

/**
 * This is the model class for table "contact".
 *
 * The followings are the available columns in table 'contact':
 * @property integer $id
 * @property string $country_id
 * @property integer $weight
 * @property string $email
 * @property string $lat
 * @property string $lng
 * @property integer $location_id
 * @property string $type
 * @property string $pobox
 * @property string $street_no
 * @property string $address_display
 * @property string $details
 * @property boolean $is_active
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property ContactNumber[] $phoneNumbers
 */
class Contact extends CActiveRecord implements ContactInterface
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{contact}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('country_id, type', 'required'),
            array('type', 'in', 'range' => ['home', 'work', 'temporary']),
            array('weight', 'numerical', 'integerOnly'=>true),
            array('country_id', 'length', 'max'=>2),
            array('email', 'email'),
            array('is_active', 'boolean'),
            array('email, pobox, street_no, address_display, details', 'length', 'max'=>255),
            array('lat, lng', 'length', 'max'=>3),
            array('lat, lng, email, pobox, street_no, address_display, details','default', 'setOnEmpty'=>true, 'value'=>null),
            array('created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'),
            array('location_id', 'validateThatEitherAddressOrPhoneExist', 'on' => 'strict'),
            array('id, country_id, weight, email, lat, lng, location_id, type, pobox, street_no, address_display, details, is_active, created_at, updated_at', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'phoneNumbers' => array(self::HAS_MANY, 'ContactNumber', 'contact_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'country_id' => 'Country',
            'weight' => 'Weight',
            'email' => 'Email',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'location_id' => 'Location',
            'type' => 'Type',
            'pobox' => 'Pobox',
            'street_no' => 'Street No',
            'address_display' => 'Address Display',
            'details' => 'Details',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
        $criteria=new CDbCriteria;

        $alias = $this->tableAlias;
        $criteria->compare($alias . '.id',$this->id);
        $criteria->compare($alias . '.country_id',$this->country_id);
        $criteria->compare($alias . '.weight',$this->weight);
        $criteria->compare($alias . '.email',$this->email,true);
        $criteria->compare($alias . '.lat',$this->lat);
        $criteria->compare($alias . '.lng',$this->lng);
        $criteria->compare($alias . '.location_id',$this->location_id);
        $criteria->compare($alias . '.type',$this->type);
        $criteria->compare($alias . '.pobox',$this->pobox,true);
        $criteria->compare($alias . '.street_no',$this->street_no);
        $criteria->compare($alias . '.address_display',$this->address_display,true);
        $criteria->compare($alias . '.details',$this->details,true);
        $criteria->compare($alias . '.is_active',$this->is_active);
        $criteria->compare($alias . '.created_at',$this->created_at,true);
        $criteria->compare($alias . '.updated_at',$this->updated_at,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Contact the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors() {
        return [
            'CTimestampBehavior' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created_at',
                'updateAttribute' => 'updated_at',
                'timestampExpression' => 'date("Y-m-d H:i:s")',
            ],
        ];
    }

    //
    // VALIDATORS
    //

    public function validateThatEitherAddressOrPhoneExist() {
        if( $this->location_id === null && $this->address_display == null ) {
            if( $this->getHasPhoneNumbers() === false ) {
                $this->addError('location_id', Yii::t('Contact.main', 'You need to either set an address or at least one phone number.'));
            }
        }
    }

    //
    // GETTERS
    //

    /**
     * @return boolean true if record has datain the display attribute
     */
    public function getHasAddress() {
        return $this->address_display != null;
    }

    /**
     * @return boolean true if record has related phone numbers
     */
    public function getHasPhoneNumbers() {
        return !empty($this->phoneNumbers);
    }

    //
    // SCOPES
    //

    public function defaultScope() {
        return [
            'condition' => $this->getTableAlias(false, false) .  '.is_active is true',
        ];
    }

    //
    // METHODS
    // 

    public static function create($attributes, $scenario = 'insert') {
        $className = get_class_name();
        $model = new $className($scenario);
        $model->setAttributes( $attributes );
        if( $model->save() ) {
            return $model;
        }
        return null;
    }
}