<pre>
<?php

$simpleXml = simplexml_load_string('<pmxi_records><node>
		<category><![CDATA[Автоматика>Контроль, управление и питание>Блоки питания>Однофазные блоки питания]]></category>
		<product><![CDATA[[:ru]Блок птания однофазный 6EP1233-1AA00[:en]The power supply single phase 6EP1233-1AA00]]></product>
		<brand><![CDATA[Siemens]]></brand>
		<articles><![CDATA[6EP1233-1AA00]]></articles>
		<pdf><![CDATA[6EP1_233-1AA00.pdf]]></pdf>
		<photo><![CDATA[]]></photo>
		<description><![CDATA[]]></description>
	</node></pmxi_records>', 'SimpleXMLElement', LIBXML_NOCDATA);
	$rootNodes = $simpleXml->xpath('/pmxi_records/node');
	
	print_r($rootNodes[0]->count());
	
	// foreach($rootNodes[0] as $qwe){
		// // echo ((string)$qwe);
		// print_r('<br/>');
		// echo ($qwe->getName());

	// }
	
// $qwe = $rootNodes[0]->xpath('./*[not(self::category or self::articles or self::pdf or self::photo or self::description)]/text()[normalize-space()]');

	// if(!empty($qwe))
	// foreach($qwe as $key=>$val){
		
		// print_r($val->getName().'-'.$val[0]."\r\n");
	// }


 
// $resp = file_get_contents('https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20151121T123602Z.c647c65268af9cdb.8923072f049a821f33b0ff4fa11ef99285963325&text='.urlencode('украинский текст').'&lang=ru-uk');
// print_r(json_decode($resp)->text[0]);

// echo translate("инкрементальные asd");
 
	// function translate($text,$dir = 'ru-uk'){

		// $source_text = $text;
	
		// //todo: embed to admin
		// $dict = array(
			// 'ru-uk' => array(
				// 'Инкрементальные' => 'Інкрементальні',
				// 'инкрементальные' => 'інкрементальні'
			// )
		// );
		// $dict = $dict[$dir];
	
		// //if lang mark for yandex and qtranslate is different
		// $tags_to = array('ru-uk' => 'ua');

		// $tag_from = $tags_from[$dir] ? '[:'.$tags_from[$dir].']' : '[:'.substr($dir,0,2).']';
		// $tag_to = $tags_to[$dir] ? '[:'.$tags_to[$dir].']' : '[:'.substr($dir,3).']';
		
		// if(strrpos($text,$tag_to) !== false){ 
			// return str_replace(array_keys($dict),array_values($dict),$text);
		// }
		
		// $transl_from = strrpos($text,$tag_from);
		
		// if($transl_from !== false){ 
			
			// $translate = substr($text,$transl_from + strlen($tag_to));
			// $transl_to = strrpos($translate,'[:');
			// $translate = $transl_to ? substr($translate,0,$transl_to) : $translate; 
			
		// }elseif(strrpos($text,'[:]') === false){
			// $translate = $text;
			// $text = $tag_from.$translate.'[:]'; 
		// }else{
			
			// return str_replace(array_keys($dict),array_values($dict),$text);
		// }

		// $translate = json_decode(
			// file_get_contents('https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20151121T123602Z.c647c65268af9cdb.8923072f049a821f33b0ff4fa11ef99285963325&text='
			// .urlencode($translate)
			// .'&lang='.$dir)
		// )->text[0];

		// $return = $translate ? $tag_to.$translate.$text : $source_text;
		
		// return str_replace(array_keys($dict),array_values($dict),$return); 
	// }

?>