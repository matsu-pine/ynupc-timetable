<?php
class AppSchema extends CakeSchema {
	var $name = '';
	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}
	
	public $seasons = array(
			'id' => array(
					'type' => 'integer',
					'null' => false,
					'default' => NULL,
					'length' => 11,
					'key' => 'primary',
					'extra' => 'auto_increment'
			),
			'season' => array(
					'type' => 'integer',
					'null' => true,
					'default' => NULL,
					'length' => 11,
			),
			'begin' => array(
					'type' => 'date',
					'null' => true,
					'default' => NULL,
			),
			'end' => array(
					'type' => 'date',
					'null' => true,
					'default' => NULL,
			),
			'tableParameters' => array(
					'charset' => 'utf8',
					'collate' => 'utf8_general_ci',
					'engine' => 'InnoDB'
			)
	);

	public $timetables = array(
			'id' => array(
					'type' => 'integer',
					'null' => false,
					'default' => NULL,
					'length' => 11,
					'key' => 'primary',
					'extra' => 'auto_increment'
			),
			'season' => array(
					'type' => 'integer',
					'null' => false,
					'default' => NULL,
					'length' => 11,
			),
			'room_id' => array(
					'type' => 'integer',
					'null' => false,
					'default' => NULL,
					'length' => 11,
			),
			'indexes' => array(
					'PRIMARY' => array(
							'column' => 'id',
							'unique' => true
					),
			),
			'tableParameters' => array(
					'charset' => 'utf8',
					'collate' => 'utf8_general_ci',
					'engine' => 'InnoDB'
			)
	);

	public $periods = array(
			'id' => array(
					'type' => 'integer',
					'null' => false,
					'default' => NULL,
					'length' => 11,
					'key' => 'primary',
					'extra' => 'auto_increment'
			),
			'timetable_id' => array(
					'type' => 'integer',
					'null' => false,
					'default' => NULL,
					'length' => 11
			),
			'period' => array(
					'type' => 'integer',
					'null' => false,
					'default' => NULL,
					'length' => 11
			),
			'weekday' => array(
					'type' => 'integer',
					'null' => false,
					'default' => NULL,
					'length' => 11
			),
			'priority' => array(
					'type' => 'integer',
					'null' => false,
					'default' => NULL,
					'length' => 11
			),
			'name' => array(
					'type' => 'string',
					'null' => false,
					'default' => NULL,
					'length' => 255,
					'collate' => 'utf8_general_ci',
					'charset' => 'utf8'
			),
			'lecturer' => array(
					'type' => 'string',
					'null' => false,
					'default' => NULL,
					'length' => 255,
					'collate' => 'utf8_general_ci',
					'charset' => 'utf8'
			),
			'num_of_student' => array(
					'type' => 'integer',
					'null' => false,
					'default' => NULL,
					'length' => 11
			),
			'indexes' => array(
					'PRIMARY' => array(
							'column' => 'id',
							'unique' => true
					)
			),
			'tableParameters' => array(
					'charset' => 'utf8',
					'collate' => 'utf8_general_ci',
					'engine' => 'InnoDB'
			)
	);
	
	public $schedules = array(
			'id' => array(
					'type' => 'integer',
					'null' => false,
					'default' => NULL,
					'length' => 11,
					'key' => 'primary',
					'extra' => 'auto_increment'
			),
			'period_id' => array(
					'type' => 'integer',
					'null' => false,
					'default' => NULL,
					'length' => 11,
			),
			'begin' => array(
					'type' => 'date',
					'null' => false,
					'default' => NULL,
			),
			'end' => array(
					'type' => 'date',
					'null' => false,
					'default' => NULL,
			),
			'indexes' => array(
					'PRIMARY' => array(
							'column' => 'id',
							'unique' => true
					),
			),
			'tableParameters' => array(
					'charset' => 'utf8',
					'collate' => 'utf8_general_ci',
					'engine' => 'InnoDB'
			)
	);
}
?>