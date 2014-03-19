<?php

/**
 * 
 * 
 * @author John Fragkoulis <john.fragkoulis@gmail.com>
 * @since 0.1
 */

/**
 * This is the model class for table "contact_number".
 *
 * The followings are the available columns in table 'contact_number':
 * @property integer $id
 * @property integer $contact_id
 * @property string $type
 * @property string $number
 * @property integer $weight
 *
 * The followings are the available model relations:
 * @property Contact $contact
 */
class ContactNumber extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{contact_number}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('contact_id, type, number', 'required'),
            array('type', 'in', 'range' => ['landline', 'mobile', 'fax']),
            array('contact_id', 'exist', 'className' => 'Contact', 'attributeName' => 'id'),
            array('weight', 'numerical', 'integerOnly'=>true),
            array('number', 'length', 'max'=>255),
            array('id, contact_id, type, number, weight', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'contact' => array(self::BELONGS_TO, 'Contact', 'contact_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'contact_id' => 'Contact',
            'type' => 'Type',
            'number' => 'Number',
            'weight' => 'Weight',
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
        $criteria->compare($alias . '.contact_id',$this->contact_id);
        $criteria->compare($alias . '.type',$this->type);
        $criteria->compare($alias . '.number',$this->number,true);
        $criteria->compare($alias . '.weight',$this->weight);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ContactNumber the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    //
    // METHODS
    //
    
    /**
     * [assign description]
     * @param  Contact $contact [description]
     * @return ContactNumber
     */
    public function assign(Contact $contact) {
        $this->contact_id = $contact->id;
        return $this;
    }
}