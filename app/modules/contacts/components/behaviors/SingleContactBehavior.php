<?php

/**
 * SingleContactBehavior class.
 * 
 * Implements the methods for relating any model with the
 * Contacts API.
 * 
 * @author John Fragkoulis <john.fragkoulis@gmail.com>
 * @since 0.1
 */
class SingleContactBehavior extends ContactBehaviorBase {
	/**
	 * @var string the foreign key attribute name
	 */
	public $attribute = 'contact_id';
	/**
	 * @var string the relation name
	 */
	public $relationName = 'contact';
	/**
	 * The model class name
	 * @var string
	 */
	public $className = 'Contact';
	/**
	 * @var string the relation type
	 */
	protected $relationType = CActiveRecord::BELONGS_TO;

	public function attach($owner) {
		if( $this->attribute === null || $this->relationName === null || $this->relationType === null ) {
			throw new CException(Yii::t('Contact.main', 'You must set $attribute, $relationName, $relationType.'));
		}

		$owner->getMetadata()->addRelation($this->relationName, [$this->relationType, $this->className, $this->attribute]);
		parent::attach($owner);
	}

	/**
	 * [addContact description]
	 * @param [type]  $contact
	 * @param boolean $overwrite
	 */
	public function addContact($contact, $overwrite = false) {
		if( !isset($contact['id']) )
			return false;

		if( $this->owner->isNewRecord ) {
			throw new CException('You may not add a contact to a new record.');
		}

		if( $this->owner->{$this->attribute} !== null ) {
			if( $overwrite ) {
				if( $this->clearContacts() === false ) 
					return false;
			} else {
				return false;
			}
		}

		$this->owner->{$this->attribute} = $contact['id'];
		return $this->owner->save(true, [$this->attribute]);
	}

	/**
	 * 
	 */
	public function clearContacts() {
		if( $this->owner->{$this->attribute} !== null ) {
			return $this->owner->{$this->relationName}->delete();
		}
		return true;
	}
}