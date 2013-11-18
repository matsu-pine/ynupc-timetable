<?php $span = $_GET["span"]; ?>
<?php if(0 <= $span && $span <= count($spans) && is_numeric($span)): ?>
<h2>
	<?php echo h("教室($spans[$span])"); ?>
</h2>
<?php foreach($locations as $key => $location): ?>
<li><?php echo $this->Html->link($location, "/timetables/view_lecture?span=$span&location=$key"); ?>
	<p>

</li>
<?php endforeach; endif; ?>

