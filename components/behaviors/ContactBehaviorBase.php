<?php

/**
 * 
 * 
 * @author John Fragkoulis <john.fragkoulis@gmail.com>
 * @since 0.1
 */
class ContactBehaviorBase extends CActiveRecordBehavior implements Reachable {
	
	public function addContact($contact) {
		throw new CException('The method "' . __FUNCTION__ . '" is not supported.');
	}

	public function addContacts($contacts, $overwrite = false ) {
		throw new CException('The method "' . __FUNCTION__ . '" is not supported.');
	}

	public function clearContacts() {
		throw new CException('The method "' . __FUNCTION__ . '" is not supported.');
	}
}