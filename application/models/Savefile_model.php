<?php
class Savefile_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	public function checkFile($name,$linkFolder){
		$linkFile = $linkFolder.$name;
		if (!file_exists($linkFile)) {
			return $name;
		}
		else{
			$time = microtime();
			$time = str_replace(' ','',$time);
			$name = $time.$name;
			$name = $this->checkFile($name,$linkFolder);
			if(!empty($name))return $name;
		}
	}
	public function get_data($url) {
		$ch = curl_init ();
		$timeout = 5;
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_HEADER, false );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_REFERER, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
		$result = curl_exec ( $ch );
		curl_close ( $ch );
		return $result;
	}
	public function saveFileFromLink($file='',$linkFolder='',$linkFolder_th=''){
		if(empty($file) || empty($linkFolder)){
			return FALSE;
		}
		
		
		/*
		$size = @getimagesize($file); 
		$fileextension = explode('/',$size['mime']);
		$fileextension = $fileextension[1];
		*/
		$fileextension = 'jpg';
		
		$time = microtime();
		$time = str_replace(' ','',$time);
		$name = $time.'.'.$fileextension;
		
		$name = $this->checkFile($name,$linkFolder);
		
		$contentFile = $this->get_data($file);
		$contentFile1 = json_decode($contentFile,true);
		if(empty($contentFile) || (!empty($contentFile1['status_code']) && $contentFile1['status_code'] == '404')) 
			return false;
		
		@file_put_contents($linkFolder.$name, $contentFile);
		if(!empty($linkFolder_th))
			@file_put_contents($linkFolder_th.$name, $contentFile);
		
		return $name;
	}

	//fo upload img from machine
	private function check_file_extent($file_name,$file_extent){
		$pattern='#.+\.('.$file_extent.')$#i';
		if(preg_match($pattern,$file_name)==1){
			$file_type=true;
		}
		else{
			$file_type=false;
		}
		return $file_type;
	}
	public function up_img($namefield,$linkFolder = '',$linkFolder_th = ''){
		if(empty($_FILES[$namefield]['name']) || empty($_FILES[$namefield]['tmp_name'])){
			return false;
		}
		
		$file_name=$_FILES[$namefield]['name'];
		//print_r($file_name);die;
		$extent_file='gif|jpg|png|jpeg';
		if(!is_array($file_name)){
			if($this->check_file_extent($file_name,$extent_file)==true){
				$pos=strrpos($file_name,".");
				$fileextension=substr($file_name,$pos);
				//echo $fileextension;die;
				$time = microtime();
				$time = str_replace(' ','',$time);
				$name = $time.$fileextension;
				$name = $this->checkFile($name,$linkFolder);
				
				move_uploaded_file($_FILES[$namefield]['tmp_name'],$linkFolder.$name);
				if(!empty($linkFolder_th)){
					copy($linkFolder.$name,$linkFolder_th.$name);
				}
				return $name;
			}
			else{
				return false;
			}
		}
		else{
			$arrName = array();
			foreach($file_name as $key=>$val){
				if($this->check_file_extent($val,$extent_file)==true){
					$pos=strrpos($val,".");
					$fileextension=substr($val,$pos);
					//echo $fileextension;die;
					$time = microtime();
					$time = str_replace(' ','',$time);
					$name = $time.$fileextension;
					$name = $this->checkFile($name,$linkFolder);
					move_uploaded_file($_FILES[$namefield]['tmp_name'][$key],$linkFolder.$name);
					if(!empty($linkFolder_th)){
						copy($linkFolder.$name,$linkFolder_th.$name);
					}
					$arrName[$key] = $name;
				}
			}
			return $arrName;
		}	
		
	}
	
	public function copyfile($namefield='',$linkFolderRoot='',$linkFolder = '',$linkFolder_th = ''){
		if(empty($namefield) || empty($linkFolderRoot) || empty($linkFolder))
			return false;
		
		$name = $this->checkFile($namefield,$linkFolder);
		//echo $namefield,'<br/>',$linkFolder,'<br/>',$name;die;
		if(!@copy($linkFolderRoot.$namefield,$linkFolder.$name)){
			return false;
		}
		if(!empty($linkFolder_th)){
			@copy($linkFolderRoot.$namefield,$linkFolder_th.$name);
		}
		return $name;
	}
}
?>