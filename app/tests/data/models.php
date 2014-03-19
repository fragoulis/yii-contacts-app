<?php

class TestContact extends Contact {
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}

class Person extends CActiveRecord {
	public function tableName()
    {
        return 'person';
    }
    public function rules()
    {
        return array(
        	array('name', 'required'),
        );
    }
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
        );
    }
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function behaviors() {
        return [
            'ContactBehavior' => [
                'class' => 'MultiContactBehavior',
                'className' => 'TestContact',
                'attribute' => 'contact_id',
                'relationAttribute' => 'person_id',
                'relationTable' => 'person_contact',
            ],
        ];
    }
}

class Store extends CActiveRecord {
	public function tableName()
    {
        return 'store';
    }
    public function rules()
    {
        return array(
        	array('name', 'required'),
            array('contact_id', 'required', 'on' => 'strict'),
        	array('contact_id', 'exist', 'className' => 'Contact', 'attributeName' => 'id'),
        );
    }
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'contact_id' => 'Contact',
        );
    }
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function behaviors() {
        return [
            'ContactBehavior' => [
                'class' => 'SingleContactBehavior',
                'className' => 'TestContact',
                'attribute' => 'contact_id',
            ],
        ];
    }
}