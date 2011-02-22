<html>
    <head>
        <title>CodeIgniter Sample Application</title>
        <link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>css/style.css">
    </head>
<body>
 
<div id="container">
 
<h1>Datamapper Tutorial</h1>
 
 
<table>
	<thead>
	<tr>
		<th>Name</th>
		<th>Course</th>
	</tr>	
	</thead>
	<tbody>
	<?php $ctr = 0; ?>
	<?php foreach($student_list as $student): ?>	
	<?php $student->course->get()->order_by('name'); ?>
	<?php $ctr++ ?>
	<?php if ($ctr % 2): ?>
 	<tr>
		<td><?= $student->name ?></td>
		<td>
		    <? foreach($student->course->all as $course): ?>
		    <?= $course->name ?><br/>
		    <? endforeach ?>
		</td>
	</tr>	
	<?php else: ?>
 	 <tr class="odd">
		<td><?= $student->name ?></td>
		<td>
		    <? foreach($student->course->all as $course): ?>
		    <?= $course->name ?><br/>
		    <? endforeach ?>
		</td>
	</tr>	
	<?php endif; ?>
	<?php endforeach ?>
	</tbody>
</table>
 
 
<p class="pagination"><?= $this->pagination->create_links(); ?></p>
 
</div>
 
</body>
</html>