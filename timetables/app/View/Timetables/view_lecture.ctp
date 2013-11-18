<?php
if(0 <= $span && $span <= count($spans) && is_numeric($span) && 0 <= $location && $location <= count($locations) && is_numeric($location)):
$max_tables = count($timetables);$i = 0;
?>
<h2 class="hc">
	<?php echo h("講義情報($spans[$span]-$locations[$location])"); ?>
</h2>
<table class="tac1">
<tr style="background: #ccccff">
<td class="tdc1" width="53"><br></td>
<?php foreach ($weekdays as $weekday): ?>
<td class="tdc1" colspan="2" width="20%"><?php echo $weekday ?></td>
<?php endforeach ?>
</tr><?php for ($key1 = 1;$key1 <= 7;$key1++): ?>
<tr>
<td class="tdc1" height="52"><?php echo "第{$key1}時限" ?><br>
<?php echo h($periods_begin[$key1 - 1]) ?> <br>
<font>↓</font><br>
<?php echo h($periods_end[$key1 - 1]) ?> <br>
</td>
<?php
foreach ($weekdays as $key2 => $weekday):
if ($timetables != null && $i < $max_tables && $timetables[$i]["period"] == $key1 && $timetables[$i]["weekday"] == $key2){
$form_num = 1;
if($i != $max_tables - 1 && $timetables[$i + 1]["period"] == $key1 && $timetables[$i + 1]["weekday"] == $key2){
	$form_num = 2;
?>
<td class="tdc2"
	onclick='window.open("view_input?span=<?php echo h($span)?>&location=<?php echo h($location)?>&period=<?php echo h($key1)?>&weekday=<?php echo h($key2)?>",
	"_new", "iframe=true, width=800, height=600, scrollbars=yes")'>
<?php } else { ?>
<td class="tdc2" colspan="2"
	onclick='window.open("view_input?span=<?php echo h($span)?>&location=<?php echo h($location)?>&period=<?php echo h($key1)?>&weekday=<?php echo h($key2)?>",
	"_new", "iframe=true, width=800, height=600, scrollbars=yes")'>
<?php } echo h($timetables[$i]["name"])?><br><?php echo h($timetables[$i]["lecturer"])?><br>
<?php 
	if($timetables[$i]["Schedule"][0]["begin"] == $timetables[$i]["Schedule"][0]["end"]){
		$begin_end = ereg_replace("^[0-9]*-0?","", $timetables[$i]["Schedule"][0]["begin"]);
	} else {
		$begin_end = ereg_replace("^[0-9]*-0?","", $timetables[$i]["Schedule"][0]["begin"]);
		$begin_end .= ereg_replace("^[0-9]*-0?","@_@", $timetables[$i]["Schedule"][0]["end"]);
	}
	$num = count($timetables[$i]["Schedule"]) - 1;
	if ($num != 0){
		for ($j = 1;$j <= $num;$j++){
			if($timetables[$i]["Schedule"][$j]["begin"] == $timetables[$i]["Schedule"][$j]["end"]){
				$begin_end .= ereg_replace("^[0-9]*-0?",", ", $timetables[$i]["Schedule"][$j]["begin"]);
			} else {
				$begin_end .= ereg_replace("^[0-9]*-0?",", ", $timetables[$i]["Schedule"][$j]["begin"]);
				$begin_end .= ereg_replace("^[0-9]*-0?","@_@", $timetables[$i]["Schedule"][$j]["end"]);
			}
		}
		$num = 0;
	}
	$begin_end = ereg_replace("-0?","/", $begin_end);
	$begin_end = ereg_replace("@_@","-", $begin_end);
	echo h($begin_end);
	$i++;
?>
</td>
<?php
	if($form_num == 2){
?>
<td class="tdc2"
	onclick='window.open("view_input?span=<?php echo h($span)?>&location=<?php echo h($location)?>&period=<?php echo h($key1)?>&weekday=<?php echo h($key2)?>",
	"_new", "iframe=true, width=800, height=600, scrollbars=yes")'>
<?php
	echo h($timetables[$i]["name"])?><br><?php echo h($timetables[$i]["lecturer"])?><br>
<?php 
	if($timetables[$i]["Schedule"][0]["begin"] == $timetables[$i]["Schedule"][0]["end"]){
		$begin_end = ereg_replace("^[0-9]*-0?","", $timetables[$i]["Schedule"][0]["begin"]);
	} else {
		$begin_end = ereg_replace("^[0-9]*-0?","", $timetables[$i]["Schedule"][0]["begin"]);
		$begin_end .= ereg_replace("^[0-9]*-0?","@_@", $timetables[$i]["Schedule"][0]["end"]);
	}
	$num = count($timetables[$i]["Schedule"]) - 1;
	if ($num != 0){
		for ($j = 1;$j <= $num;$j++){
			if($timetables[$i]["Schedule"][$j]["begin"] == $timetables[$i]["Schedule"][$j]["end"]){
				$begin_end .= ereg_replace("^[0-9]*-0?",", ", $timetables[$i]["Schedule"][$j]["begin"]);
			} else {
				$begin_end .= ereg_replace("^[0-9]*-0?",", ", $timetables[$i]["Schedule"][$j]["begin"]);
				$begin_end .= ereg_replace("^[0-9]*-0?","@_@", $timetables[$i]["Schedule"][$j]["end"]);
			}
		}
		$num = 0;
	}
	$begin_end = ereg_replace("-0?","/", $begin_end);
	$begin_end = ereg_replace("@_@","-", $begin_end);
	echo h($begin_end);
	$i++; 
	}
} else {
?>
<td class="tdc3" colspan="2"
	onclick='window.open("view_input?span=<?php echo h($span)?>&location=<?php echo h($location)?>&period=<?php echo h($key1)?>&weekday=<?php echo h($key2)?>",
	"_new", "iframe=true, width=800, height=600, scrollbars=yes")'>空室</td>
<?php } ?>
<?php endforeach;?>
</tr>
	<?php endfor; ?>
</table>
<?php endif; ?>