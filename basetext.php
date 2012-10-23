<?php
/* basetext.php - backend
 * Script for transfering BIN over ACII
 * (c) 2012 David (daXXog) Volm
 * Released under Apache License, Version 2.0:
 * http://www.apache.org/licenses/LICENSE-2.0.html  
 */
find_basetext();

function find_basetext($originDirectory = "."){
    $CurrentWorkingDirectory = dir($originDirectory);
    while($entry=$CurrentWorkingDirectory->read()){
        if($entry != "." && $entry != ".."){
            if(is_dir2($originDirectory."/".$entry)){
                find_basetext($originDirectory."/".$entry);
             } else{
                if(strpos($entry, '.tar.bz2.b64.txt') !== false) {
                    extract_basetext($originDirectory."/".$entry);
                }
            }
        }
    }
    $CurrentWorkingDirectory->close();
}

function extract_basetext($fn) {
    echo "Extracting: ".$fn."<br>";
    file_put_contents(str_replace(".b64.txt", "", $fn), base64_decode(file_get_contents($fn)));
    exec("tar xvjf ".str_replace(".b64.txt", "", $fn));
    exec("chmod 777 -R *");
    unlink(str_replace(".b64.txt", "", $fn));
    unlink($fn);
}

function is_dir2($name) {
    return (@opendir($name)===false) ? false : true;
}
?>
