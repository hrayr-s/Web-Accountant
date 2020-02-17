<?php
global $config;
$this->header();
include_once _modules.'/amounts/index.php';
$amounts = new amounts();
?>
<div id="content">
<h1>Hi This is a view page</h1>
<table>
	<tr>
		<td>id</td>
		<td>Title</td>
		<td>Date</td>
		<td>Income</td>
		<td>Expense</td>
	</tr>
	<?php

	while($t=$amounts->get()) {
	?>
	<tr>
		<td><?=$t[id]?></td>
		<td><?=$t[title]?></td>
		<td><?=$t[date]?></td>
		<td><?=$t[income]?></td>
		<td><?=$t[expense]?></td>
	</tr>
	<?php
	}
	?>
</table>
</div>
<?php

$this->footer();
?>