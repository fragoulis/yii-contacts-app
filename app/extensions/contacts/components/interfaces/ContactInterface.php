<?php

/**
 * 
 * 
 * @author John Fragkoulis <john.fragkoulis@gmail.com>
 * @since 0.1
 */

interface ContactInterface {
	
    /**
     * @return boolean true if record has datain the display attribute
     */
    public function getHasAddress();

    /**
     * @return boolean true if record has related phone numbers
     */
    public function getHasPhoneNumbers();

}