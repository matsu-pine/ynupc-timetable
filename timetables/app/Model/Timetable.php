<?php
class Timetable extends AppModel {
	var $name = 'Timetable';

	public $hasMany = array(
			'Period' => array(
					'className' => 'Period',
					'order' => array(
							'Period.period' => 'ASC',
							'Period.weekday' => 'ASC'
					),
					'dependent' => true
			)
	);

	public function getListPoint($span, $location){
		$option = array(
				'conditions' => array(
						'Timetable.season' => $span,
						'Timetable.room_id' => $location
				)
		);
		return $this->find('all', $option);
	}

	public function getListInput($span, $location, $period ,$weekday){
		$option = array(
				'conditions' => array(
						'Timetable.season' => $span,
						'Timetable.room_id' => $location
				)
		);
		$this->hasMany['Period']['conditions'] = Array(
				'Period.period' => $period,
				'Period.weekday' => $weekday
		);
		return $this->find('all', $option);
	}
}
?>
