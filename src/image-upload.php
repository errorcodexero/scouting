<?php
$fileName = $_FILES['afile']['name'];
$fileType = $_FILES['afile']['type'];
$team = $_POST['team'];
$fileContent = file_get_contents($_FILES['afile']['tmp_name']);
$dataUrl = 'data:' . $fileType . ';base64,' . base64_encode($fileContent);

/*
$trace = fopen("c:/temp/scouting.log");
$dir = __DIR__ . "/$team/";
$images = scandir($dir);

foreach ($images as $image) {
    fprintf($trace, "%image\n");
}

fclose($trace);

file_put_contents("c:/temp/foo-$team.png", $fileContent);
//$tmp_name = $_FILES["pictures"]["tmp_name"][$key];
//        $name = $_FILES["pictures"]["name"][$key];
//        move_uploaded_file($tmp_name, "$uploads_dir/$name");
*/

$json = json_encode(array(
'name' => $fileName,
'type' => $fileType,
'dataUrl' => $dataUrl,
));
 
echo $json;
?>