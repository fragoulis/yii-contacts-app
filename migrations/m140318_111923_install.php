<?php

class m140318_111923_install extends CDbMigration
{
	public function safeUp()
	{
		// Contact Type Enum
		$this->execute('CREATE TYPE contact_type AS ENUM (\'home\',\'work\',\'temporary\')');

		// Contact Number Type Enum
		$this->execute('CREATE TYPE contact_number_type AS ENUM (\'landline\',\'mobile\',\'fax\')');

		// Contact Table
		$this->createTable('{{contact}}', [
			'id' => 'pk',
			'country_id' => 'varchar(2) NOT NULL',
			'weight' => 'integer NOT NULL DEFAULT 0',
			'email' => 'string',
			'lat' =>'numeric(3,0)',
			'lng' =>'numeric(3,0)',
			'location_id' => 'integer',
			'type' => 'contact_type NOT NULL',
			'pobox' => 'string',
			'street_no' => 'string',
			'address_display' => 'string',
			'details' => 'string',
			'is_active' => 'boolean NOT NULL DEFAULT true',
			'created_at' => 'timestamp NOT NULL',
			'updated_at' => 'timestamp',
		]);

		// Contact Number Table
		$this->createTable('{{contact_number}}', [
			'id' => 'pk',
			'contact_id' => 'integer NOT NULL',
			'type' => 'contact_number_type NOT NULL',
			'number' => 'string NOT NULL',
			'weight' => 'integer NOT NULL DEFAULT 0',
		]);

		$this->addForeignKey('{{contact_number}}_contact_id_fkey', '{{contact_number}}', 'contact_id', '{{contact}}', 'id', 'CASCADE', 'CASCADE');
	}

	public function safeDown()
	{
		$db = $this->getDbConnection();
		$db->createCommand()->setText($this->getDbConnection()->getSchema()->dropTable('{{contact_number}}') . ' CASCADE')->execute();
		$db->createCommand()->setText($this->getDbConnection()->getSchema()->dropTable('{{contact}}') . ' CASCADE')->execute();
        $db->createCommand('DROP TYPE contact_type')->execute();
        $db->createCommand('DROP TYPE contact_number_type')->execute();
	}
}