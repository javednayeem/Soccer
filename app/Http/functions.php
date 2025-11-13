<?php

function createFolderIfNotExists($folderPath, $location='public') {

    $directoryPath = public_path($folderPath);
    if ($location == 'storage') $directoryPath = storage_path($folderPath);

    if (! is_dir($directoryPath)) mkdir($directoryPath, 0755, true);
}


function formatDateTime($date, $format=24) {
    if ($format == 24) return date('F j, Y H:i:s', strtotime( $date ));
    else return date('F j, Y h:i A', strtotime( $date ));
}


function formatDate($date, $format='F j, Y') {
    return date($format, strtotime( $date ));
}
