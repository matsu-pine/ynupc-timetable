<?php
class Schedule extends AppModel {
	var $name = 'Schedule';

	public $valiate = array(
			'period_id' => array(
					'rule' => 'notEmpty'
			)
	);
}
?>
