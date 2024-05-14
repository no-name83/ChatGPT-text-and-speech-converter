<?php
include 'function.php';




$apiKey = "";
 $output=fileExist();

  $output_folder=output_fileExist();

 

  $get_filename=get_filename();
if (isset($_POST['submit'])) {



 


 //if selected Ask Question
if (!empty($_POST['answ']) && empty($_POST['text'] && !empty($apiKey))) {
    
  

   $format=$_POST['Formats'];
    $message = $_POST['answ'];
   
   

          


query_result($apiKey,$message,$format);

   

}
  //if selected Write or Copy Text: 
 if (!empty($_POST['text']) && empty($_POST['answ']) && !empty($apiKey)) {

  $comment=$_POST['text'];

  $format=$_POST['Formats'];

  text($apiKey,$comment,$format);
}
//if selected speech to text
if ($output==true && empty($_POST['text']) && empty($_POST['answ'] && !empty($apiKey)) ) {
  



   


$path    = 'upload';
$files = scandir($path);
foreach ($files as $filename ) {
   

     $filename;
}



 speech_to_text($apiKey,$filename);





}



set_time_limit(0); 
define("UPLOAD_DIR", "upload/"); 
}
if (isset($_POST["send"])) {


 $countfiles = $_FILES['file']['name'];

        
      
              $filename = $_FILES['file']['name'];

            $total_size= filesize($filename);

      
//26214400 -- 25MB

            if ($total_size<='26214400') {
            	# code...
            	 $location = "upload/".$filename;
              $extension = pathinfo($location,PATHINFO_EXTENSION);
              $extension = strtolower($extension);

              ## File upload allowed extensions
              $valid_extensions = array("mp4","mpeg","mpga","m4a","wav","webm", "mp3");

             
              ## Check file extension
              if(in_array(strtolower($extension), $valid_extensions)) {
                   ## Upload file
                   if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){

                        
                   }
              }
            }
            
             
             

         

}





?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <script src="js/jquery-3.6.0.min.js" defer></script>
    
    <script src="js/jquery.form.min.js" defer></script>
    
    <script src="js/script.js" defer></script>
      <link rel="stylesheet" href="css/style.css" />

       <style>
        audio::-webkit-media-controls {

          <?php
         
          if ( $output_folder==false) {
            
            echo "display: none;";
           } 
           
            ?>
        }
    </style>

    
</head>
<body>

<div class="container">
  <h2>ChatGPT  Text To Speech</h2>
  <form action="" method="POST" enctype='multipart/form-data'>
    <div class="form-group">
      <label for="answ">Ask Question:</label>
      <input type="text" class="form-control" id="answ"  name="answ">
    </div>
    <div class="form-group">
      <label for="pwd">Write or Copy Text:</label>
       <textarea class="form-control" rows="5" id="text" name="text"></textarea>
       <label for="pwd">Output Formats:</label>
       <select id="Formats" name="Formats">
    <option value="mp3">mp3</option>
    <option value="aac">aac</option>
    <option value="flac">flac</option>
    <option value="pcm">pcm</option>
  </select><br/>
       <button type="submit" class="btn btn-primary" name="submit">Submit</button><br>
       <audio controls>
 
   <?php echo '<source src="output_speech/'.$get_filename.'" type="audio/mpeg">'?>

</audio>
        
    </div>
     </form>
    <form action="" method="POST" enctype='multipart/form-data' id="form">
    <div class="container">
        <div class="form-wrapper">
         
            <h2>Speech To Text</h2>
            <div class="file-input">
              
                <input type="file" name="file" id="btn-chose"  style="display:none" />

              
              <label class="custom-file" for="btn-chose">Choose File</label>

              
              <span id="file-chosen"  value="nochosen"> </span>
              <button class="btn btn-primary" type="submit" name="send" id="sendbtn">Send File</button>
             
            </div>
           
           
            
            
         

          
          <div class="uploading-status hidden">
            <div class="progress-bar" id="uploadingProgress"></div>
            <ul>
              <li>
                <strong><h5>Total Size:</h5></strong>
                <span id="totalSize"></span>
              </li>
              
             
            </ul>
          </div>
    
   
</div>
</form>
</body>
</html>
