<?php 
namespace COMPRESSOR;
/**
 * compressor.php
 */

class Compressor {

    private static $instance;

    public function __construct() {
        //constructor 
    }

    public function index() {
        echo 'mounted ..';
    }
    
    public function upload_image($image, $imageQuality=60) {

        $uploadTo       = "uploads/images/"; 
        $allowImageExt  = ['jpg','png','jpeg','gif'];
        $imageName      = $image['image']['name'];
        $tempPath       = $image["image"]["tmp_name"];
    
        $basename = basename($imageName);
        $originalPath = $uploadTo.$basename; 
        $imageExt = pathinfo($originalPath, PATHINFO_EXTENSION); 
    
        if( empty( $imageName ) ) { 

            $error = "Please Select files..";
            return $error;
         
         } else {
       
            if( in_array( $imageExt, $allowImageExt ) ){ 
        
                $compressedImage = $this->compress_image( $tempPath, $originalPath, $imageQuality );

                if( $compressedImage ){

                    return "Image was compressed and uploaded to server " . $this->base_url() . $compressedImage;

                } else{
                    return "Some error !.. check your script";
                }
                
            } else {

                return "Image Type not allowed";

            }
        
        } 
    }

    private function compress_image( $tempPath, $originalPath, $imageQuality ) {
  
        // Get image info 
        $imgInfo    = getimagesize($tempPath); 
        $mime       = $imgInfo['mime']; 
         
        // Create a new image from file 
        switch($mime){ 
            case 'image/jpeg': 
                $image = imagecreatefromjpeg($tempPath); 
                break; 
            case 'image/png': 
                $image = imagecreatefrompng($tempPath); 
                break; 
            case 'image/gif': 
                $image = imagecreatefromgif($tempPath); 
                break; 
            default: 
                $image = imagecreatefromjpeg($tempPath); 
        } 
         
        // Save image 
        imagejpeg( $image, $originalPath, $imageQuality );  
        // Return compressed image 
        return $originalPath; 
    
    }

    public function base_url() {
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_URI']
        );
    }

    public function formatSizeUnits($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);
        $data = curl_exec($ch);
        $fileSize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $fileSize > 0 ? floor(log($fileSize, 1024)) : 0;
        return number_format($fileSize / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

    // define static instance
    public static function instance() {

        if ( is_null( self::$instance ) ){
            self::$instance = new self();
        }
        return self::$instance;

    }


}