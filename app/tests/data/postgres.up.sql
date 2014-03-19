/**
 * This is the database schema for testing PostgreSQL support of yii Active Record.
 * To test this feature, you need to create a database named 'yii' on 'localhost'
 * and create an account 'test/test' which owns this test database.
 */
CREATE TABLE person
(
	id SERIAL NOT NULL PRIMARY KEY,
	name VARCHAR(128) NOT NULL
);

COMMENT ON COLUMN person.name IS 'Name of the person';

INSERT INTO person (name) VALUES ('user1');
INSERT INTO person (name) VALUES ('user2');

CREATE TABLE person_contact
(
	person_id INTEGER NOT NULL,
	contact_id INTEGER NOT NULL,
	PRIMARY KEY (person_id, contact_id),
	CONSTRAINT FK_person_id FOREIGN KEY (person_id)
		REFERENCES person (id) ON DELETE CASCADE ON UPDATE RESTRICT,
	CONSTRAINT FK_contact_id FOREIGN KEY (contact_id)
		REFERENCES contact (id) ON DELETE CASCADE ON UPDATE RESTRICT
);

INSERT INTO person_contact VALUES (1,1);
INSERT INTO person_contact VALUES (2,2);

CREATE TABLE store
(
	id SERIAL NOT NULL PRIMARY KEY,
	name VARCHAR(128) NOT NULL,
	contact_id INTEGER,
	CONSTRAINT FK_store_contact_id FOREIGN KEY (contact_id)
		REFERENCES contact (id) ON DELETE CASCADE ON UPDATE RESTRICT
);

COMMENT ON COLUMN store.name IS 'Name of the store';

INSERT INTO store (name, contact_id) VALUES ('store 1', 3);
