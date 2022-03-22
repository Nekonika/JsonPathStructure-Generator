<?php

function listFolderFiles($dir = '')
{
    $currentDir   = "." . DIRECTORY_SEPARATOR . $dir;
    $fileInfo     = scandir($currentDir);
    $allFileLists = [];

    foreach ($fileInfo as $folder) {
        if ($folder !== '.' && $folder !== '..' && !str_starts_with($folder, ".")) {
            $fileData = [];

            if (is_dir($currentDir . DIRECTORY_SEPARATOR . $folder) === true) {
                $fileData["type"] = "folder";
                $fileData["name"] = $folder;
                $fileData["path"] = $dir . DIRECTORY_SEPARATOR . $folder;
                $fileData["children"] = listFolderFiles($dir . DIRECTORY_SEPARATOR . $folder);
            } else {
                $fileData["type"] = "file";
                $fileData["name"] = $folder;
                $fileData["path"] = $dir . DIRECTORY_SEPARATOR . $folder;
            }

            array_push($allFileLists, $fileData);
        }
    }

    return $allFileLists;
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode(listFolderFiles(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
?>