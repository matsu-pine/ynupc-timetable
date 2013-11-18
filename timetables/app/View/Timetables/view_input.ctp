<?php
echo $this->Html->script("jquery-1.9.1.min");
echo $this->Html->script("jquery.placeholder.1.3.min");
$mux_form_num = 2;$mux_span_num = 32;
$form_num = count($timetables);
if ($form_num == 0) $form_num = 1;
?>
<script type="text/javascript">
$(function() {
    $.Placeholder.init();
});

window.onload = function() {
	var a = <?php echo h($flag) ?>;
	if (a == 1) {
		if(window.opener || !window.opener.closed){
			window.opener.location.reload();
		}
		window.close();
	}
}


var num = 0;
var max_span = <?php echo h($mux_span_num) ?>;

function add_form(inum) {
	if (!document.createElement || !document.getElementById) return;
	if(num == 0){
		num = inum;
	}
	if(num == 1){
		num++;
		document.getElementById('field2').style.display='block';
		document.getElementById('num_field').value=2;
		document.getElementById('add_form').style.visibility='hidden';
		document.getElementById('remove_form').style.visibility='visible';
	}
}

function remove_form(inum) {
	if (!document.createElement || !document.getElementById) return;
	if(num == 0){
		num = inum;
	}
	if(num == 2){
		num--;
		document.getElementById('field2').style.display='none';
		document.getElementById('num_field').value=1;
		document.getElementById('add_form').style.visibility='visible';
		document.getElementById('remove_form').style.visibility='hidden';
	}
}

var num_span = new Array(0, 0);
var start = 4;

function create_sp(inum, ispan, b_month, b_day, e_month, e_day) {
	if (!document.createElement || !document.getElementById) return;
	if(num_span[inum - 1] == 0){
		num_span[inum - 1] = ispan;
		start = 4;
	}
	var change_font = document.getElementById('sum_span' + inum);
	change_font.innerHTML = num_span[inum - 1] + "個表示中";
	var now = new Date();
	var add_p = document.createElement("p");
	add_p.id = "add_p" + inum + "" + start;
	var sep = document.createElement("font");
	sep.size = 4;
	sep.innerHTML = "期間" + start + "：";
	add_p.appendChild(sep);
	sep = document.createElement("font");
	sep.innerHTML = " ";
	add_p.appendChild(sep);
	var ibegin_m = document.createElement("select");
	ibegin_m.id = "begin" + inum + "" + start + "Month";
	ibegin_m.name = "data[" + "begin" + inum + "" + start + "][month]";
	var temp = inum + "" + num_span[inum - 1];
	ibegin_m.onchange = function(){
		change_day(0, temp);
	}
	for (i = 1; i <= 12; i++) {
		if (i < 10) {
			ibegin_m.options[i - 1] = new Option("0" + i, "0" + i);
		} else {
			ibegin_m.options[i - 1] = new Option(i, i);
		}
		if (i == b_month) {
			ibegin_m.options[i - 1].selected = 'selected';
		}
	}
	add_p.appendChild(ibegin_m);
	sep = document.createElement("font");
	sep.innerHTML = " / ";
	add_p.appendChild(sep);
	var ibegin_d = document.createElement("select");
	ibegin_d.id = "begin" + inum + "" + start + "Day";
	ibegin_d.name = "data[" + "begin" + inum + "" + start +"][day]";
	var m = b_month;
	if (m == 2) {
		var last = 29;
	} else if (m == 4 || m == 6 || m == 9 || m == 11){
		var last = 30;
	} else {
		var last = 31;
	}
	for (i = 1; i <= last; i++) {
		if (i < 10) {
			ibegin_d.options[i - 1] = new Option(i, "0" + i);
		} else {
			ibegin_d.options[i - 1] = new Option(i, i);
		}
		if (i == b_day) {
			ibegin_d.options[i - 1].selected = 'selected';
		}
	}
	add_p.appendChild(ibegin_d);
	sep = document.createElement("font");
	sep.innerHTML = " - ";
	add_p.appendChild(sep);
	var iend_m = document.createElement("select");
	iend_m.id = "end" + inum + "" + start + "Month";
	iend_m.name = "data[" + "end" + inum + "" + start +"][month]";
	iend_m.onchange = function(){
		change_day(1, temp);
	}
	for (i = 1; i <= 12; i++) {
		if (i < 10) {
			iend_m.options[i - 1] = new Option("0" + i, "0" + i);
		} else {
			iend_m.options[i - 1] = new Option(i, i);
		}
		if (i == e_month) {
			iend_m.options[i - 1].selected = 'selected';
		}
	}
	add_p.appendChild(iend_m);
	sep = document.createElement("font");
	sep.innerHTML = " / ";
	add_p.appendChild(sep);
	var iend_d = document.createElement("select");
	iend_d.id = "end" + inum + "" + start + "Day";
	iend_d.name = "data[" + "end" + inum + start +"][day]";
	var m = e_month;
	if (m == 2) {
		var last = 29;
	} else if (m == 4 || m == 6 || m == 9 || m == 11){
		var last = 30;
	} else {
		var last = 31;
	}
	for (i = 1; i <= last; i++) {
		if (i < 10) {
			iend_d.options[i - 1] = new Option(i, "0" + i);
		} else {
			iend_d.options[i - 1] = new Option(i, i);
		}
		if (i == e_day) {
			iend_d.options[i - 1].selected = 'selected';
		}
	}
	add_p.appendChild(iend_d);
	add_p.appendChild(document.createElement("br"));
	var add_space = document.getElementById("add_space" + inum).appendChild(add_p);
	if(start == max_span){
		document.getElementById("add_span" + inum).style.visibility='hidden';
	}
	start++;
}

function add_sp(inum, ispan) {
	if (!document.createElement || !document.getElementById) return;
	if(num_span[inum - 1] == 0){
		num_span[inum - 1] = ispan;
	}
	if(num_span[inum - 1] < max_span){
		num_span[inum - 1]++;
		if (num_span[inum - 1] == 2) {
			document.getElementById('span' + inum + '2').style.display='block';
		} else if(num_span[inum - 1] == 3){
			document.getElementById('span' + inum + '3').style.display='block';
		}  else {
			var change_font = document.getElementById('sum_span' + inum);
			change_font.innerHTML = num_span[inum - 1] + "個表示中";
			var now = new Date();
			var add_p = document.createElement("p");
			add_p.id = "add_p" + inum + "" + num_span[inum - 1];
			var sep = document.createElement("font");
			sep.size = 4;
			sep.innerHTML = "期間" + num_span[inum - 1] + "：";
			add_p.appendChild(sep);
			sep = document.createElement("font");
			sep.innerHTML = " ";
			add_p.appendChild(sep);
			var ibegin_m = document.createElement("select");
			ibegin_m.id = "begin" + inum + "" + num_span[inum - 1] + "Month";
			ibegin_m.name = "data[" + "begin" + inum + "" + num_span[inum - 1] + "][month]";
			var temp = inum + "" + num_span[inum - 1];
			ibegin_m.onchange = function(){
				change_day(0, temp);
			}
			for (i = 1; i <= 12; i++) {
				if (i < 10) {
					ibegin_m.options[i - 1] = new Option("0" + i, "0" + i);
				} else {
					ibegin_m.options[i - 1] = new Option(i, i);
				}
				if (i == now.getMonth() + 1) {
					ibegin_m.options[i - 1].selected = 'selected';
				}
			}
			add_p.appendChild(ibegin_m);
			sep = document.createElement("font");
			sep.innerHTML = " / ";
			add_p.appendChild(sep);
			var ibegin_d = document.createElement("select");
			ibegin_d.id = "begin" + inum + "" + num_span[inum - 1] + "Day";
			ibegin_d.name = "data[" + "begin" + inum + "" + num_span[inum - 1] +"][day]";
			var m = now.getMonth();
			if (m == 1) {
				var last = 29;
			} else if (m == 3 || m == 5 || m == 8 || m == 10){
				var last = 30;
			} else {
				var last = 31;
			}
			for (i = 1; i <= last; i++) {
				if (i < 10) {
					ibegin_d.options[i - 1] = new Option(i, "0" + i);
				} else {
					ibegin_d.options[i - 1] = new Option(i, i);
				}
				if (i == now.getDate()) {
					ibegin_d.options[i - 1].selected = 'selected';
				}
			}
			add_p.appendChild(ibegin_d);
			sep = document.createElement("font");
			sep.innerHTML = " - ";
			add_p.appendChild(sep);
			var iend_m = document.createElement("select");
			iend_m.id = "end" + inum + "" + num_span[inum - 1] + "Month";
			iend_m.name = "data[" + "end" + inum + "" + num_span[inum - 1] +"][month]";
			iend_m.onchange = function(){
				change_day(1, temp);
			}
			for (i = 1; i <= 12; i++) {
				if (i < 10) {
					iend_m.options[i - 1] = new Option("0" + i, "0" + i);
				} else {
					iend_m.options[i - 1] = new Option(i, i);
				}
				if (i == now.getMonth() + 1) {
					iend_m.options[i - 1].selected = 'selected';
				}
			}
			add_p.appendChild(iend_m);
			sep = document.createElement("font");
			sep.innerHTML = " / ";
			add_p.appendChild(sep);
			var iend_d = document.createElement("select");
			iend_d.id = "end" + inum + "" + num_span[inum - 1] + "Day";
			iend_d.name = "data[" + "end" + inum + "" + num_span[inum - 1] +"][day]";
			var m = now.getMonth();
			if (m == 1) {
				var last = 29;
			} else if (m == 3 || m == 5 || m == 8 || m == 10){
				var last = 30;
			} else {
				var last = 31;
			}
			for (i = 1; i <= last; i++) {
				if (i < 10) {
					iend_d.options[i - 1] = new Option(i, "0" + i);
				} else {
					iend_d.options[i - 1] = new Option(i, i);
				}
				if (i == now.getDate()) {
					iend_d.options[i - 1].selected = 'selected';
				}
			}
			add_p.appendChild(iend_d);
			add_p.appendChild(document.createElement("br"));
			var add_space = document.getElementById("add_space" + inum).appendChild(add_p);
			if(num_span[inum - 1] == max_span){
				document.getElementById("add_span" + inum).style.visibility='hidden';
			}
		}
		document.getElementById('num_span' + inum).value=num_span[inum - 1];
	}
}

function remove_sp(inum, ispan) {
	if (!document.createElement || !document.getElementById) return;
	if(num_span[inum - 1] == 0){
		num_span[inum - 1] = ispan;
	}
	if(num_span[inum - 1] >= 2){
		num_span[inum - 1]--;
		if (num_span[inum - 1] == 1) {
			document.getElementById('span' + inum + '2').style.display='none';
		} else if(num_span[inum - 1] == 2){
			document.getElementById('span' + inum + '3').style.display='none';
		} else {
			var change_font = document.getElementById('sum_span' + inum);
			change_font.innerHTML = num_span[inum - 1] + "個表示中";
			var add_space = document.getElementById("add_space" + inum);
			var del_index = num_span[inum - 1] + 1;
			var del_obj = document.getElementById("add_p" + inum + "" + del_index);
			add_space.removeChild(del_obj);
			if(num_span[inum - 1] == max_span - 1){
				document.getElementById("add_span" + inum).style.visibility='visible';
			}
		}
		document.getElementById('num_span' + inum).value=num_span[inum - 1];
	}
}
function change_day(type, name){
	if (type == 0) {
		name = 'begin' + name;
	} else {
		name = 'end' + name;
	}
	var m = document.getElementById(name + 'Month').options[document.getElementById(name + 'Month').selectedIndex].text;
	if (m == 02) {
		var last = 29;
	} else if (m == 04 || m == 06 || m == 09 || m == 11){
		var last = 30;
	} else {
		var last = 31;
	}

	obj = document.getElementById(name + 'Day');
	var last_value = obj.options[document.getElementById(name + 'Day').selectedIndex].text;
	obj.length = 0;

	for (var i = 1; i <= last; i++) {
		if (i < 10) {
			obj.options[i - 1] = new Option(i, "0" + i);
		} else {
			obj.options[i - 1] = new Option(i, i);
		}
	}
	if (last_value <= last) {
		obj.options[last_value - 1].selected = 'selected';
	} else {
		obj.options[last- 1].selected = 'selected';
	}
}

</script>
<h2>
	<?php print "情報入力($spans[$span]-$locations[$location]-$weekdays[$weekday]曜-第{$period}時限)"; ?>
</h2>
<form method="post">
<?php
if ($_POST == null) {
	if ($timetables == null) {
		for ($i = 1; $i <= $mux_form_num; $i++) {
?>
<fieldset class="fsc<?php echo h($i) ?>" id="field<?php echo h($i) ?>" >
	<legend>講義<?php echo h($i) ?></legend>
	<input type="text" name="name<?php echo h($i) ?>" placeholder="講義名" /> <br> <br> <input
		type="text" name="lecturer<?php echo h($i) ?>" placeholder="講師" /> <br> <br> <input
		type="hidden" name="num_span<?php echo h($i) ?>" id="num_span<?php echo h($i) ?>" value=1 />
<?php
			for ($j = 1; $j <= 3; $j++) {
?>
<div class="fsc<?php echo h($j) ?>" id="span<?php echo h("{$i}{$j}") ?>"> <font size=4>期間<?php echo h($j) ?>：</font>
<?php
				echo $this->Form->month("begin{$i}{$j}", array('empty' => false, 'monthNames' => false, 'value' => date('m'), 'onchange' => "change_day(0, $i$j)"));
?>
<font> / </font>
<?php
				echo $this->Form->day("begin{$i}{$j}", array('empty' => false, 'value' => date('d')));
?>
<font> - </font>
<?php
				echo $this->Form->month("end{$i}{$j}", array('empty' => false, 'monthNames' => false, 'value' => date('m'), 'onchange' => "change_day(1, $i$j)"));
?>
<font> / </font>
<?php
				echo $this->Form->day("end{$i}{$j}", array('empty' => false, 'value' => date('d')));
				if ($j == 1) {
?>
<input type="button" id="add_span<?php echo h($i) ?>" value="追加" style="width: 100px; height: 32px; float: right" onclick="add_sp(<?php echo h($i) ?>, 1)" />
<?php
				} else if ($j == 2) {
?>
<input type="button" id="remove_span<?php echo h($i) ?>" value="削除" style="width: 100px; height: 32px; float: right" onclick="remove_sp(<?php echo h($i) ?>, 1)" />
<?php
				} else if($j == 3){
?>
<font id="sum_span<?php echo h($i) ?>" size=4 style="width: 100px; height: 32px; float: right">3個表示中</font>
<?php
				}
?>
<br> </div>
<?php
			}
?>
<div id="add_space<?php echo h($i) ?>"></div>
<input type="text" name="student<?php echo h($i) ?>" placeholder="受講者数" />
</fieldset>
<?php
		}
	} else {
		foreach ($timetables as $key1 => $tt_data){
			$key1++;
?>
<fieldset id="field<?php echo h($key1) ?>" >
	<legend>
		講義<?php echo h($key1); ?>
	</legend>
	<input type="text" name="name<?php echo h($key1) ?>" placeholder="講義名"
		value="<?php echo h($tt_data['name']) ?>" /><br> <br> <input
		type="text" name="lecturer<?php echo h($key1) ?>" placeholder="講師"
		value="<?php echo h($tt_data['lecturer']) ?>" /><br> <br> <input
		type="hidden" name="num_span<?php echo h($key1) ?>" id="num_span<?php echo h($key1) ?>" value=<?php echo h(count($timetables[$key1 - 1]['Schedule'])) ?> />
<?php
			$num_schedule = count($timetables[$key1 - 1]['Schedule']);
			for ($j = 1; $j <= 3 && $j <= $num_schedule; $j++) {
?>
<div class="fsc<?php if ($j <= $num_schedule) { echo h(1);} else { echo h(2);}?>" id="span<?php echo h("{$key1}{$j}") ?>" > <font size=4>期間<?php echo h($j) ?>：</font>
<?php
				echo $this->Form->month("begin{$key1}{$j}", array('empty' => false, 'monthNames' => false, 'value' => $tt_data['Schedule'][$j - 1]['begin'], 'onchange' => "change_day(0, $key1$j)"));
?>
<font> / </font>
<?php
				echo $this->Form->day("begin{$key1}{$j}", array('empty' => false, 'value' => $tt_data['Schedule'][$j - 1]['begin']));
				print "<script language=javascript>change_day(0, $key1$j)</script>";
?>
<font> - </font>
<?php
				echo $this->Form->month("end{$key1}{$j}", array('empty' => false, 'monthNames' => false, 'value' => $tt_data['Schedule'][$j - 1]['end'], 'onchange' => "change_day(1, $key1$j)"));
?>
<font> / </font>
<?php
				echo $this->Form->day("end{$key1}{$j}", array('empty' => false, 'value' => $tt_data['Schedule'][$j - 1]['end']));
				print "<script language=javascript>change_day(1, $key1$j)</script>";
				if ($j == 1) {
?>
<input type="button" id="add_span<?php echo h($key1) ?>" value="追加" style="width: 100px; height: 32px; float: right" onclick="add_sp(<?php echo h($key1) ?>, <?php echo h($num_schedule) ?>)" />
<?php
				} else if ($j == 2) {
?>
<input type="button" id="remove_span<?php echo h($key1) ?>" value="削除" style="width: 100px; height: 32px; float: right" onclick="remove_sp(<?php echo h($key1) ?>, <?php echo h($num_schedule) ?>)" />
<?php
				} else if($j == 3){
?>
<font id="sum_span<?php echo h($key1) ?>" size=4 style="width: 100px; height: 32px; float: right">3個表示中</font>
<?php
				}
?>
<br> </div>
<?php
			}
			for ($j = $num_schedule + 1; $j <= 3; $j++) {
?>
		<div class="fsc<?php if ($j <= $num_schedule) { echo h(1);} else { echo h(2);} ?>
" id="span<?php echo h("{$key1}{$j}") ?>" > <font size=4>期間<?php echo h($j) ?>：</font>
<?php
				echo $this->Form->month("begin{$key1}{$j}", array('empty' => false, 'monthNames' => false, 'value' => date('m'), 'onchange' => "change_day(0, $key1$j)"));
?>
<font> / </font>
<?php
				echo $this->Form->day("begin{$key1}{$j}", array('empty' => false, 'value' => date('d')));
?>
<font> - </font>
<?php
				echo $this->Form->month("end{$key1}{$j}", array('empty' => false, 'monthNames' => false, 'value' => date('m'), 'onchange' => "change_day(1, $key1$j)"));
?>
<font> / </font>
<?php
				echo $this->Form->day("end{$key1}{$j}", array('empty' => false, 'value' => date('d')));
				if ($j == 2) {
?>
<input type="button" id="remove_span<?php echo h($key1) ?>" value="削除" style="width: 100px; height: 32px; float: right" onclick="remove_sp(<?php echo h($key1) ?>, <?php echo h($num_schedule) ?>)" />
<?php
				} else if($j == 3){
?>
<font id="sum_span<?php echo h($key1) ?>" size=4 style="width: 100px; height: 32px; float: right">3個表示中</font>
<?php
				}
?>
<br> </div>
<?php
			}
?>
<div id="add_space<?php echo h($key1) ?>"></div>
<?php 
			for ($j = 4; $j <= $num_schedule; $j++) {
				$value1 = $tt_data['Schedule'][$j - 1]['begin'];
				$value1 = preg_replace('/0008-|-[0-9]*?$/', "", $value1);
				$value2 = $tt_data['Schedule'][$j - 1]['begin'];
				$value2 = preg_replace('/0008-[0-9]*-/', "", $value2);
				$value3 = $tt_data['Schedule'][$j - 1]['end'];
				$value3 = preg_replace('/0008-|-[0-9]*?$/', "", $value3);
				$value4 = $tt_data['Schedule'][$j - 1]['end'];
				$value4 = preg_replace('/0008-[0-9]*-/', "", $value4);
				print "<script language=javascript>create_sp($key1, $num_schedule, $value1, $value2, $value3, $value4)</script>";
			}
?>
<input type="text" name="student<?php echo h($key1) ?>" placeholder="受講者数" value="<?php echo h($tt_data['num_of_student']) ?>" />
</fieldset>
<?php
		}
		for ($i = $key1 + 1; $i <= $mux_form_num; $i++) {
	?>
<fieldset class="fsc<?php echo h($i) ?>" id="field<?php echo h($i) ?>" >
	<legend>講義<?php echo h($i) ?></legend>
	<input type="text" name="name<?php echo h($i) ?>" placeholder="講義名" /> <br> <br> <input
		type="text" name="lecturer<?php echo h($i) ?>" placeholder="講師" /> <br> <br> <input
		type="hidden" name="num_span<?php echo h($i) ?>" id="num_span<?php echo h($i) ?>" value=1 />
<?php
			for ($j = 1; $j <= 3; $j++) {
?>
		<div class="fsc<?php echo h($j) ?>" id="span<?php echo h("{$i}{$j}") ?>" > <font size=4>期間<?php echo h($j) ?>：</font>
<?php
				echo $this->Form->month("begin{$i}{$j}", array('empty' => false, 'monthNames' => false, 'value' => date('m'), 'onchange' => "change_day(0, $i$j)"));
?>
<font> / </font>
<?php
				echo $this->Form->day("begin{$i}{$j}", array('empty' => false, 'value' => date('d')));
?>
<font> - </font>
<?php
				echo $this->Form->month("end{$i}{$j}", array('empty' => false, 'monthNames' => false, 'value' => date('m'), 'onchange' => "change_day(1, $i$j)"));
?>
<font> / </font>
<?php
				echo $this->Form->day("end{$i}{$j}", array('empty' => false, 'value' => date('d')));
				if ($j == 1) {
?>
<input type="button" id="add_span<?php echo h($i) ?>" value="追加" style="width: 100px; height: 32px; float: right" onclick="add_sp(<?php echo h($i) ?>, 1)" />
<?php
				} else if ($j == 2) {
?>
<input type="button" id="remove_span<?php echo h($i) ?>" value="削除" style="width: 100px; height: 32px; float: right" onclick="remove_sp(<?php echo h($i) ?>, 1)" />
<?php
				} else if($j == 3){
?>
<font id="sum_span<?php echo h($i) ?>" size=4 style="width: 100px; height: 32px; float: right">3個表示中</font>
<?php
				}
?>
<br> </div>
<?php
			}
?>
<div id="add_space<?php echo h($i) ?>"></div>	
<input type="text" name="student<?php echo h($i) ?>" placeholder="受講者数" />
</fieldset>
<?php
		}
	}
?>
<input type="submit" name="submit" value="登録" onclick="check_result()"/>
<input type="hidden" name="num_field" id="num_field" value=<?php echo h($form_num) ?> />
</form>
<table>
	<tr>
		<td></td>
<?php
	if($form_num == 1) {
?>
		<td><input type="button" id="add_form" value="フォーム追加" onclick="add_form(<?php echo h($form_num) ?>)" />
		<td><input type="button" class="bc" id="remove_form" value="フォーム削除" onclick="remove_form(<?php echo h($form_num) ?>)" />
<?php
	} else {
?>
		<td><input type="button" class="bc" id="add_form" value="フォーム追加" onclick="add_form(<?php echo h($form_num) ?>)" />
		<td><input type="button" id="remove_form" value="フォーム削除" onclick="remove_form(<?php echo h($form_num) ?>)" />
<?php
	}
?>
	</tr>
</table>
<?php
} else {
	for ($i = 1; $i <= $_POST["num_field"]; $i++){ ?>
<fieldset id="field<?php echo h($i) ?>" >
	<legend>
		講義<?php echo h($i); ?>
	</legend>
	<input type="text" name="name<?php echo h($i) ?>" placeholder="講義名"
		value="<?php echo h($_POST["name$i"]) ?>" /><br> <br> <input
		type="text" name="lecturer<?php echo h($i) ?>" placeholder="講師"
		value="<?php echo h($_POST["lecturer$i"]) ?>" /><br> <br> <input
		type="hidden" name="num_span<?php echo h($i) ?>" id="num_span<?php echo h($i) ?>" value=<?php echo h($_POST["num_span$i"]) ?> />
<?php
		for ($j = 1; $j <= 3 && $j <= $_POST["num_span$i"]; $j++) {
?>
		<div class="fsc<?php if ($j <= $_POST["num_span$i"]) { echo h(1);} else { echo h(2);}
		?>
" id="span<?php echo h("{$i}{$j}") ?>" > <font size=4>期間<?php echo h($j) ?>：</font>
<?php
			echo $this->Form->month("begin{$i}{$j}", array('empty' => false, 'monthNames' => false, 'value' => $_POST['data']["begin{$i}{$j}"]['month'], 'onchange' => "change_day(0, $i$j)"));
?>
<font> / </font>
<?php
			echo $this->Form->day("begin{$i}{$j}", array('empty' => false, 'value' => $_POST['data']["begin{$i}{$j}"]['day']));
			print "<script language=javascript>change_day(0, $i$j)</script>";
?>
<font> - </font>
<?php
			echo $this->Form->month("end{$i}{$j}", array('empty' => false, 'monthNames' => false, 'value' => $_POST['data']["end{$i}{$j}"]['month'], 'onchange' => "change_day(1, $i$j)"));
?>
<font> / </font>
<?php
			echo $this->Form->day("end{$i}{$j}", array('empty' => false, 'value' => $_POST['data']["end{$i}{$j}"]['day']));
			print "<script language=javascript>change_day(1, $i$j)</script>";
			if ($j == 1) { 
?>
<input type="button" id="add_span<?php echo h($i) ?>" value="追加" style="width: 100px; height: 32px; float: right" onclick="add_sp(<?php echo h($i) ?>, <?php echo h($_POST["num_span$i"]) ?>)" />
<?php
			} else if ($j == 2) {
?>
<input type="button" id="remove_span<?php echo h($i) ?>" value="削除" style="width: 100px; height: 32px; float: right" onclick="remove_sp(<?php echo h($i) ?>, <?php echo h($_POST["num_span$i"]) ?>)" />
<?php
			} else if($j == 3){
?>
<font id="sum_span<?php echo h($i) ?>" size=4 style="width: 100px; height: 32px; float: right">3個表示中</font>
<?php
			}
?>
<br> </div>
<?php
		}
		for ($j = $_POST["num_span$i"] + 1; $j <= 3; $j++) {
?>
		<div class="fsc<?php if ($j <= $_POST["num_span$i"]) { echo h(1);} else { echo h(2);} ?>
" id="span<?php echo h("{$i}{$j}") ?>" > <font size=4>期間<?php echo h($j) ?>：</font>
<?php
			echo $this->Form->month("begin{$i}{$j}", array('empty' => false, 'monthNames' => false, 'value' => date('m'), 'onchange' => "change_day(0, $i$j)"));
?>
<font> / </font>
<?php
			echo $this->Form->day("begin{$i}{$j}", array('empty' => false, 'value' => date('d')));
?>
<font> - </font>
<?php
			echo $this->Form->month("end{$i}{$j}", array('empty' => false, 'monthNames' => false, 'value' => date('m'), 'onchange' => "change_day(1, $i$j)"));
?>
<font> / </font>
<?php
			echo $this->Form->day("end{$i}{$j}", array('empty' => false, 'value' => date('d')));
			if ($j == 1) { 
?>
<input type="button" id="add_span<?php echo h($i) ?>" value="追加" style="width: 100px; height: 32px; float: right" onclick="add_sp(<?php echo h($i) ?>, <?php echo h($_POST["num_span$i"]) ?>)" />
<?php
			} else if ($j == 2) {
?>
<input type="button" id="remove_span<?php echo h($i) ?>" value="削除" style="width: 100px; height: 32px; float: right" onclick="remove_sp(<?php echo h($i) ?>, <?php echo h($_POST["num_span$i"]) ?>)" />
<?php
			} else if($j == 3){
?>
<font id="sum_span<?php echo h($i) ?>" size=4 style="width: 100px; height: 32px; float: right">3個表示中</font>
<?php
			}
?>
<br> </div>
<?php
		}
?>
<div id="add_space<?php echo h($i) ?>"></div>
<?php
		for ($j = 4; $j <= $_POST["num_span$i"]; $j++) {
			$value1 = $_POST['data']["begin$i$j"]['month'];
			$value2 = $_POST['data']["begin$i$j"]['day'];
			$value3 = $_POST['data']["end$i$j"]['month'];
			$value4 = $_POST['data']["end$i$j"]['day'];
			$temp_num = $_POST["num_span$i"];
			print "<script language=javascript>create_sp($i, $temp_num, $value1, $value2, $value3, $value4)</script>";
		}
?>	
<input type="text" name="student<?php echo h($i) ?>" placeholder="受講者数" value="<?php echo h($_POST["student$i"]) ?>" />
</fieldset>
<?php
	}
	for ($i = $_POST["num_field"] + 1; $i <= $mux_form_num; $i++) {
?>
<fieldset class="fsc<?php echo h($i) ?>" id="field<?php echo h($i) ?>" >
	<legend>講義<?php echo h($i) ?></legend>
	<input type="text" name="name<?php echo h($i) ?>" placeholder="講義名" /> <br> <br> <input
		type="text" name="lecturer<?php echo h($i) ?>" placeholder="講師" /> <br> <br> <input
		type="hidden" name="num_span<?php echo h($i) ?>" id="num_span<?php echo h($i) ?>" value=1 />
<?php
		for ($j = 1; $j <= 3; $j++) {
?>
		<div class="fsc<?php echo h($j) ?>" id="span<?php echo h("{$i}{$j}") ?>" > <font size=4>期間<?php echo h($j) ?>：</font>
<?php
			echo $this->Form->month("begin{$i}{$j}", array('empty' => false, 'monthNames' => false, 'value' => date('m'), 'onchange' => "change_day(0, $i$j)"));
?>
<font> / </font>
<?php
			echo $this->Form->day("begin{$i}{$j}", array('empty' => false, 'value' => date('d')));
?>
<font> - </font>
<?php
			echo $this->Form->month("end{$i}{$j}", array('empty' => false, 'monthNames' => false, 'value' => date('m'), 'onchange' => "change_day(1, $i$j)"));
?>
<font> / </font>
<?php
			echo $this->Form->day("end{$i}{$j}", array('empty' => false, 'value' => date('d')));
			if ($j == 1) { ?>
<input type="button" id="add_span<?php echo h($i) ?>" value="追加" style="width: 100px; height: 32px; float: right" onclick="add_sp(<?php echo h($i) ?>, 1)" />
<?php
			} else if ($j == 2) {
?>
<input type="button" id="remove_span<?php echo h($i) ?>" value="削除" style="width: 100px; height: 32px; float: right" onclick="remove_sp(<?php echo h($i) ?>, 1)" />
<?php
			} else if($j == 3){
?>
<font id="sum_span<?php echo h($i) ?>" size=4 style="width: 100px; height: 32px; float: right">3個表示中</font>
<?php
			}
?>
<br> </div>
<?php
		}
?>
<div id="add_space<?php echo h($i) ?>"></div>
<input type="text" name="student<?php echo h($i) ?>" placeholder="受講者数" />
</fieldset>
<?php
	}
?>
<input type="submit" name="submit" value="登録" onclick="check_result()"/>
<input type="hidden" name="num_field" id="num_field" value=<?php echo h($_POST["num_field"]) ?> />
</form>
<table>
	<tr>
		<td></td>
<?php
if($_POST["num_field"] == 1) {
?>
		<td><input type="button" id="add_form" value="フォーム追加" onclick="add_form(<?php echo h($_POST["num_field"]) ?>)" />
		<td><input type="button" class="bc" id="remove_form" value="フォーム削除" onclick="remove_form(<?php echo h($_POST["num_field"]) ?>)" />
<?php
} else {
?>
		<td><input type="button" class="bc" id="add_form" value="フォーム追加" onclick="add_form(<?php echo h($_POST["num_field"]) ?>)" />
		<td><input type="button" id="remove_form" value="フォーム削除" onclick="remove_form(<?php echo h($_POST["num_field"]) ?>)" />
<?php
}
?>
	</tr>
</table>
<?php 
}
?>