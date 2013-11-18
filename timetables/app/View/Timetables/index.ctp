<script type="text/javascript">
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
		obj.options[i] = new Option(i, i);
	}
	if (last_value <= last) {
		obj.options[last_value - 1].selected = 'selected';
	} else {
		obj.options[last- 1].selected = 'selected';
	}
}

</script>

<h2>期間</h2>
<form method="post">
<table>
<?php foreach($spans as $key => $span): ?>
<tr> <td style="width:100px"><?php echo $this->Html->link($span, "/timetables/view_location?span=$key"); $key++; ?></td>
<td style="width:400px">
<font size=4>開始：</font>
<?php
if($_POST == null){
	if ($seasons != null) {
		$value = $seasons[$key - 1]['Season']['begin'];
		ereg_replace("0008-|-[0-9]*$", "", $value);
		echo $this->Form->month("begin{$key}", array('empty' => false, 'monthNames' => false, 'value' => $value, 'onchange' => "change_day(0, $key)"));
?>
<font> / </font>
<?php
		$value = $seasons[$key - 1]['Season']['begin'];
		ereg_replace("0008-[0-9]*-", "", $value);
		echo $this->Form->day("begin{$key}", array('empty' => false, 'value' => $value));
		if ($key == 4 || $key == 5) {
?>
<font> - </font>
<?php
			$value = $seasons[$key - 1]['Season']['end'];
			ereg_replace("0008-|-[0-9]*$", "", $value);
			echo $this->Form->month("end{$key}", array('empty' => false, 'monthNames' => false, 'value' => $value, 'onchange' => "change_day(1, $key)"));
?>
<font> / </font>
<?php
			$value = $seasons[$key - 1]['Season']['end'];
			ereg_replace("0008-[0-9]*-", "", $value);
			echo $this->Form->day("end{$key}", array('empty' => false, 'value' => $value));
		}
?>
<p>
</td>
<?php
	} else {
		echo $this->Form->month("begin{$key}", array('empty' => false, 'monthNames' => false, 'value' => date('m'), 'onchange' => "change_day(0, $key)"));
?>
<font> / </font>
<?php
		echo $this->Form->day("begin{$key}", array('empty' => false, 'value' => date('d')));
		if ($key == 4 || $key == 5) {
?>
<font> - </font>
<?php
			echo $this->Form->month("end{$key}", array('empty' => false, 'monthNames' => false, 'value' => date('m'), 'onchange' => "change_day(1, $key)"));
?>
<font> / </font>
<?php
			echo $this->Form->day("end{$key}", array('empty' => false, 'value' => date('d')));
		}
?>
<p>
</td>
<?php
	}
} else {
	$value = $_POST['data']["begin$key"]['month'];
	ereg_replace("0008-|-[0-9]*$", "", $value);
	echo $this->Form->month("begin{$key}", array('empty' => false, 'monthNames' => false, 'value' => $value, 'onchange' => "change_day(0, $key)"));
?>
<font> / </font>
<?php
	$value = $_POST['data']["begin$key"]['day'];
	ereg_replace("0008-[0-9]*-", "", $value);
	echo $this->Form->day("begin{$key}", array('empty' => false, 'value' => $value));
	if ($key == 4 || $key == 5) {
?>
<font> - </font>
<?php
		$value = $_POST['data']["end$key"]['month'];
		ereg_replace("0008-|-[0-9]*$", "", $value);
		echo $this->Form->month("end{$key}", array('empty' => false, 'monthNames' => false, 'value' => $value, 'onchange' => "change_day(0, $key)"));
?>
<font> / </font>
<?php
		$value = $_POST['data']["end$key"]['day'];
		ereg_replace("0008-[0-9]*-", "", $value);
		echo $this->Form->day("end{$key}", array('empty' => false, 'value' => $value));
	}
?>
<p>
</td>
<?php
}
endforeach;
?>
</table>
<input type="submit" name="submit" value="期間設定"/>
</form>