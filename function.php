<?php

function delete_old_files(){


  $files = glob('upload/*'); 
foreach($files as $file){
    if(is_file($file))
    unlink($file); 
}
}


 function delete_old_output_files(){

  $files = glob('output/*'); 
foreach($files as $file){
    if(is_file($file))
    unlink($file); 
}

 }

 function get_filename(){


  $path    = 'output_speech';
$files = scandir($path);
foreach ($files as $filename ) {
   

     $filename;
}

return $filename;
 }


 function fileExist()
{
    
    $open = "upload/";

    if ($files = glob($open . "/*")) {
       
      
       $result= true;
      return $result;
    } else {
       
     
        $result=false;
      return $result;
    }
}



 function output_fileExist()
{
    
    $open = "output_speech/";

    if ($files = glob($open . "/*")) {
       
      
       $result= true;
      return $result;
    } else {
       
     
        $result=false;
      return $result;
    }
}

function query_result($apiKey,$message,$format){


  $output_location="output_speech";
 

 $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
          "model": "gpt-3.5-turbo-16k",
          "messages": [
            {
              "role": "user",
              "content": "'.$message.'"
            }
          ]
        }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$apiKey,
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);

  

    curl_close($curl);

    
    $json = json_decode($response);
    $completion = $json->choices[0]->message->content;

    // $completion;
  

    $ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/audio/speech');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json'
));
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    'model' => 'tts-1',
    'input' => $completion,
    'voice' => 'alloy'
)));

  $result = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    
    
  
file_put_contents($output_location."/".uniqid().".".$format, $result);
 header("refresh: 1"); 
}

curl_close($ch);

}
function text($apiKey,$text,$format){

//first delete old files
  delete_old_output_files();

$output_location="output_speech";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/audio/speech');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json'
));
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    'model' => 'tts-1',
    'input' => $text,
    'voice' => 'alloy'
)));

  $result = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    
    
   
  file_put_contents($output_location."/".uniqid().".".$format, $result);
  header("refresh: 1"); 
}

curl_close($ch);
}

function speech_to_text($apiKey,$filename){

$headers=array();
   $headers = [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type : "multipart/form-data'
    ];


    $ch = curl_init();

    
    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/audio/transcriptions');

    
    curl_setopt($ch, CURLOPT_POST, 1);

    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);



    $data = array(
        'file' => new CurlFile($filename),
        'model' => 'whisper-1'
             
        );
   
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    
    $response = curl_exec($ch);

   

  
  
   delete_old_files();
   
   $output_location="output";
   //create text file
   
   $file_name=uniqid()."."."txt";


     $new_str = preg_replace('~[\\\\{:}"]~', ' ', $response);
     $last_str=str_replace("text", '', $new_str);

   
   $myfile = fopen($output_location."/".$file_name, "w") or die("Unable to open file!");

fwrite($myfile, trim($last_str));

fclose($myfile);



}
?>