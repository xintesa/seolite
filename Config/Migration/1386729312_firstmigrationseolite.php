<?php

class FirstMigrationSeoLite extends CakeMigration {

	public $description = '';

	public $migration = array(
		'up' => array(
			'create_table' => array(
				'urls' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'url' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
					'hash' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64),
					'created' => array('type' => 'datetime', 'null' => true),
					'created_by' => array('type' => 'integer', 'null' => true),
					'updated' => array('type' => 'datetime', 'null' => true),
					'updated_by' => array('type' => 'integer', 'null' => true),
					'indexes' => array(
						'PRIMARY' => array('column' => array('id'), 'unique' => true),
						'ix_urls_hash' => array('column' => array('hash')),
					),
					'tableParameters' => array(
						'charset' => 'utf8',
						'collate' => 'utf8_unicode_ci',
						'engine' => 'InnoDb',
					),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'urls',
			),
		)
	);

	public function before($direction) {
		return true;
	}

	public function after($direction) {
		return true;
	}

}
