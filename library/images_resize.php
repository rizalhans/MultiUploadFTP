<?php
//load data Class
class RanaImage {   
	var $image; 
	var $image_type;
   public function load($filename) {   
   	$image_info = getimagesize($filename);
	$this->image_type = $image_info[2];

	if( $this->image_type == IMAGETYPE_JPEG ) {   

		$this->image = imagecreatefromjpeg($filename);

	} elseif( $this->image_type == IMAGETYPE_GIF ) {   

		$this->image = imagecreatefromgif($filename);

	}elseif( $this->image_type == IMAGETYPE_PNG ) {

		$this->image = imagecreatefrompng($filename);
	} 
   } 
   public function save($filename, $image_type=IMAGETYPE_JPEG, $compression=100, $permissions=null) {   

   	if( $image_type == IMAGETYPE_JPEG ) { 

		imagejpeg($this->image,$filename,$compression); 

	} elseif( $image_type == IMAGETYPE_GIF ) {  

		imagegif($this->image,$filename); 

	} elseif( $image_type == IMAGETYPE_PNG ) {   

		imagepng($this->image,$filename); 

	} if($permissions != null) {   
		chmod($filename,$permissions); 
	}

   } 
   public function output($image_type=IMAGETYPE_JPEG) {   

   	if( $image_type == IMAGETYPE_JPEG ) { 

		imagejpeg($this->image); 

	} elseif( $image_type == IMAGETYPE_GIF ) {  

		imagegif($this->image); 

	} elseif( $image_type == IMAGETYPE_PNG ) {   

		imagepng($this->image); 

	} 

   }
   public function getWidth() {   
   		return imagesx($this->image); 
   } 

   public function getHeight() {  

   		return imagesy($this->image); 

   } 

   public function resizeToHeight($height) {  

   		$ratio = $height / $this->getHeight();

		$width = $this->getWidth() * $ratio;

		if($width <= 10) {
			$width = $this->getWidth();
		}

		$this->resize($width,$height);

   }

   public function resizeToWidth($width) { 

   		$ratio = $width / $this->getWidth();

		$height = $this->getheight() * $ratio; 

		if($height <= 10) {
			$height = $this->getheight();
		}

		$this->resize($width,$height); 

   }   

   public function thumb($size) { 

   		$height = $this->getheight();

		$width = $this->getWidth();

   		if($height > $width) {

			$this->resizeToHeight($size);	
			

		} else {
			
			$this->resizeToWidth($size);		

		}

   }
   public function thumbproduk($size) { 

   		$height = $this->getheight();

		$width = $this->getWidth();

   		if($height < $width) {

			$this->resizeToHeight($size);	
			

		} else {
					
			$this->resizeToWidth($size);
			
		}

   }
   public function scale($scale) { 

   		$width = $this->getWidth() * $scale/100; 

		$height = $this->getheight() * $scale/100; 

		$this->resize($width,$height); 

   } 

   public function resize($width,$height) { 

   	$new_image = imagecreatetruecolor($width, $height);
	
	$backgroundColor = imagecolorallocate($new_image, 255, 255, 255);
	
    imagefill($new_image, 0, 0, $backgroundColor);

	imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight()); 

	$this->image = $new_image; 
	

   } 

}

?>