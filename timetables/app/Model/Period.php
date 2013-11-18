<?php
App::uses('AppModel', 'Model');
/**
 * Period Model
 *
 * @property Timetable $Timetable
 * @property Schedule $Schedule
*/
class Period extends AppModel {

	public $validate = array(
			'name' => array(
					'rule' => array('maxLength', 100),
					'required' => true,
					'allowEmpty' => false,
					'message' => '講義名を入力してください'
 			),
			'lecturer' => array(
					'rule' => array('maxLength', 100),
					'required' => true,
					'allowEmpty' => false,
					'message' => '講師を入力してください'
			),
			'num_of_student' => array(
					'rule' => 'numeric',
					'required' => true,
					'allowEmpty' => false,
					'message' => '受講者数を入力してください'
			)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	*/
	public $belongsTo = array(
			'Timetable' => array(
					'className' => 'Timetable',
					'foreignKey' => 'timetable_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			)
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	*/
	public $hasMany = array(
			'Schedule' => array(
					'className' => 'Schedule',
					'foreignKey' => 'period_id',
					'dependent' => false,
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQuery' => '',
					'dependent' => true
			)
	);

}
