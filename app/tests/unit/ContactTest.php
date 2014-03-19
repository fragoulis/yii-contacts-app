<?php 

require_once(dirname(__FILE__).'/../data/models.php');

class ContactTest extends CDbTestCase {

	public $fixtures = [
		'contacts' => 'Contact',
		'contactNumbers' => 'ContactNumber',
	];

	public function setUp() {
		parent::setUp();
		Yii::app()->db->pdoInstance->exec(file_get_contents(dirname(__FILE__).'/../data/postgres.up.sql'));
	}

	public function tearDown() {
		Yii::app()->db->pdoInstance->exec(file_get_contents(dirname(__FILE__).'/../data/postgres.down.sql'));
		parent::tearDown();
	}
	/**
	 * Expects that person has one contact with address only.
	 */
	public function testThatPersonHasAddress() {
		$person = Person::model()->findByPk(1);
		
		$contacts = $person->contacts;
		$this->assertNotEmpty($contacts);
		$this->assertEquals(1, count($contacts));

		$contact = $contacts[0];
		$this->assertInstanceOf('Contact', $contact);
		$this->assertEquals('address no phone numbers', $contact->address_display);

		$numbers = $contact->phoneNumbers;
		$this->assertFalse($contact->hasPhoneNumbers);
	}
	/**
	 * Expects that person has one contact with one phone number.
	 */
	public function testThatPersonHasPhoneNumber() {
		$person = Person::model()->findByPk(2);

		$contacts = $person->contacts;
		$this->assertNotEmpty($contacts);
		$this->assertEquals(1, count($contacts));

		$contact = $contacts[0];
		$this->assertInstanceOf('Contact', $contact);
		$this->assertFalse($contact->hasAddress);

		$numbers = $contact->phoneNumbers;
		$this->assertTrue($contact->hasPhoneNumbers);
		$this->assertEquals(1, count($numbers));

		$number = $numbers[0];
		$this->assertInstanceOf('ContactNumber', $number);
		$this->assertEquals('6912345678', $number->number);
	}
	/**
	 * Expencts that store has a contact with address and two numbers.
	 */
	public function testThatStoreHasAddressWithTwoNumbers() {
		$store = Store::model()->findByPk(1);

		$contact = $store->contact;
		$this->assertInstanceOf('Contact', $contact);
		$this->assertEquals('address with phone numbers', $contact->address_display);

		$numbers = $contact->phoneNumbers;
		$this->assertTrue($contact->hasPhoneNumbers);
		$this->assertEquals(2, count($numbers));

		$this->assertInstanceOf('ContactNumber', $numbers[0]);
		$this->assertEquals('2101234567', $numbers[0]->number);

		$this->assertInstanceOf('ContactNumber', $numbers[1]);
		$this->assertEquals('1112223334', $numbers[1]->number);
	}
	/**
	 * Test that it fails to create with no address
	 * and phone numbers.
	 */
	public function testCreateNewContactEmpty() {
		$contact = new Contact('strict');
		$contact->country_id = 'el';
		$contact->type = ContactType::home;

		$this->assertFalse($contact->save());
		$this->assertEquals(1, count($contact->errors));

		$contact->address_display = 'new address';

		$this->assertTrue($contact->save());
	}
	/**
	 * Test that we can create a new contact and with adddress
	 */
	public function testCreateNewContactWithAddress() {
		$contact = new Contact('strict');
		$contact->country_id = 'el';
		$contact->type = ContactType::home;
		$contact->address_display = 'new address';
		$this->assertTrue($contact->save());
	}
	/**
	 * Test that we can create a new contact with phone numbers
	 */
	public function testCreateNewContactWithNumbers() {
		$contact = new Contact('strict');
		$contact->country_id = 'el';
		$contact->type = ContactType::home;
		$this->assertTrue($contact->save(true,['country_id','type','created_at']));

		$this->assertFalse($contact->hasPhoneNumbers);

		$phoneNumber = new ContactNumber;
		$phoneNumber->type = ContactNumberType::landline;
		$phoneNumber->number = '1234567890';

		$contact->addPhoneNumber($phoneNumber);

		$contact->refresh();
		$this->assertTrue($contact->hasPhoneNumbers);
	}
	/**
	 * Test that adding to new model throw exception
	 * @expectedException CException
	 */
	public function testAddContactToNewSingleContactModel() {
		$store = new Store();
		$store->addContact($this->contacts(0));
	}
	/**
	 * Test that we can add a contact to a single
	 * contact model.
	 */
	public function testAddContactToSingleContactModel() {
		$store = new Store();
		$store->name = __FUNCTION__;
		$this->assertTrue($store->save());

		$this->assertFalse($store->addContact(null));
		$this->assertTrue($store->addContact($this->contacts(0)));
	}
	/**
	 * Test that we can add a contact to a multi
	 * contact model.
	 */
	public function testAddContactToMultiContactModel() {
		$person = new Person();
		$person->name = __FUNCTION__;
		$this->assertTrue($person->save());

		$this->assertTrue($person->addContact($this->contacts(0)));
	}
	/**
	 * Test that we can cannot add mulitple contacts to a single
	 * contact model.
	 *
	 * @expectedException CException
	 */
	public function testAddContactsToSingleContactModel() {
		$store = new Store();
		$store->name = __FUNCTION__;
		$this->assertTrue($store->save());

		$store->addContacts($this->contacts);
	}
	/**
	 * Test that we can add mulitple contacts to a multi
	 * contact model.
	 */
	public function testAddContactsToMultiContactModel() {
		$person = new Person();
		$person->name = __FUNCTION__;
		$this->assertTrue($person->save());

		$this->assertFalse($person->addContacts([]));
		$this->assertTrue($person->addContacts($this->contacts));
	}
	/**
	 * Test that adding to new model throw exception
	 * @expectedException CException
	 */
	public function testAddContactToNewMultiContactModel() {
		$person = new Person();
		$person->addContact($this->contacts(0));
	}
	/**
	 * Test the we can clear the contacts
	 */
	public function testClearContactOfSingleContactModel() {
		$store = new Store();
		$store->name = __FUNCTION__;
		$this->assertTrue($store->save());

		$this->assertTrue($store->addContact($this->contacts[0]));
		$this->assertTrue($store->clearContacts());
	}
	/**
	 * Test the we can clear the contacts
	 */
	public function testClearContactsOfMultiContactModel() {
		$person = new Person();
		$person->name = __FUNCTION__;
		$this->assertTrue($person->save());

		$this->assertTrue($person->addContacts($this->contacts));
		$this->assertTrue($person->clearContacts());
	}
	/**
	 * Test that we can overwrite the contact of a single
	 * contact model.
	 */
	public function testOverwriteContactToSingleContactModel() {
		$store = new Store();
		$store->name = __FUNCTION__;
		$this->assertTrue($store->save());

		$this->assertTrue($store->addContact($this->contacts(0)));
		$this->assertFalse($store->addContact($this->contacts(1)));
		$this->assertTrue($store->addContact($this->contacts(1), true));
	}
	/**
	 * Test that we can overwrite mulitple contacts to a multi
	 * contact model.
	 */
	public function testOverwriteContactsToMultiContactModel() {
		$person = new Person();
		$person->name = __FUNCTION__;
		$this->assertTrue($person->save());

		$this->assertTrue($person->addContacts($this->contacts));
		$this->assertTrue($person->addContacts($this->contacts, true));
	}

	public function testAddPhoneNumberToSingleContactModel() {
		$store = Store::model()->findByPk(1);
		$contact = $store->contact;
		$this->assertEquals(2, count($contact->phoneNumbers));

		$ok = $store->addPhoneNumber($contact, [
			'type' => ContactNumberType::mobile,
			'number' => '6932326895'
		]);

		$this->assertTrue($ok);

		$store->refresh();
		$contact = $store->contact;
		$this->assertEquals(3, count($contact->phoneNumbers));
	}

	public function testAddPhoneNumberToMultiContactModel() {
		$person = Person::model()->findByPk(1);
		$contacts = $person->contacts;
		$this->assertFalse($contacts[0]->hasPhoneNumbers);

		$ok = $person->addPhoneNumber($contacts[0], [
			'type' => ContactNumberType::mobile,
			'number' => '6932326895'
		]);

		$this->assertTrue($ok);

		$person->refresh();
		$contacts = $person->contacts;
		$this->assertTrue($contacts[0]->hasPhoneNumbers);
	}
}