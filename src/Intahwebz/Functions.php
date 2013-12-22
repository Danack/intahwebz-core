<?php

namespace Intahwebz {

    class Functions {
        public static function load() {
        }
    }
}


namespace { // global code

    use Intahwebz\UnknownFileType;
    use Intahwebz\UnknownMimeType;

    function getLastModifiedTime($timestamp) {
        return gmdate('D, d M Y H:i:s', $timestamp). ' UTC';
    }

    function getFileLastModifiedTime($fileNameToServe) {
        return getLastModifiedTime(filemtime($fileNameToServe));
    }

    function getClassName($namespaceClass) {
        $lastSlashPosition = mb_strrpos($namespaceClass, '\\');

        if ($lastSlashPosition !== false) {
            return mb_substr($namespaceClass, $lastSlashPosition + 1);
        }

        return $namespaceClass;
    }

    function getNamespace($namespaceClass) {
        $lastSlashPosition = mb_strrpos($namespaceClass, '\\');

        if ($lastSlashPosition !== false) {
            return mb_substr($namespaceClass, 0, $lastSlashPosition);
        }

        return "\\";
    }

    function convertNamespaceClassToFilepath($namespaceClass) {
        /** @noinspection PhpUndefinedFunctionInspection */
        return mb_str_replace('\\', "/", $namespaceClass);
    }

    function ensureDirectoryExists($filePath) {
        $pathSegments = array();

        $slashPosition = 0;
        $finished = false;

        while ($finished === false) {

            $slashPosition = mb_strpos($filePath, '/', $slashPosition + 1);

            if ($slashPosition === false) {
                $finished = true;
            }
            else {
                $pathSegments[] = mb_substr($filePath, 0, $slashPosition);
            }

            $maxPaths = 20;
            if (count($pathSegments) > $maxPaths) {
                throw new \Exception("Trying to create a directory more than $maxPaths deep. What is wrong with you?");
            }
        }

        foreach ($pathSegments as $segment) {
            //echo "check $segment<br/>";

            if (file_exists($segment) === false) {
                //echo "Had to create directory $segment";
                $result = mkdir($segment);

                if ($result == false) {
                    throw new \Exception("Failed to create segment [$segment] in ensureDirectoryExists($filePath).");
                }
            }
        }

        return true;
    }


    function renameMultiplatform($oldFilename, $newFilename) {
        $result = true;

        ensureDirectoryExists($newFilename);

        $renameResult = rename($oldFilename, $newFilename);

        if (!$renameResult) {
            if (copy($oldFilename, $newFilename) == true) {
                unlink($oldFilename);
                $result = true;
            }
            else {
                $result = false;
            }
        }

        return $result;
    }


    function convertFilepathToNamespaceClass($filepath) {

        $dotPosition = mb_strpos($filepath, '.');
        if ($dotPosition !== false) {
            $filepath = mb_substr($filepath, 0, $dotPosition);
        }

        /** @noinspection PhpUndefinedFunctionInspection */
        return mb_str_replace("/", '\\', $filepath);
    }


    define('OBJECT_TYPE', 'x-objectType');

    function parse_classname($name) {
        return array('namespace' => array_slice(explode('\\', $name), 0, -1), 'classname' => join('', array_slice(explode('\\', $name), -1)),);
    }

    function class_uses_deep($class, $autoload = true) {
        $traits = [];
        do {
            $traits = array_merge(class_uses($class, $autoload), $traits);
        } while ($class = get_parent_class($class));
        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait, $autoload), $traits);
        }

        return array_unique($traits);
    }


    /**
     * Return a JSON string for all of the public variables of an object.
     *
     *
     * @param $object
     * @return string
     */
    function json_encode_object_internal($object) {
        if (is_object($object) == true || is_array($object) == true) {
            $params = array();

            if (is_object($object) == true) {
                $type = get_class($object);
                $params[OBJECT_TYPE] = $type;
            }

            foreach ($object as $key => $value) {
                $value = json_encode_object_internal($value);
                $params[$key] = $value;
            }

            return $params;
        }

        return $object;
    }

    function json_encode_object($object) {
        $params = json_encode_object_internal($object);

        //return json_encode($params, JSON_HEX_APOS|JSON_PRETTY_PRINT);
        //Cannot use pretty print - it breaks Javascript :(
        return json_encode($params, JSON_HEX_APOS);
    }


    function json_decode_object($jsonString) {
        $jsonData = json_decode($jsonString, true);
        return json_decode_object_internal($jsonData);
    }


    function json_decode_object_internal($jsonData) {
        if (is_array($jsonData)) {
            $data = array();
            $isObject = false;

            if (array_key_exists(OBJECT_TYPE, $jsonData) == true) {
                $objectType = $jsonData[OBJECT_TYPE];
                $data = new $objectType();
                $isObject = true;
            }

            foreach ($jsonData as $key => $value) {
                if ($key == OBJECT_TYPE) {
                    continue;
                }

                if (is_array($value) == true) {
                    $value = json_decode_object_internal($value);
                }

                if ($isObject == true) {
                    $data->$key = $value;
                }
                else {
                    $data[$key] = $value;
                }
            }

            return $data;
        }

        return $jsonData; //was a value
    }

    function    safeTextObject($string) {

        if (is_object($string) == true) {
            return "";
        }
        if (is_array($string) == true) {
            return "";
        }

        return htmlentities($string, ENT_DISALLOWED | ENT_HTML401 | ENT_NOQUOTES, 'UTF-8');
    }

    function    safeText($string) {
        return htmlentities($string, ENT_DISALLOWED | ENT_HTML401 | ENT_NOQUOTES, 'UTF-8');
    }

//Converts an SQL datestamp into a formatted string
// e.g. 2008-11-11 16:20:24
// -> 11th Nov 08
    function formatDateString($datestamp, $format, $offsetTime = 0) {
        $year = intval(mb_substr($datestamp, 0, 4));
        $month = intval(mb_substr($datestamp, 5, 2));
        $day = intval(mb_substr($datestamp, 8, 2));

        $hours = intval(mb_substr($datestamp, 11, 2));
        $minutes = intval(mb_substr($datestamp, 14, 2));
        $seconds = intval(mb_substr($datestamp, 17, 2));

        $unixTimestamp = mktime($hours, $minutes, $seconds, $month, $day, $year);
        $unixTimestamp += $offsetTime;

        return date($format, $unixTimestamp);
    }

    function getKnownMimeTypesForExtensions() {
    
        $knownMimeTypesForExtensions = array(
            "3gp"	=>	"video/3gpp",
            "amr"	=>	"audio/amr",
            "apk"	=>	"application/vnd.android.package-archive",
            "au"	=>	"audio/basic",
            "aif"	=>	"audio/x-aiff",
            "aifc"	=>	"audio/x-aiff",
            "aiff"	=>	"audio/x-aiff",
            "asf"	=>	"video/x-ms-asf",
            "avi"	=>	"video/x-msvideo",
            "bmp"	=>	"image/x-ms-bmp",
            "bz2"	=>	"application/x-bzip2",
            "conf"	=>	"text/plain",
            "css"	=>	"text/css",
            "csv"	=>	"text/comma-separated-values",
            "doc"	=>	"application/msword",
            "docx"	=>	"application/msword",
            "exe"	=>	"application/octet-stream",
            "flac"	=>	"audio/flac",
            "gif"	=>	"image/gif",
            "gz"	=>	"application/x-gzip",
            "gzip"	=>	"application/x-gzip",
            "html"	=>	"text/html",
            "ics"	=>	"text/calendar",
            "jpe"	=>	"image/jpeg",
            "jpeg"	=>	"image/jpeg",
            "jpg"	=>	"image/jpeg",
            "kml"	=>	"application/vnd.google-earth.kml+xml",
            "kmz"	=>	"application/vnd.google-earth.kmz",
            "mid"	=>	"audio/mid",
            "m4a"	=>	"audio/mp4",
            "md"	=> "text/markdown",
            "mp3"	=>	"audio/mpeg",
            "mp4"	=>	"video/mp4",
            "mpg"	=>	"video/mpeg",
            "mpeg"	=>	"video/mpeg",
            "mpe"	=>	"video/mpeg",
            "mov"	=>	"video/quicktime",
            "ogv"	=>	"video/ogg",
            "odp"	=>	"application/vnd.oasis.opendocument.presentation",
            "ods"	=>	"application/vnd.oasis.opendocument.spreadsheet",
            "odt"	=>	"application/vnd.oasis.opendocument.text",
            "oga"	=>	"audio/ogg",
            "ogg"	=>	"audio/ogg",
            "pdf"	=>	"application/pdf",
            "php"	=>	"application/x-php",
            "png"	=>	"image/png",
            "pptx"	=>	"application/vnd.ms-powerpoint",
            "pps"	=>	"ppt application/vnd.ms-powerpoint",
            "rmi"	=>	"audio/mid",
            "qt"	=>	"video/quicktime",
            "smil"	=>	"application/smil",
            "snd"	=>	"audio/basic",
            "swf"	=>	"application/x-shockwave-flash",
            "sxc"	=>	"application/vnd.sun.xml.calc",
            "sxw"	=>	"application/vnd.sun.xml.writer",
            "tar"	=>	"application/x-tar",
            "text"	=>	"text/plain",
            "txt"	=>	"text/plain",
            "tif"	=>	"image/tiff",
            "tiff"	=>	"image/tiff",
            "vcf"	=>	"text/x-vcard",
            "wav"	=>	"audio/wav",
            "wbmp"	=>	"image/vnd.wap.wbmp",
            "wma"	=>	"audio/x-ms-wma",
            "wmv"	=>	"video/x-ms-wmv",
            "wsdl"	=>	"application/wsdl+xml",
            "xls"	=>	"application/vnd.ms-excel",
            "xlsx"	=>	"application/vnd.ms-excel",
            "zip"	=>	"application/x-zip-compressed"
        );
        
        return $knownMimeTypesForExtensions;
    }

    function getMimeTypeForFileExtension($extension){
        $knownMimeTypesForExtensions = getKnownMimeTypesForExtensions();
        $extension = strtolower($extension);

        if (array_key_exists($extension, $knownMimeTypesForExtensions) == false) {
            throw new UnknownFileType($extension, "Unknown file type for extension [$extension]");
        }

        $type = $knownMimeTypesForExtensions[$extension];

        return $type;
    }

    function getFileExtensionForMimeType($mimeType) {
        $knownMimeTypesForExtensions = getKnownMimeTypesForExtensions();
        $mimeType = strtolower($mimeType);
        $arrayKey = array_search ($mimeType, $knownMimeTypesForExtensions);

        if ($arrayKey === false) {
            throw new UnknownMimeType($mimeType, "Unknown mime type [$mimeType], cannot return extension.");
        }

        return $knownMimeTypesForExtensions[$mimeType];
    }

    function setFileType($extension, $mimeType) {
        $knownMimeTypesForExtensions[$extension] = $mimeType;
    }

    function getImageFileType($filename) {
        $knownImageTypes = [
            'jpg',
            'jpeg',
            'gif',
            'png'
        ];

        $pathInfo = pathinfo($filename);
        $fileExtension = mb_strtolower($pathInfo['extension']);

        if (in_array($fileExtension, $knownImageTypes) == true) {
            return $knownImageTypes[$fileExtension];
        }

        return 'jpg';
    }

    function getCalledFromString($stackLevel = 1){ //$stackLevel 1 = previous function

        $debugBackTrace = debug_backtrace();

        $file = "Unknown";
        $line = "Unknown";
        $function = "Unknown";

        $index = $stackLevel;

        if(isset($debugBackTrace[$index]) == true){

            if(isset($debugBackTrace[$index]['file']) == true){
                $file = $debugBackTrace[$index]['file'];
            }
            if(isset($debugBackTrace[$index]['function']) == true){
                $function = $debugBackTrace[$index]['function'];
            }
            if(isset($debugBackTrace[$index + 1]['function']) == true){
                $function = $debugBackTrace[$index + 1]['function'];
            }
            if(isset($debugBackTrace[$index]['line']) == true){
                $line = $debugBackTrace[$index]['line'];
            }
        }

        /*if(function_exists('getSessionVariable') == true){
            if(isset($GLOBALS['overrideForbiddenFunction']) == false ||
                $GLOBALS['overrideForbiddenFunction'] == false){
    
                $clientID = false;
    
                if(isset($_SESSION['envelos']) == true){
                    if(array_key_exists('clientID', $_SESSION['envelos']) == true){
                        $clientID = $_SESSION['envelos']['clientID'];
                    }
                }
    
                if($clientID){	//We're in a session
                    $forbiddenFunctions = array(
                        'loadCountryScheme',
                        'loadCountrySchemeForUserID',
                        'loadCountrySchemeForClient'
                    );
    
                    foreach($forbiddenFunctions as $forbiddenFunction){
                        if(strcmp($function, $forbiddenFunction) === 0){
                            $errorString = "Forbidden function [$forbiddenFunction] detected.";
                            $errorString .= emitCallStack();
                            logtoFileFatal($errorString);
                        }
                    }
                }
            }
        }*/

        //$calledFromString = "File ".$file." line ".$line." function ".$function;
        $calledFromString = "".$file." line ".$line." fn ".$function;

        return $calledFromString;
    }


    function emitCallStack(){

        $debugBackTrace = debug_backtrace();

        $first = true;

        $output = "";

        foreach($debugBackTrace as $debugTrace){

            if($first === false){
                if(array_key_exists('file', $debugTrace) == true){
                    $output .= 'File '.$debugTrace['file'];
                }
                else if(array_key_exists('class', $debugTrace) == true){
                    $output .= 'Class '.$debugTrace['class'];
                }
                else{
                    $output .= 'File N/A';
                }

                $output .= ", Function: ".$debugTrace['function'];

                if(array_key_exists('line', $debugTrace) == true){
                    $output .= " Line: ".$debugTrace['line'];
                }
                else{
                    $output .= ' Line: N/A';
                }

                $output .=  "<br/> \r\n";
            }
            $first = false;
        }

        //echo $output;
        //exit(0);

        return $output;
    }

    function castToObject($fullClassName, $contentWithJoin) {
        $newArray = array();

        foreach($contentWithJoin as $key => $value){
            $dotPosition = mb_strpos($key, ".");
            if($dotPosition !== false){
                $newKey = mb_substr($key, $dotPosition + 1);
                $newArray[$newKey] = $value;
            }
        }

        $newArray['uniqueID'] = uniqid();
        $newArray['x-objectType'] = $fullClassName;

        return json_decode_object_internal($newArray);
    }


    function castArraysToObjects($fullClassName, $contentWithJoinArray){
        $objects = array();

        foreach($contentWithJoinArray as $contentWithJoin){
            $objects[]  = castToObject($fullClassName, $contentWithJoin);
        }

        return $objects;
    }
}
