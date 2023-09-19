<?php
ob_start();
echo "Title,Duration\n";
foreach(scandir("..".DIRECTORY_SEPARATOR."album") as $filepath){
    if(preg_match("/^\.+$/", $filepath)) continue;
    $filetext = file_get_contents(".." . DIRECTORY_SEPARATOR  . "album" . DIRECTORY_SEPARATOR . $filepath);
    preg_match_all("/Track\:\s(.+?)\s?\n/", $filetext, $titlematches);
    preg_match_all("/Duration\:\s'([0-9\:]+)'/", $filetext, $durationmatches);
    if(sizeof($titlematches[1]) !== sizeof($durationmatches[1])) continue;
    
    $matches = array_combine($titlematches[1], $durationmatches[1]);
    foreach($matches as $title=>$duration) {
        echo '"' . $title . '",';
        $timestamp = explode(":", $duration);
        echo intval($timestamp[0] * 60) + intval($timestamp[1]) . "\n";

    }
}

$file = ob_get_clean();
file_put_contents("durations.csv", $file);
echo $file;