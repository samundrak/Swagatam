<?php 
 
 class Socio{
    private $input;
	private $location; 
	private $data;
	private $enc;
	 public function __construct($post){
	    $this->init();
		$this->data = $post;
	 }
	 
	 private function init(){
			$this->enc = sha1(md5(microtime()));
			$this->backUplocation = "backup/backup.html";
			$this->newLocation = "output/social_".$this->enc.".html";
			$this->json = "json/social.".$this->enc.".json";
	 }
	 
	 
	 public function generate(){
       
	  // if(isset($this->data)){
	   foreach($this->data as $_FORM){
        if(empty($_FORM)){
	 	   echo 1;
	   exit();
	   }
      }
        $key =  array('title','announce','announce_header','limit','out_click','esc_click','facebook_app_id','facebook_page','twitter_username','twitter_widget_id','gplus_type','gplus_id');
		$this->openNwrite($this->json,$key); 
		 
		 try{

if(!file_exists($this->json)){
  echo 0 ;
  exit;
}

  $open = file_get_contents($this->json);
  $json = json_decode($open);
  
  if(!file_exists($this->backUplocation)){
  echo 0; 
  exit;
}
 
 $file = file_get_contents($this->backUplocation);
    foreach($key as $keys){
	  $file =  str_replace('[%'.$keys.'%]',
	  $json->$keys,$file);
	}

$open = fopen($this->newLocation,'w');	
fwrite($open,$file);
fclose($open);   

$zip = new ZipArchive();
$filename = "downloads/social".$this->enc.".zip";
if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
											exit($this->lang->admin->alert->cOpen." <$filename>\n");
										}
										$zip->addFromString("readme.txt", ">-> This app code is downloaded from http://www.beingprogrammer.com <-<");
										 $zip->addFile($this->newLocation);
										 $zip->close();
echo  $filename;
unlink($this->json);
unlink($this->newLocation);
 }
catch(Exception $e){
   echo $e->getMessage();
}
	// }
}

private  function openNwrite($x,$y){
		for($i = 0; $i <= count($y) - 1; $i++){
		    $v[$y[$i]] = $this->clearInputData($_POST['input'][$i]); 
		}
		
		  $d = json_encode($v);
		  $o = fopen($x,"w");
		  fwrite($o,$d);
		  fclose($o);
		   
		  }
		  
		  
		    public function clearInputData($x){
   $y = @trim(@htmlentities(@ltrim(@$x)));
  return $y;   
  }	 
  	 
 }
?>