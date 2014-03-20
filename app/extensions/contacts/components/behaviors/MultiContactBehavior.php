<?php

/**
 * 
 * 
 * @author John Fragkoulis <john.fragkoulis@gmail.com>
 * @since 0.1
 */
 class MultiContactBehavior extends ContactBehaviorBase {
 	/**
 	 * @var string the foreign key
 	 */
 	public $relationAttribute;
 	/**
 	 * @var string the related table
 	 */
 	public $relationTable;
 	/**
 	 * @var string the related attribute
 	 */
 	public $attribute = 'contact_id';
	/**
	 * @var string the relation name
	 */
	public $relationName = 'contacts';
	/**
	 * The model class name
	 * @var string
	 */
	public $className = 'Contact';
	/**
	 * @var string the relation type
	 */
	protected $relationType = CActiveRecord::MANY_MANY;

	public function attach($owner) {
		if( $this->attribute === null || $this->relationName === null || $this->relationType === null || $this->relationAttribute === null || $this->relationTable === null ) {
			throw new CException(Yii::t('Contact.main', 'You must set $attribute, $relationName, $relationType, $relationAttribute, $relationTable.'));
		}

		$owner->getMetadata()->addRelation($this->relationName, [
			$this->relationType, 
			$this->className, 
			"{$this->relationTable}({$this->relationAttribute},{$this->attribute})",
			'order' => $this->relationName . '.weight DESC'
		]);
		parent::attach($owner);
	}

	/**
	 * [addContact description]
	 * @param [type] $contact
	 */
	public function addContact( $contact ) {
		if( $this->owner->isNewRecord ) {
			throw new CException('You may not add a contact to a new record.');
		}

		return 1 === Yii::app()->db->createCommand()->insert("{{{$this->relationTable}}}", [
			$this->relationAttribute => $this->owner->id,
			$this->attribute => $contact->id,
		]);
	}
	/**
	 * [addContacts description]
	 * @param [type]  $contact
	 * @param boolean $overwrite
	 */
	public function addContacts( $contacts, $overwrite = false ) {
		if( empty($contacts) )
			return false;

		if( $overwrite && $this->clearContacts() === false ) {
			return false;
		}

		$rows=[];
		foreach( $contacts as $contact ) {
			$rows[] = [
				$this->relationAttribute => $this->owner->id,
				$this->attribute => $contact['id'],
			];
		}

		$rowsAffected = Yii::app()->db->getCommandBuilder()
									  ->createMultipleInsertCommand("{{{$this->relationTable}}}", $rows)
									  ->execute();

		return count($rows) === $rowsAffected;
	}
	/**
	 * [clearContacts description]
	 * @return [type]
	 */
	public function clearContacts() {
		$criteria = new CDbCriteria;
		$criteria->addColumnCondition([
	  		$this->relationAttribute => $this->owner->id
  		]);

		$numberOfContacts = (int) Yii::app()->db->getCommandBuilder()
						    			  ->createCountCommand("{{{$this->relationTable}}}", $criteria)
									      ->queryScalar();

		$rowsAffected = Yii::app()->db->createCommand()->delete("{{{$this->relationTable}}}", "{$this->relationAttribute} = :owner", [
			':owner' => $this->owner->id,
		]);
		
		return $numberOfContacts === $rowsAffected;
	}
}