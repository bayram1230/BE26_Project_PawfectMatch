<?php
function fileUpload($param, $source = "user") {

    if ($param["error"] == 4) {
       
        $pictureName = "default-user.png";

        if ($source == "animal") {
            $pictureName = "default-animals.png";
        }

        $message = "No picture selected";
    } else {

        $checkIfImage = getimagesize($param["tmp_name"]);
        $message = $checkIfImage ? "ok" : "not a valid image file";
    }

    if ($message == "ok") {

        $ext = strtolower(pathinfo($param["name"], PATHINFO_EXTENSION));
        $pictureName = uniqid("") . "." . $ext;

        $destination = __DIR__ . "/../img/$pictureName";


        if ($source == "animal") {
            $destination = "../img/$pictureName";
        }

        move_uploaded_file($param["tmp_name"], $destination);
    }

    return [$pictureName, $message];
}
?>
