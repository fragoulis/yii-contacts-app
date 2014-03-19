<?php

interface Reachable {
	
	/**
	 * Adds a {@link Contact} record to the client.
	 *
	 * @param Contact $contact the contact record
	 *
	 * @return boolean true if successfull
	 */
	public function addContact($contact);

	/**
	 * Adds multiple {@link Contact Contacts} to the client.
	 * @param Contact[] the array of contacts
	 * @param boolean $overwrite if true, it will remove all the old
	 * contacts before adding the new ones.
	 */
	public function addContacts($contacts, $overwrite = false);

	/**
	 * Deletes all contacts related to the model.
	 * @return boolean true if successfll
	 */
	public function clearContacts();

	// public function addAddress($contact, $address);

	// public function addPhoneNumber($contact, $phoneNumber);

	// public function addPhoneNumbers($contact, $phoneNumbers);

	// public function deleteAddress($contact);

	// public function deletePhoneNumbers($contact);

	// public function deletePhoneNumber($contact, $i);

	// public function updateAddress($contact, $address);

	// public function updatePhoneNumber($contact, $phoneNumber, $i);

	// public function getAddress($contact);

	// public function getPhoneNumbers($contact);

	// public function getPhoneNumber($contact, $i);

	// public function getHasAddress($contact = null);

	// public function getHasPhoneNumbers($contact = null);
}