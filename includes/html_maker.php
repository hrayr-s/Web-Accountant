<?php
class makeHtml {
	public static function makeTag($tag=null) {
		if($tag==null) return '';
		$tog='';
		switch (gettype($tag)) {
			case 'string':
					$tog = $tag;
				break;
			case 'array':
                for($i=0;!empty($tag[$i]);$i++){
                    if(gettype($tag[$i])=='string') {
                        $tog.=$tag[$i];
                    }elseif(gettype($tag[$i])=='array')
					foreach ($tag[$i] as $k => $v) {
                        if($k=='attr') continue;
						$tog.='<'.$k.' '.(!empty($v['attr'])&&(gettype($v))=='array' ? self::makeAttributes($v['attr']) : '').'>';
						$tog.=self::makeTag($v);
                        $tog.="</$k>";
					}
                }
				break;
			default:
					$tog= '';
				break;
		}
        return $tog;
	}
    public static function makeAttributes($attr) {
        if($attr==null) return '';
        if(gettype($attr)=='string') return $attr;
        $at=' ';
        foreach($attr as $k => $v) {
            switch($k) {
                case 'action':
                case 'href':
                    $v=seo::route($v);
            }
            $at.="$k='$v' ";
        }
        return $at;
    }
    function table($params=array()) {
        $head='';
        $body='';
        $tr='';
        $td='';
        $attr=$params['attr'] ? makeHtml::attributes($params['attr']):'';
        for($i=0;$i<count($params['head']);$i++){
            foreach($params['head'][$i]['td'] as $k=>$v) {
                $tdattr=$v['attr']?makeHtml::attributes($v['attr']):'';
                $td.="<td $tdattr>$v[content]</td>";
            }
            $trattr=$params['head'][$i]['attr']?makeHtml::attributes($params['head'][$i]['attr']):'';
            $tr.="<tr $trattr>$td</tr>";
            $td='';
            unset($tdattr);
        }
        $hdatr=makeHtml::attributes($params['head_attr']);
        $head.="<thead $hdattr>$tr</thead>";
        $tr='';
        for($i=0;$i<count($params['body']);$i++){
            foreach($params['body'][$i]['td'] as $v) {
                //$tdattr=makeHtml::attributes($v['attr']);
                $tdattr=$v['attr']?makeHtml::attributes($v['attr']):'';
                $td.="<td $tdattr>$v[content]</td>";
            }
            $trattr=$params['body'][$i]['attr']?makeHtml::attributes($params['body'][$i]['attr']):'';
            $tr.="<tr $trattr>$td</tr>";
            $td='';
        }
        $hdatr=makeHtml::attributes($params['body_attr']);
        $body.="<tbody $hdattr>$tr</tbody>";
        return "<table $attr>$head$body</table>";
    }
    function form($params=array()) {
        //$params=$params['form'];
        $html='<form method="'.($params['method'] ? $params['method'] : 'get').'" '.($params['action'] ? ' action="'.$params['action'].'"':"").'>';
        $inputs='';
        
        for($i=0;$params[$i]!=null;$i++) {
            switch($params[$i]['type']) {
                case 'input': 
                        $inputs.=makeHtml::inputs($params[$i]);
                    break;
                case 'textarea':
                        $inputs.=makeHtml::textarea($params[$i]);
                    break;
                case 'button':
                		$inputs.=makeHtml::button($params[$i]);
                	break;
            }
        }
        $html_after="</form>";
        return $html.$inputs.$html_after;
    }
    function inputs($params) {
        $attr=makeHtml::attributes($params);
        $inputs="<input$attr />";
        return $inputs;
    }
    function textarea($params) {
        $attr=makeHtml::attributes($params);
        $sourcetext=$params['sourcetext'] ? $params['sourcetext'] : '';
        return "<textarea$attr >$sourcetext</textarea>";
    }
    function button($params) {
    	$ettr=makeHtml::attributes($params);
        $sourcetext=$params['intext'] ? $params['intext'] : '';
        return "<button$attr >$sourcetext</button>";
    }
    function select($params=array()) {
        $attr=makeHtml::attributes($params['attr']);
        $options='';
        foreach($params['options'] as $k=>$v) {
            $at=makeHtml::attributes($v);
            $options.="<option $at>$v[content]</option>";
        }
        return "<select $attr>$options</select>";
    }
    function attributes($n=array()) {
        $type=$n['type'] ? ' type="'.$n['type'].'"' : "";
        $name=$n['name'] ? ' name="'.$n['name'].'"' : "";
        $size=$n['size'] ? ' size="'.$n['size'].'"' : "";
        $style=$n['style'] ? ' style="'.$n['style'].'"' : "";
        $onclick=$n['onclick'] ? ' onclick="'.$n['onclick'].'"' : "";
        $accept=$n['accept'] ? ' accept="'.$n['accept'].'"' : "";
        $accesskey=$n['accesskey'] ? ' accesskey="'.$n['accesskey'].'"' : "";
        $align=$n['align'] ? ' align="'.$n['align'].'"' : "";
        $alt=$n['alt'] ? ' alt="'.$n['alt'].'"' : "";
        $autocomplete=$n['autocomplete'] ? ' autocomplete="'.$n['autocomplete'].'"' : "";
        $autofocus=$n['autofocus'] ? ' autofocus="'.$n['autofocus'].'"' : "";
        $cols=$n['cols'] ? ' cols="'.$n['cols'].'"' : "";
        $border=$n['border'] ? ' border="'.$n['border'].'"' : "";
        $checked=$n['checked'] ? ' checked="'.$n['checked'].'"' : "";
        $disabled=$n['disabled'] ? ' disabled="'.$n['disabled'].'"' : "";
        $form=$n['form'] ? ' form="'.$n['form'].'"' : "";
        $formaction=$n['formaction'] ? ' formaction="'.$n['formaction'].'"' : "";
        $formenctype=$n['formenctype'] ? ' formenctype="'.$n['formenctype'].'"' : "";
        $formmethod=$n['formmethod'] ? ' formmethod="'.$n['formmethod'].'"' : "";
        $formnovalidate=$n['formnovalidate'] ? ' formnovalidate="'.$n['formnovalidate'].'"' : "";
        $formtarget=$n['formtarget'] ? ' formtarget="'.$n['formtarget'].'"' : "";
        $list=$n['list'] ? ' list="'.$n['list'].'"' : "";
        $max=$n['max'] ? ' max="'.$n['max'].'"' : "";
        $maxlength=$n['maxlength'] ? ' maxlength="'.$n['maxlength'].'"' : "";
        $min=$n['min'] ? ' min="'.$n['min'].'"' : "";
        $multiple=$n['multiple'] ? ' multiple="'.$n['multiple'].'"' : "";
        $pattern=$n['pattern'] ? ' pattern="'.$n['pattern'].'"' : "";
        $placeholder=$n['placeholder'] ? ' placeholder="'.$n['placeholder'].'"' : "";
        $readonly=$n['readonly'] ? ' readonly="'.$n['readonly'].'"' : "";
        $required=$n['required'] ? ' required="'.$n['required'].'"' : "";
        $rows=$n['rows'] ? ' rows="'.$n['rows'].'"' : "";
        $src=$n['src'] ? ' src="'.$n['src'].'"' : "";
        $step=$n['step'] ? ' step="'.$n['step'].'"' : "";
        $tabindex=$n['tabindex'] ? ' tabindex="'.$n['tabindex'].'"' : "";
        $value=$n['value'] ? ' value="'.$n['value'].'"' : "";
        $onblur=$n['onblur'] ? ' onblur="'.$n['onblur'].'"' : "";
        $onchange=$n['onchange'] ? ' onchange="'.$n['onchange'].'"' : "";
        $ondblclick=$n['ondblclick'] ? ' ondblclick="'.$n['ondblclick'].'"' : "";
        $onfocus=$n['onfocus'] ? ' onfocus="'.$n['onfocus'].'"' : "";
        $onkeydown=$n['onkeydown'] ? ' onkeydown="'.$n['onkeydown'].'"' : "";
        $onkeypress=$n['onkeypress'] ? ' onkeypress="'.$n['onkeypress'].'"' : "";
        $onkeyup=$n['onkeyup'] ? ' onkeyup="'.$n['onkeyup'].'"' : "";
        $onload=$n['onload'] ? ' onload="'.$n['onload'].'"' : "";
        $onmousedown=$n['onmousedown'] ? ' onmousedown="'.$n['onmousedown'].'"' : "";
        $onmousemove=$n['onmousemove'] ? ' onmousemove="'.$n['onmousemove'].'"' : "";
        $onmouseout=$n['onmouseout'] ? ' onmouseout="'.$n['onmouseout'].'"' : "";
        $onmouseover=$n['onmouseover'] ? ' onmouseover="'.$n['onmouseover'].'"' : "";
        $onmouseup=$n['onmouseup'] ? ' onmouseup="'.$n['onmouseup'].'"' : "";
        $onreset=$n['onreset'] ? ' onreset="'.$n['onreset'].'"' : "";
        $onselect=$n['onselect'] ? ' onselect="'.$n['onselect'].'"' : "";
        $onsubmit=$n['onsubmit'] ? ' onsubmit="'.$n['onsubmit'].'"' : "";
        $onunload=$n['onunload'] ? ' onunload="'.$n['onunload'].'"' : "";
        $class=$n['class'] ? ' class="'.$n['class'].'"' : "";
        $contenteditable=$n['contenteditable'] ? ' contenteditable="'.$n['contenteditable'].'"' : "";
        $contextmenu=$n['contextmenu'] ? ' contextmenu="'.$n['contextmenu'].'"' : "";
        $dir=$n['dir'] ? ' dir="'.$n['dir'].'"' : "";
        $hidden=$n['hidden'] ? ' hidden="'.$n['hidden'].'"' : "";
        $lang=$n['lang'] ? ' lang="'.$n['lang'].'"' : "";
        $spellcheck=$n['spellcheck'] ? ' spellcheck="'.$n['spellcheck'].'"' : "";
        $wrap=$n['wrap'] ? ' wrap="'.$n['wrap'].'"' : "";
        $title=$n['title'] ? ' title="'.$n['title'].'"' : "";
        $xmllang=$n['xmllang'] ? ' xml:lang="'.$n['xmllang'].'"' : "";
        $rel=$n['rel'] ? ' rel="'.$n['rel'].'"' : "";
        $href=$n['href'] ? ' href="'.$n['href'].'"' : "";
        $selected=$n['selected'] ? ' selected="'.$n['selected'].'"' : "";
        $id=$n['id'] ? ' id="'.$n['id'].'"' : "";
        return "$id$type$name$size$style$onclick$accept$accesskey$align$alt$autocomplete$autofocus$border$checked$disabled$form$formaction$formenctype$formmethod$formnovalidate$formtarget$list$max$maxlength$min$multiple$pattern$placeholder$readonly$required$src$step$tabindex$value$onblur$onchange$ondblclick$onfocus$onkeydown$onkeypress$onkeyup$onload$onmousedown$onmousemove$onmouseout$onmouseover$onmouseup$onreset$onselect$onsubmit$onunload$class$contenteditable$contextmenu$dir$hidden$lang$spellcheck$tabindex$title$xmllang$cols$rows$wrap$rel$href$selected";
    }
}