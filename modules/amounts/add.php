<?php
$par=json_decode($this->jsParams,true);
$itemsQ=0;
if($_POST['add'])
	$data[$itemsQ++]['div']=array('attr'=>array('id'=>'message'),0=>$amount->add());
$data[$itemsQ++]['form']=$par['form'];
$data[$itemsQ++]['script']=array('attr'=>array('type'=>'text/javascript'),
		0=>"
            $(function () {
                $('#amountDate').datetimepicker();
            });"
	);