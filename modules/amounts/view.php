<?php
global $system;
$data=
array(
0=>array (
	'div' => array(
		0 => array(
		"table" => array(
			"attr"=> array(
				"id" => "content"
			),
			0 => array(
				'thead' => array(
					0 => array(
						'tr' => array(
							0=>array('td'=>'ID'),
							1=>array('td'=>'Title'),
							2=>array('td'=>'Date'),
							3=>array('td'=>'Income'),
							4=>array('td'=>'Expense')
							)
						)
					)
				)
			)
		)
	)
)
);

//$html='';
//include_once _modules.'/amounts/index.php';
//$html='<table class="table" id="amounts"><tr><td>id</td><td>Title</td><td>Date</td><td>Income</td><td>Expense</td></tr>';
$K=$amount->view();
while($t=$K->fetch_assoc()) {
	if($t==null)
		break;
	//$html.="<tr><td>$t[id]</td><td>$t[title]</td><td>$t[date]</td><td class='green'>$t[income]</td><td class='red'>$t[expense]</td></tr>";
	array_push($data[0]['div'][0]['table'], 
		array(
				'tr' => array(
					0=>array('td'=>$t['id'].'<a href="'.seo::route('?option=Amounts&action=delete&page='.$t['id']).'" class="icon-delete"><i class="fa fa-times"></i></a>'),
					1=>array('td'=>$t['title']),
					2=>array('td'=>$t['date']),
					3=>array('td'=>$t['income']),
					4=>array('td'=>$t['expense'])
					)
			)
	);
}
//$html.= '</table>';
//$html = '<div>'.$html.'</div>';
$data[0]['div'][1]=array(
	'div' => array(
		'attr' => array(
			'id'=>'pagination'
		)
	)
);
$pages= $amount->pages;
$ps='';
for($i=1;$i<$pages;$i++) {
	//$ps.='<p><a href="index.php?page=view&i='.$i.'" data="pageIndex:'.$i.'">'.$i.'</a></p>';
	//echo $i.'<br>';
	$data[0]['div'][1]['div'][$i-1]=
		array(
			'p' => array(
				0 => array(
					'a' => array(
						'attr'=>array(
							'href' => 'index.php?page=view&i='.$i,
							'data' => 'pageIndex:'.$i
						),
						0 => $i
					)
				)
			)
		);
}
//$html.= '<div id="pagination">'.$ps.'</div>';