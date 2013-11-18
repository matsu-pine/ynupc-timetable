<?php
class TimetablesController extends AppController {
	public $helpers = array("Html", "Form");
	var $name = "Timetables";
	public $uses = array('Timetable', 'Season');

	public function index() {
		$this->set("title_for_layout", "期間選択");
		$spans = array("春期", "夏期休暇", "秋期", "冬期休暇", "春期休暇");
		$this->set("spans", $spans);
		$tt_data = $this->Season->find('all');
		$this->set('seasons', $tt_data);
		if ($this->request->is('post')) {
			$set_data = $this->Season->find('all');
			//debug($set_data);
			//debug($set_data[0]);
			//debug($_POST);
			for ($i = 1; $i <= 3; $i++) {
				$j = $i + 1;
				if($_POST['data']["begin$i"] >= $_POST['data']["begin$j"]){
					$this->Session->setFlash('入力に誤りがあります。');
					$this->render('index');
					return;
				}
			}
			if($_POST['data']['begin5'] >= $_POST['data']['begin3'] || $_POST['data']['end4'] >= $_POST['data']['begin5']){
				$this->Session->setFlash('入力に誤りがあります。');
				$this->render('index');
				return;
			}
			$data = array();
			for ($i = 1; $i <= 5; $i++) {
				if ($i == 4) {
					if($_POST['data']['end4'] >= $_POST['data']['begin4']) {
						$this->Session->setFlash('入力に誤りがあります。');
						$this->render('index');
						return;
					} else {
						$begin = array('year' => 8);
						$begin['month'] = $_POST['data']['begin4']['month'];
						$begin['day'] = $_POST['data']['begin4']['day'];
						$end = array('year' => 8);
						$end['month'] = $_POST['data']['end4']['month'];
						$end['day'] = $_POST['data']['end4']['day'];
						if($set_data){
							$data[] = array(
									'Season' => array(
											'id' => $set_data[$i - 1]['Season']['id'],
											'season' => $i,
											'begin' => $begin,
											'end' => $end
									)
							);
						} else {
							$data[] = array(
									'Season' => array(
											'id' => '',
											'season' => $i,
											'begin' => $begin,
											'end' => $end
									)
							);
						}
					}
				} else if($i == 5){
					if($_POST['data']['begin5'] >= $_POST['data']['end5']) {
						$this->Session->setFlash('入力に誤りがあります。');
						$this->render('index');
						return;
					} else {
						$begin = array('year' => 8);
						$begin['month'] = $_POST['data']['begin5']['month'];
						$begin['day'] = $_POST['data']['begin5']['day'];
						$end = array('year' => 8);
						$end['month'] = $_POST['data']['end5']['month'];
						$end['day'] = $_POST['data']['end5']['day'];
						if($set_data){
							$data[] = array(
									'Season' => array(
											'id' => $set_data[$i - 1]['Season']['id'],
											'season' => $i,
											'begin' => $begin,
											'end' => $end
									)
							);
						} else {
							$data[] = array(
									'Season' => array(
											'id' => '',
											'season' => $i,
											'begin' => $begin,
											'end' => $end
									)
							);
						}
					}
				} else {
					$begin = array('year' => 8);
					$begin['month'] = $_POST['data']["begin$i"]['month'];
					$begin['day'] = $_POST['data']["begin$i"]['day'];
					if($set_data){
						$data[] = array(
								'Season' => array(
										'id' => $set_data[$i - 1]['Season']['id'],
										'season' => $i,
										'begin' => $begin,
										'end' => array(
												'year' => '',
												'month' => '',
												'day' => ''
										)
								)
						);
					} else {
						$data[] = array(
								'Season' => array(
										'id' => '',
										'season' => $i,
										'begin' => $begin,
										'end' => array(
												'year' => '',
												'month' => '',
												'day' => ''
										)
								)
						);
					}
				}
			}
			$this->Season->saveMany($data);
		}
	}

	public function view_location() {
		$this->set("title_for_layout", "教室選択");
		$spans = array("春期", "夏期休暇", "秋期", "冬期休暇", "春期休暇");
		$this->set("spans", $spans);
		$locations = array("パソコン教室A", "パソコン教室B", "パソコン教室CD", "パソコン教室E", "パソコン教室F", "?", "??", "???", "????");
		$this->set("locations", $locations);
	}

	public function view_lecture(){
		$span = $_GET["span"];
		$this->set("span", $span);
		$location = $_GET["location"];
		$this->set("location", $location);
		$this->Timetable->recursive = 2;
		$tt_data = $this->Timetable->getListPoint($span, $location);
		if(count($tt_data)){
			$tt_data = $tt_data[0]["Period"];
		}
		$this->set("timetables", $tt_data);
		$this->set("title_for_layout", "講義選択");
		$spans = array("春期", "夏期休暇", "秋期", "冬期休暇", "春期休暇");
		$this->set("spans", $spans);
		$locations = array("パソコン教室A", "パソコン教室B", "パソコン教室CD", "パソコン教室E", "パソコン教室F", "?", "??", "???", "????");
		$this->set("locations", $locations);
		$weekdays = array("月", "火", "水", "木", "金");
		$this->set("weekdays", $weekdays);
		$periods_begin = array("8:50", "10:30", "13:00", "14:40", "16:15", "17:50" ,"19:25");
		$this->set("periods_begin", $periods_begin);
		$periods_end = array("10:20", "12:00", "14:30", "16:10", "17:45", "19:20" ,"20:55");
		$this->set("periods_end", $periods_end);
	}

	public function view_input(){
		$span = $_GET["span"];
		$this->set("span", $span);
		$location = $_GET["location"];
		$this->set("location", $location);
		$period = $_GET["period"];
		$this->set("period", $period);
		$weekday = $_GET["weekday"];
		$this->set("weekday", $weekday);
		$this->Timetable->recursive = 2;
		$tt_data = $this->Timetable->getListInput($span, $location, $period, $weekday);
		if(count($tt_data)){
			$tt_data = $tt_data[0]["Period"];
		}
		$this->set("timetables", $tt_data);
		$this->set("title_for_layout", "情報入力");
		$spans = array("春期", "夏期休暇", "秋期", "冬期休暇", "春期休暇");
		$this->set("spans", $spans);
		$locations = array("パソコン教室A", "パソコン教室B", "パソコン教室CD", "パソコン教室E", "パソコン教室F", "?", "??", "???", "????");
		$this->set("locations", $locations);
		$weekdays = array("月", "火", "水", "木", "金");
		$this->set("weekdays", $weekdays);
		$this->set("flag", 0);

		if ($this->request->is('post')) {
			$set_data = $this->Timetable->getListPoint($span, $location);
			//debug($set_data);
			//debug($set_data[0]);
			//debug($_POST);
			if($set_data){
				if ($set_data[0]['Period']) {
					$exist_num = count($set_data[0]['Period']);
					if ($exist_num < $_POST['num_field']) {
						for ($i = 1; $i <= $exist_num; $i++) {
							$span_data = array();
							$sort_span = array();
							$s_id = array();
							$span_num = count($set_data[0]['Period'][$i - 1]['Schedule']);
							for ($j = 1; $j <= $_POST["num_span$i"]; $j++) {
								if ($span == 3) {
									if($_POST['data']["begin{$i}{$j}"]['month'] <= 6){
										$sort_span["$j"]["span"] = "1".$_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
										
									} else {
										$sort_span["$j"]["span"] = $_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
									}
									if($_POST['data']["end{$i}{$j}"]['month'] <= 6){
										$sort_span["$j"]["span2"] = "1".$_POST['data']["end{$i}{$j}"]['month'].$_POST['data']["end{$i}{$j}"]['day'];
									
									} else {
										$sort_span["$j"]["span2"] = $_POST['data']["end{$i}{$j}"]['month'].$_POST['data']["end{$i}{$j}"]['day'];
									}
								} else {
									$sort_span["$j"]["span"] = $_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
								}
								$sort_span["$j"]["id"] = $j;
								$sort_span["$j"]["begin"] = $_POST['data']["begin{$i}{$j}"];
								$sort_span["$j"]["end"] = $_POST['data']["end{$i}{$j}"];
							}
							foreach($sort_span as $key => $value){
							    $s_id[$key] = $value['span'];
							}
							array_multisort($s_id, SORT_ASC, $sort_span);
							if ($span == 3) {
								for ($j = 0; $j < $_POST["num_span$i"] - 1; $j++) {
									$jj = $j + 1;
									debug($sort_span);
									if ($sort_span["$j"]["span2"] < 10000 && $sort_span["$jj"]["span"] >= 10000){
										if ($sort_span[$j]['end'] <= $sort_span[$j + 1]['begin']){
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									} else {
										if ($sort_span[$j]['end'] >= $sort_span[$j + 1]['begin']){
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
								}
							} else {
								for ($j = 0; $j < $_POST["num_span$i"] - 1; $j++) {
									if ($sort_span[$j]['end'] >= $sort_span[$j + 1]['begin']){
										$this->Session->setFlash('入力に誤りがあります。');
										$this->render('view_input');
										return;
									}
								}
							}
							if ($span_num < $_POST["num_span$i"]) {
								for ($j = 1; $j <= $span_num; $j++) {
									if ($span == 3) {
										if ($sort_span[$j - 1]["span"] < 10000 && $sort_span[$j - 1]["span2"] >= 10000) {
											if ($sort_span[$j - 1]['begin'] < $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										} else {
											if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										}
									} else {
										if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
									$begin = array('year' => 8);
									$begin['month'] = $sort_span[$j - 1]['begin']['month'];
									$begin['day'] = $sort_span[$j - 1]['begin']['day'];
									$end = array('year' => 8);
									$end['month'] = $sort_span[$j - 1]['end']['month'];
									$end['day'] = $sort_span[$j - 1]['end']['day'];
									$span_data['Schedule'][] = array(
											'id' => $set_data[0]['Period'][$i - 1]['Schedule'][$j - 1]['id'],
											'period_id' => $this->Timetable->Period->id,
											'begin' => $begin,
											'end' => $end
									);
								}
								for ($j = $span_num + 1; $j <= $_POST["num_span$i"]; $j++) {
									if ($span == 3) {
										if ($sort_span[$j - 1]["span"] < 10000 && $sort_span[$j - 1]["span2"] >= 10000) {
											if ($sort_span[$j - 1]['begin'] < $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										} else {
											if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										}
									} else {
										if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
									$begin = array('year' => 8);
									$begin['month'] = $sort_span[$j - 1]['begin']['month'];
									$begin['day'] = $sort_span[$j - 1]['begin']['day'];
									$end = array('year' => 8);
									$end['month'] = $sort_span[$j - 1]['end']['month'];
									$end['day'] = $sort_span[$j - 1]['end']['day'];
									$span_data['Schedule'][] = array(
											'id' => $set_data[0]['Period'][$i - 1]['Schedule'][$j - 1]['id'],
											'period_id' => $this->Timetable->Period->id,
											'begin' => $begin,
											'end' => $end
									);
								}
							} else if ($span_num == $_POST["num_span$i"]) {
								for ($j = 1; $j <= $_POST["num_span$i"]; $j++) {
									if ($span == 3) {
										if ($sort_span[$j - 1]["span"] < 10000 && $sort_span[$j - 1]["span2"] >= 10000) {
											if ($sort_span[$j - 1]['begin'] < $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										} else {
											if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										}
									} else {
										if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
									$begin = array('year' => 8);
									$begin['month'] = $sort_span[$j - 1]['begin']['month'];
									$begin['day'] = $sort_span[$j - 1]['begin']['day'];
									$end = array('year' => 8);
									$end['month'] = $sort_span[$j - 1]['end']['month'];
									$end['day'] = $sort_span[$j - 1]['end']['day'];
									$span_data['Schedule'][] = array(
											'id' => $set_data[0]['Period'][$i - 1]['Schedule'][$j - 1]['id'],
											'period_id' => $this->Timetable->Period->id,
											'begin' => $begin,
											'end' => $end
									);
								}
							} else {
								for ($j = 1; $j <= $_POST["num_span$i"]; $j++) {
									if ($span == 3) {
										if ($sort_span[$j - 1]["span"] < 10000 && $sort_span[$j - 1]["span2"] >= 10000) {
											if ($sort_span[$j - 1]['begin'] < $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										} else {
											if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										}
									} else {
										if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
									$begin = array('year' => 8);
									$begin['month'] = $sort_span[$j - 1]['begin']['month'];
									$begin['day'] = $sort_span[$j - 1]['begin']['day'];
									$end = array('year' => 8);
									$end['month'] = $sort_span[$j - 1]['end']['month'];
									$end['day'] = $sort_span[$j - 1]['end']['day'];
									$span_data['Schedule'][] = array(
											'id' => $set_data[0]['Period'][$i - 1]['Schedule'][$j - 1]['id'],
											'period_id' => $this->Timetable->Period->id,
											'begin' => $begin,
											'end' => $end
									);
								}
								for ($j = $_POST["num_span$i"]; $j < $span_num; $j++) {
									$this->Timetable->Period->Schedule->delete($set_data[0]['Period'][$i - 1]['Schedule'][$j]['id'], true);
								}
							}
							$period_data['Period'][] = array(
									'id' => $set_data[0]['Period'][$i - 1]['id'],
									'timetable_id' => $set_data[0]['Timetable']['id'],
									'period' => $period,
									'weekday' => $weekday,
									'priority' => $i,
									'name' => $_POST["name$i"],
									'lecturer' => $_POST["lecturer$i"],
									'num_of_student' => $_POST["student$i"],
									'Schedule' => $span_data['Schedule']
							);
						}
						for ($i = $exist_num + 1; $i <= $_POST['num_field']; $i++) {
							$span_data = array();
							$sort_span = array();
							$s_id = array();
							$span_num = $_POST["num_span$i"];
							for ($j = 1; $j <= $_POST["num_span$i"]; $j++) {
								if ($span == 3) {
									if($_POST['data']["begin{$i}{$j}"]['month'] <= 6){
										$sort_span["$j"]["span"] = "1".$_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
										
									} else {
										$sort_span["$j"]["span"] = $_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
									}
									if($_POST['data']["end{$i}{$j}"]['month'] <= 6){
										$sort_span["$j"]["span2"] = "1".$_POST['data']["end{$i}{$j}"]['month'].$_POST['data']["end{$i}{$j}"]['day'];
									
									} else {
										$sort_span["$j"]["span2"] = $_POST['data']["end{$i}{$j}"]['month'].$_POST['data']["end{$i}{$j}"]['day'];
									}
								} else {
									$sort_span["$j"]["span"] = $_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
								}
								$sort_span["$j"]["id"] = $j;
								$sort_span["$j"]["begin"] = $_POST['data']["begin{$i}{$j}"];
								$sort_span["$j"]["end"] = $_POST['data']["end{$i}{$j}"];
							}
							foreach($sort_span as $key => $value){
							    $s_id[$key] = $value['span'];
							}
							array_multisort($s_id, SORT_ASC, $sort_span);
							if ($span == 3) {
								for ($j = 0; $j < $_POST["num_span$i"] - 1; $j++) {
									$jj = $j + 1;
									debug($sort_span);
									if ($sort_span["$j"]["span2"] < 10000 && $sort_span["$jj"]["span"] >= 10000){
										if ($sort_span[$j]['end'] <= $sort_span[$j + 1]['begin']){
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									} else {
										if ($sort_span[$j]['end'] >= $sort_span[$j + 1]['begin']){
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
								}
							} else {
								for ($j = 0; $j < $_POST["num_span$i"] - 1; $j++) {
									if ($sort_span[$j]['end'] >= $sort_span[$j + 1]['begin']){
										$this->Session->setFlash('入力に誤りがあります。');
										$this->render('view_input');
										return;
									}
								}
							}
							for ($j = 1; $j <= $span_num; $j++) {
								if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
									
									$this->Session->setFlash('入力に誤りがあります。');
									$this->render('view_input');
									return;
								}
								$begin = array('year' => 8);
								$begin['month'] = $sort_span[$j - 1]['begin']['month'];
								$begin['day'] = $sort_span[$j - 1]['begin']['day'];
								$end = array('year' => 8);
								$end['month'] = $sort_span[$j - 1]['end']['month'];
								$end['day'] = $sort_span[$j - 1]['end']['day'];
								$span_data['Schedule'][] = array(
										'id' => "",
										'period_id' => $this->Timetable->Period->id,
										'begin' => $begin,
										'end' => $end
								);
							}
							$period_data['Period'][] = array(
									'id' => "",
									'timetable_id' => $set_data[0]['Timetable']['id'],
									'period' => $period,
									'weekday' => $weekday,
									'priority' => $i,
									'name' => $_POST["name$i"],
									'lecturer' => $_POST["lecturer$i"],
									'num_of_student' => $_POST["student$i"],
									'Schedule' => $span_data['Schedule']
							);
						}
						$data = array(
								'Timetable' => array(
										'id' => $set_data[0]['Timetable']['id'],
										'season' => $span,
										'room_id' => $location,
								),
								'Period' => $period_data['Period']
						);
						$id = $this->Timetable->saveAssociated($data, array('deep' => true));
						if ($id === false) {
							$this->Session->setFlash('入力に誤りがあります。');
							$this->render('view_input');
							return;
						}
					} else if ($exist_num == $_POST['num_field']) {
						for ($i = 1; $i <= $exist_num; $i++) {
							$span_data = array();
							$sort_span = array();
							$s_id = array();
							$span_num = count($set_data[0]['Period'][$i - 1]['Schedule']);
							for ($j = 1; $j <= $_POST["num_span$i"]; $j++) {
								if ($span == 3) {
									if($_POST['data']["begin{$i}{$j}"]['month'] <= 6){
										$sort_span["$j"]["span"] = "1".$_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
										
									} else {
										$sort_span["$j"]["span"] = $_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
									}
									if($_POST['data']["end{$i}{$j}"]['month'] <= 6){
										$sort_span["$j"]["span2"] = "1".$_POST['data']["end{$i}{$j}"]['month'].$_POST['data']["end{$i}{$j}"]['day'];
									
									} else {
										$sort_span["$j"]["span2"] = $_POST['data']["end{$i}{$j}"]['month'].$_POST['data']["end{$i}{$j}"]['day'];
									}
								} else {
									$sort_span["$j"]["span"] = $_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
								}
								$sort_span["$j"]["id"] = $j;
								$sort_span["$j"]["begin"] = $_POST['data']["begin{$i}{$j}"];
								$sort_span["$j"]["end"] = $_POST['data']["end{$i}{$j}"];
							}
							foreach($sort_span as $key => $value){
							    $s_id[$key] = $value['span'];
							}
							array_multisort($s_id, SORT_ASC, $sort_span);
							if ($span == 3) {
								for ($j = 0; $j < $_POST["num_span$i"] - 1; $j++) {
									$jj = $j + 1;
									debug($sort_span);
									if ($sort_span["$j"]["span2"] < 10000 && $sort_span["$jj"]["span"] >= 10000){
										if ($sort_span[$j]['end'] <= $sort_span[$j + 1]['begin']){
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									} else {
										if ($sort_span[$j]['end'] >= $sort_span[$j + 1]['begin']){
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
								}
							} else {
								for ($j = 0; $j < $_POST["num_span$i"] - 1; $j++) {
									if ($sort_span[$j]['end'] >= $sort_span[$j + 1]['begin']){
										$this->Session->setFlash('入力に誤りがあります。');
										$this->render('view_input');
										return;
									}
								}
							}
							if ($span_num < $_POST["num_span$i"]) {
								for ($j = 1; $j <= $span_num; $j++) {
									if ($span == 3) {
										if ($sort_span[$j - 1]["span"] < 10000 && $sort_span[$j - 1]["span2"] >= 10000) {
											if ($sort_span[$j - 1]['begin'] < $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										} else {
											if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										}
									} else {
										if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
									$begin = array('year' => 8);
									$begin['month'] = $sort_span[$j - 1]['begin']['month'];
									$begin['day'] = $sort_span[$j - 1]['begin']['day'];
									$end = array('year' => 8);
									$end['month'] = $sort_span[$j - 1]['end']['month'];
									$end['day'] = $sort_span[$j - 1]['end']['day'];
									$span_data['Schedule'][] = array(
											'id' => $set_data[0]['Period'][$i - 1]['Schedule'][$j - 1]['id'],
											'period_id' => $this->Timetable->Period->id,
											'begin' => $begin,
											'end' => $end
									);
								}
								for ($j = $span_num + 1; $j <= $_POST["num_span$i"]; $j++) {
									if ($span == 3) {
										if ($sort_span[$j - 1]["span"] < 10000 && $sort_span[$j - 1]["span2"] >= 10000) {
											if ($sort_span[$j - 1]['begin'] < $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										} else {
											if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										}
									} else {
										if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
									$begin = array('year' => 8);
									$begin['month'] = $sort_span[$j - 1]['begin']['month'];
									$begin['day'] = $sort_span[$j - 1]['begin']['day'];
									$end = array('year' => 8);
									$end['month'] = $sort_span[$j - 1]['end']['month'];
									$end['day'] = $sort_span[$j - 1]['end']['day'];
									$span_data['Schedule'][] = array(
											'id' => "",
											'period_id' => $this->Timetable->Period->id,
											'begin' => $begin,
											'end' => $end
									);
								}
							} else if ($span_num == $_POST["num_span$i"]) {
								for ($j = 1; $j <= $_POST["num_span$i"]; $j++) {
									if ($span == 3) {
										if ($sort_span[$j - 1]["span"] < 10000 && $sort_span[$j - 1]["span2"] >= 10000) {
											if ($sort_span[$j - 1]['begin'] < $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										} else {
											if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										}
									} else {
										if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
									$begin = array('year' => 8);
									$begin['month'] = $sort_span[$j - 1]['begin']['month'];
									$begin['day'] = $sort_span[$j - 1]['begin']['day'];
									$end = array('year' => 8);
									$end['month'] = $sort_span[$j - 1]['end']['month'];
									$end['day'] = $sort_span[$j - 1]['end']['day'];
									$span_data['Schedule'][] = array(
											'id' => $set_data[0]['Period'][$i - 1]['Schedule'][$j - 1]['id'],
											'period_id' => $this->Timetable->Period->id,
											'begin' => $begin,
											'end' => $end
									);
								}
							} else {
								for ($j = 1; $j <= $_POST["num_span$i"]; $j++) {
									if ($span == 3) {
										if ($sort_span[$j - 1]["span"] < 10000 && $sort_span[$j - 1]["span2"] >= 10000) {
											if ($sort_span[$j - 1]['begin'] < $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										} else {
											if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										}
									} else {
										if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
									$begin = array('year' => 8);
									$begin['month'] = $sort_span[$j - 1]['begin']['month'];
									$begin['day'] = $sort_span[$j - 1]['begin']['day'];
									$end = array('year' => 8);
									$end['month'] = $sort_span[$j - 1]['end']['month'];
									$end['day'] = $sort_span[$j - 1]['end']['day'];
									$span_data['Schedule'][] = array(
											'id' => $set_data[0]['Period'][$i - 1]['Schedule'][$j - 1]['id'],
											'period_id' => $this->Timetable->Period->id,
											'begin' => $begin,
											'end' => $end
									);
								}
								for ($j = $_POST["num_span$i"]; $j < $span_num; $j++) {
									$this->Timetable->Period->Schedule->delete($set_data[0]['Period'][$i - 1]['Schedule'][$j]['id'], true);
								}
							}
							$period_data['Period'][] = array(
									'id' => $set_data[0]['Period'][$i - 1]['id'],
									'timetable_id' => $set_data[0]['Timetable']['id'],
									'period' => $period,
									'weekday' => $weekday,
									'priority' => $i,
									'name' => $_POST["name$i"],
									'lecturer' => $_POST["lecturer$i"],
									'num_of_student' => $_POST["student$i"],
									'Schedule' => $span_data['Schedule']
							);
						}
						$data = array(
								'Timetable' => array(
										'id' => $set_data[0]['Timetable']['id'],
										'season' => $span,
										'room_id' => $location,
								),
								'Period' => $period_data['Period']
						);
						$id = $this->Timetable->saveAssociated($data, array('deep' => true));
						if ($id === false) {
							$this->Session->setFlash('入力に誤りがあります。');
							$this->render('view_input');
							return;
						}
					} else {
						for ($i = 1; $i <= $_POST['num_field']; $i++) {
							$span_data = array();
							$sort_span = array();
							$s_id = array();
							$span_num = count($set_data[0]['Period'][$i - 1]['Schedule']);
							for ($j = 1; $j <= $_POST["num_span$i"]; $j++) {
								if ($span == 3) {
									if($_POST['data']["begin{$i}{$j}"]['month'] <= 6){
										$sort_span["$j"]["span"] = "1".$_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
										
									} else {
										$sort_span["$j"]["span"] = $_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
									}
									if($_POST['data']["end{$i}{$j}"]['month'] <= 6){
										$sort_span["$j"]["span2"] = "1".$_POST['data']["end{$i}{$j}"]['month'].$_POST['data']["end{$i}{$j}"]['day'];
									
									} else {
										$sort_span["$j"]["span2"] = $_POST['data']["end{$i}{$j}"]['month'].$_POST['data']["end{$i}{$j}"]['day'];
									}
								} else {
									$sort_span["$j"]["span"] = $_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
								}
								$sort_span["$j"]["id"] = $j;
								$sort_span["$j"]["begin"] = $_POST['data']["begin{$i}{$j}"];
								$sort_span["$j"]["end"] = $_POST['data']["end{$i}{$j}"];
							}
							foreach($sort_span as $key => $value){
							    $s_id[$key] = $value['span'];
							}
							array_multisort($s_id, SORT_ASC, $sort_span);
							if ($span == 3) {
								for ($j = 0; $j < $_POST["num_span$i"] - 1; $j++) {
									$jj = $j + 1;
									debug($sort_span);
									if ($sort_span["$j"]["span2"] < 10000 && $sort_span["$jj"]["span"] >= 10000){
										if ($sort_span[$j]['end'] <= $sort_span[$j + 1]['begin']){
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									} else {
										if ($sort_span[$j]['end'] >= $sort_span[$j + 1]['begin']){
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
								}
							} else {
								for ($j = 0; $j < $_POST["num_span$i"] - 1; $j++) {
									if ($sort_span[$j]['end'] >= $sort_span[$j + 1]['begin']){
										$this->Session->setFlash('入力に誤りがあります。');
										$this->render('view_input');
										return;
									}
								}
							}
							if ($span_num < $_POST["num_span$i"]) {
								for ($j = 1; $j <= $span_num; $j++) {
									if ($span == 3) {
										if ($sort_span[$j - 1]["span"] < 10000 && $sort_span[$j - 1]["span2"] >= 10000) {
											if ($sort_span[$j - 1]['begin'] < $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										} else {
											if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										}
									} else {
										if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
									$begin = array('year' => 8);
									$begin['month'] = $sort_span[$j - 1]['begin']['month'];
									$begin['day'] = $sort_span[$j - 1]['begin']['day'];
									$end = array('year' => 8);
									$end['month'] = $sort_span[$j - 1]['end']['month'];
									$end['day'] = $sort_span[$j - 1]['end']['day'];
									$span_data['Schedule'][] = array(
											'id' => $set_data[0]['Period'][$i - 1]['Schedule'][$j - 1]['id'],
											'period_id' => $this->Timetable->Period->id,
											'begin' => $begin,
											'end' => $end
									);
								}
								for ($j = $span_num + 1; $j <= $_POST["num_span$i"]; $j++) {
									if ($span == 3) {
										if ($sort_span[$j - 1]["span"] < 10000 && $sort_span[$j - 1]["span2"] >= 10000) {
											if ($sort_span[$j - 1]['begin'] < $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										} else {
											if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										}
									} else {
										if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
									$begin = array('year' => 8);
									$begin['month'] = $sort_span[$j - 1]['begin']['month'];
									$begin['day'] = $sort_span[$j - 1]['begin']['day'];
									$end = array('year' => 8);
									$end['month'] = $sort_span[$j - 1]['end']['month'];
									$end['day'] = $sort_span[$j - 1]['end']['day'];
									$span_data['Schedule'][] = array(
											'id' => $set_data[0]['Period'][$i - 1]['Schedule'][$j - 1]['id'],
											'period_id' => $this->Timetable->Period->id,
											'begin' => $begin,
											'end' => $end
									);
								}
							} else if ($span_num == $_POST["num_span$i"]) {
								for ($j = 1; $j <= $_POST["num_span$i"]; $j++) {
									if ($span == 3) {
										if ($sort_span[$j - 1]["span"] < 10000 && $sort_span[$j - 1]["span2"] >= 10000) {
											if ($sort_span[$j - 1]['begin'] < $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										} else {
											if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										}
									} else {
										if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
									$begin = array('year' => 8);
									$begin['month'] = $sort_span[$j - 1]['begin']['month'];
									$begin['day'] = $sort_span[$j - 1]['begin']['day'];
									$end = array('year' => 8);
									$end['month'] = $sort_span[$j - 1]['end']['month'];
									$end['day'] = $sort_span[$j - 1]['end']['day'];
									$span_data['Schedule'][] = array(
											'id' => $set_data[0]['Period'][$i - 1]['Schedule'][$j - 1]['id'],
											'period_id' => $this->Timetable->Period->id,
											'begin' => $begin,
											'end' => $end
									);
								}
							} else {
								for ($j = 1; $j <= $_POST["num_span$i"]; $j++) {
									if ($span == 3) {
										if ($sort_span[$j - 1]["span"] < 10000 && $sort_span[$j - 1]["span2"] >= 10000) {
											if ($sort_span[$j - 1]['begin'] < $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										} else {
											if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
												$this->Session->setFlash('入力に誤りがあります。');
												$this->render('view_input');
												return;
											}
										}
									} else {
										if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
											$this->Session->setFlash('入力に誤りがあります。');
											$this->render('view_input');
											return;
										}
									}
									$begin = array('year' => 8);
									$begin['month'] = $sort_span[$j - 1]['begin']['month'];
									$begin['day'] = $sort_span[$j - 1]['begin']['day'];
									$end = array('year' => 8);
									$end['month'] = $sort_span[$j - 1]['end']['month'];
									$end['day'] = $sort_span[$j - 1]['end']['day'];
									$span_data['Schedule'][] = array(
											'id' => $set_data[0]['Period'][$i - 1]['Schedule'][$j - 1]['id'],
											'period_id' => $this->Timetable->Period->id,
											'begin' => $begin,
											'end' => $end
									);
								}
								for ($j = $_POST["num_span$i"]; $j < $span_num; $j++) {
									$this->Timetable->Period->Schedule->delete($set_data[0]['Period'][$i - 1]['Schedule'][$j]['id'], true);
								}
							}
							$period_data['Period'][] = array(
									'id' => $set_data[0]['Period'][$i - 1]['id'],
									'timetable_id' => $set_data[0]['Timetable']['id'],
									'period' => $period,
									'weekday' => $weekday,
									'priority' => $i,
									'name' => $_POST["name$i"],
									'lecturer' => $_POST["lecturer$i"],
									'num_of_student' => $_POST["student$i"],
									'Schedule' => $span_data['Schedule']
							);
						}
						for ($i = $_POST['num_field']; $i < $exist_num; $i++) {
							$this->Timetable->Period->delete($set_data[0]['Period'][$i]['id'], true);
						}
						$data = array(
								'Timetable' => array(
										'id' => $set_data[0]['Timetable']['id'],
										'season' => $span,
										'room_id' => $location,
								),
								'Period' => $period_data['Period']
						);
						$id = $this->Timetable->saveAssociated($data, array('deep' => true));
						if ($id === false) {
							$this->Session->setFlash('入力に誤りがあります。');
							$this->render('view_input');
							return;
						}
					}
				} else {
					for ($i = 1; $i <= $_POST['num_field']; $i++) {
						$span_data = array();
						$sort_span = array();
						$s_id = array();
						$span_num = $_POST["num_span$i"];
						for ($j = 1; $j <= $_POST["num_span$i"]; $j++) {
							if ($span == 3) {
								if($_POST['data']["begin{$i}{$j}"]['month'] <= 6){
									$sort_span["$j"]["span"] = "1".$_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
									
								} else {
									$sort_span["$j"]["span"] = $_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
								}
								if($_POST['data']["end{$i}{$j}"]['month'] <= 6){
									$sort_span["$j"]["span2"] = "1".$_POST['data']["end{$i}{$j}"]['month'].$_POST['data']["end{$i}{$j}"]['day'];
								
								} else {
									$sort_span["$j"]["span2"] = $_POST['data']["end{$i}{$j}"]['month'].$_POST['data']["end{$i}{$j}"]['day'];
								}
							} else {
								$sort_span["$j"]["span"] = $_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
							}
							$sort_span["$j"]["id"] = $j;
							$sort_span["$j"]["begin"] = $_POST['data']["begin{$i}{$j}"];
							$sort_span["$j"]["end"] = $_POST['data']["end{$i}{$j}"];
						}
						foreach($sort_span as $key => $value){
						    $s_id[$key] = $value['span'];
						}
						array_multisort($s_id, SORT_ASC, $sort_span);
						if ($span == 3) {
							for ($j = 0; $j < $_POST["num_span$i"] - 1; $j++) {
								$jj = $j + 1;
								debug($sort_span);
								if ($sort_span["$j"]["span2"] < 10000 && $sort_span["$jj"]["span"] >= 10000){
									if ($sort_span[$j]['end'] <= $sort_span[$j + 1]['begin']){
										$this->Session->setFlash('入力に誤りがあります。');
										$this->render('view_input');
										return;
									}
								} else {
									if ($sort_span[$j]['end'] >= $sort_span[$j + 1]['begin']){
										$this->Session->setFlash('入力に誤りがあります。');
										$this->render('view_input');
										return;
									}
								}
							}
						} else {
							for ($j = 0; $j < $_POST["num_span$i"] - 1; $j++) {
								if ($sort_span[$j]['end'] >= $sort_span[$j + 1]['begin']){
									$this->Session->setFlash('入力に誤りがあります。');
									$this->render('view_input');
									return;
								}
							}
						}
						for ($j = 1; $j <= $_POST["num_span$i"]; $j++) {
							if ($span == 3) {
								if ($sort_span[$j - 1]["span"] < 10000 && $sort_span[$j - 1]["span2"] >= 10000) {
									if ($sort_span[$j - 1]['begin'] < $sort_span[$j - 1]['end']) {
										$this->Session->setFlash('入力に誤りがあります。');
										$this->render('view_input');
										return;
									}
								} else {
									if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
										$this->Session->setFlash('入力に誤りがあります。');
										$this->render('view_input');
										return;
									}
								}
							} else {
								if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
									$this->Session->setFlash('入力に誤りがあります。');
									$this->render('view_input');
									return;
								}
							}
							$begin = array('year' => 8);
							$begin['month'] = $sort_span[$j - 1]['begin']['month'];
							$begin['day'] = $sort_span[$j - 1]['begin']['day'];
							$end = array('year' => 8);
							$end['month'] = $sort_span[$j - 1]['end']['month'];
							$end['day'] = $sort_span[$j - 1]['end']['day'];
							$span_data['Schedule'][] = array(
									'id' => '',
									'period_id' => $this->Timetable->Period->id,
									'begin' => $begin,
									'end' => $end
							);
						}
						$period_data['Period'][] = array(
								'id' => '',
								'timetable_id' => $set_data[0]['Timetable']['id'],
								'period' => $period,
								'weekday' => $weekday,
								'priority' => $i,
								'name' => $_POST["name$i"],
								'lecturer' => $_POST["lecturer$i"],
								'num_of_student' => $_POST["student$i"],
								'Schedule' => $span_data['Schedule']
						);
					}
					$data = array(
							'Timetable' => array(
									'id' => $set_data[0]['Timetable']['id'],
									'season' => $span,
									'room_id' => $location,
							),
							'Period' => $period_data['Period']
					);
					$id = $this->Timetable->saveAssociated($data, array('deep' => true));
					if ($id === false) {
						$this->Session->setFlash('入力に誤りがあります。');
						$this->render('view_input');
						return;
					}
				}
			} else {
				for ($i = 1; $i <= $_POST['num_field']; $i++) {
					$span_data = array();
					$sort_span = array();
					$s_id = array();
					$span_num = $_POST["num_span$i"];
					for ($j = 1; $j <= $_POST["num_span$i"]; $j++) {
						if ($span == 3) {
							if($_POST['data']["begin{$i}{$j}"]['month'] <= 6){
								$sort_span["$j"]["span"] = "1".$_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
								
							} else {
								$sort_span["$j"]["span"] = $_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
							}
							if($_POST['data']["end{$i}{$j}"]['month'] <= 6){
								$sort_span["$j"]["span2"] = "1".$_POST['data']["end{$i}{$j}"]['month'].$_POST['data']["end{$i}{$j}"]['day'];
							
							} else {
								$sort_span["$j"]["span2"] = $_POST['data']["end{$i}{$j}"]['month'].$_POST['data']["end{$i}{$j}"]['day'];
							}
						} else {
							$sort_span["$j"]["span"] = $_POST['data']["begin{$i}{$j}"]['month'].$_POST['data']["begin{$i}{$j}"]['day'];
						}
						$sort_span["$j"]["id"] = $j;
						$sort_span["$j"]["begin"] = $_POST['data']["begin{$i}{$j}"];
						$sort_span["$j"]["end"] = $_POST['data']["end{$i}{$j}"];
					}
					foreach($sort_span as $key => $value){
					    $s_id[$key] = $value['span'];
					}
					array_multisort($s_id, SORT_ASC, $sort_span);
					if ($span == 3) {
						for ($j = 0; $j < $_POST["num_span$i"] - 1; $j++) {
							$jj = $j + 1;
							debug($sort_span);
							if ($sort_span["$j"]["span2"] < 10000 && $sort_span["$jj"]["span"] >= 10000){
								if ($sort_span[$j]['end'] <= $sort_span[$j + 1]['begin']){
									$this->Session->setFlash('入力に誤りがあります。');
									$this->render('view_input');
									return;
								}
							} else {
								if ($sort_span[$j]['end'] >= $sort_span[$j + 1]['begin']){
									$this->Session->setFlash('入力に誤りがあります。');
									$this->render('view_input');
									return;
								}
							}
						}
					} else {
						for ($j = 0; $j < $_POST["num_span$i"] - 1; $j++) {
							if ($sort_span[$j]['end'] >= $sort_span[$j + 1]['begin']){
								$this->Session->setFlash('入力に誤りがあります。');
								$this->render('view_input');
								return;
							}
						}
					}
					for ($j = 1; $j <= $_POST["num_span$i"]; $j++) {
						if ($span == 3) {
							if ($sort_span[$j - 1]["span"] < 10000 && $sort_span[$j - 1]["span2"] >= 10000) {
								if ($sort_span[$j - 1]['begin'] < $sort_span[$j - 1]['end']) {
									$this->Session->setFlash('入力に誤りがあります。');
									$this->render('view_input');
									return;
								}
							} else {
								if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
									$this->Session->setFlash('入力に誤りがあります。');
									$this->render('view_input');
									return;
								}
							}
						} else {
							if ($sort_span[$j - 1]['begin'] > $sort_span[$j - 1]['end']) {
								$this->Session->setFlash('入力に誤りがあります。');
								$this->render('view_input');
								return;
							}
						}
						$begin = array('year' => 8);
						$begin['month'] = $sort_span[$j - 1]['begin']['month'];
						$begin['day'] = $sort_span[$j - 1]['begin']['day'];
						$end = array('year' => 8);
						$end['month'] = $sort_span[$j - 1]['end']['month'];
						$end['day'] = $sort_span[$j - 1]['end']['day'];
						$span_data['Schedule'][] = array(
								'id' => '',
								'period_id' => $this->Timetable->Period->id,
								'begin' => $begin,
								'end' => $end
						);
					}
					$period_data['Period'][] = array(
							'id' => '',
							'timetable_id' => $this->Timetable->id,
							'period' => $period,
							'weekday' => $weekday,
							'priority' => $i,
							'name' => $_POST["name$i"],
							'lecturer' => $_POST["lecturer$i"],
							'num_of_student' => $_POST["student$i"],
							'Schedule' => $span_data['Schedule']
					);
				}
				$data = array(
						'Timetable' => array(
								'id' => '',
								'season' => $span,
								'room_id' => $location,
						),
						'Period' => $period_data['Period']
				);
				$id = $this->Timetable->saveAssociated($data, array('deep' => true));
				if ($id === false) {
					$this->Session->setFlash('入力に誤りがあります。');
					$this->render('view_input');
					return;
				}
			}
			$this->set("flag", 1);
		}
	}
}
?>