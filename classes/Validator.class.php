<?php
require_once 'lib/simple_html_dom.php';
class Validator{
	var $method;
	var $value;
	var $model;

	public function __construct($method,$value = '',$model){
		$this->method = $method;
		$this->value = $value;

		$this->model = $model;
	}

	public function getResult(){
		$method = 'isnt'.$this->method;
		return $this->$method($this->value);
	}

	private function isntREQUIRE($value = ''){
		$name = __FUNCTION__;
		$key = substr($name,2,strlen($name)-1);
		if(!empty($value)){
			$r = 0;
			return $r;
		}else{
			return 1;
		}
	}
	private function isntFILETYPE($value = ''){
		$result = 1;
		if(!empty($value)){
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mimeType = finfo_file($finfo, $value);
			finfo_close($finfo);
			
			$result = 1;
			foreach($this->model->init['allowExtensions'] as $k => $v){
				if(preg_match("/{$v}/",$mimeType)){
					$result = 0;
					break;
				}
			}
		}
		return $result;
	}
	private function isntFILESIZE($value = ''){
		return (filesize($value)/1024/1024 < UPLOAD_MAXSIZE)?0:1;
	}
	private function isntTEL($value = ''){
		$name = __FUNCTION__;
		$key = substr($name,2,strlen($name)-1);
		if(count(preg_match('/^\d{10,11}$/', $value, $m)) > 0){
			return 0;
		}else{
			return 1;
		}
	}
	private function isntZIP($value = ''){
		$name = __FUNCTION__;
		$key = substr($name,2,strlen($name)-1);

		if(count(preg_match('/^\d{7}$/', $value, $m)) > 0){
			return 0;
		}else{
			return 1;
		}
	}
	private function isntEMAIL($value = ''){
		$name = __FUNCTION__;
		$key = substr($name,2,strlen($name)-1);
		if(count(preg_match('/.+@.+\..+/', $value, $m)) > 0){
			return 0;
		}else{
			return 1;
		}
	}
}