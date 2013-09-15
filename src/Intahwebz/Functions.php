<?php

namespace Intahwebz {

    class Functions {
        public static function load() {
        }
    }

}


namespace { // global code

    use Intahwebz\Utils\Utils;
    use Intahwebz\Utils\RemoteDownloadedFile;
    use Intahwebz\Utils\UserUploadedFile;
    use Intahwebz\Utils\FileUploadException;

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

    /**
     * @param $imageURL
     * @return RemoteDownloadedFile
     */
    function	getImageFromLink($imageURL){
        $tempFilename = tempnam(sys_get_temp_dir(), 'Tux');

        $fileHandle = fopen($tempFilename, 'w+');

        $headerArray = curlDownloadFileAndReturnHeaders($imageURL, $fileHandle);

        $urlInfo = parse_url($imageURL);

        $fileInfo = array();

        foreach($headerArray as $headerKey => $headerValue){
            if(strcasecmp('Content-type', $headerKey) == 0 ||
                strcasecmp('content_type', $headerKey) == 0){
                $fileInfo['contentType'] = $headerValue;
            }
        }

        $lastSlashPosition = strrpos($urlInfo['path'], '/');

        if($lastSlashPosition === FALSE){
            $filename = $urlInfo['path'];
        }
        else{
            $filename = substr($urlInfo['path'], $lastSlashPosition + 1);//+1 to exclude the slash
        }

        if(strlen($filename) == 0){
            $filename = date("Y_m_d_H_i_s");
            //Cannot guess image type from made up file name.

            if(array_key_exists('contentType', $fileInfo) == TRUE){
                $extension = Utils::getFileExtensionForMimeType($fileInfo['contentType']);
                $filename .= ".".$extension;
            }
        }

        fclose($fileHandle);

        return new RemoteDownloadedFile(
            $filename,
            $tempFilename,
            filesize($tempFilename)
        );
    }

    function getNormalizedFILES(){
        $newFiles = array();
        foreach($_FILES as $fieldName => $fieldValue){
            foreach($fieldValue as $paramName => $paramValue){
                foreach((array)$paramValue as $index => $value){
                    $newFiles[$fieldName][$paramName] = $value;
                }
            }
        }
        return $newFiles;
    }


    /**
     * @param $formFileName
     * @return UserUploadedFile
     * @throws FileUploadException
     * @throws Exception
     */
    function getUserUploadedFile($formFileName){
        //logToFileDebug("getUploadedFileInfo");

        $files = getNormalizedFILES();

        if(isset($files[$formFileName]) == FALSE){
            //logToFileDebug_var($files);
            //throw new Exception("File not uploaded. \$files[".$formFileName."] is not set.");
            return false;
        }
        else{
            if($files[$formFileName]['error'] == UPLOAD_ERR_OK) {
                if(is_uploaded_file($files[$formFileName]['tmp_name']) ){
                    //logToFileDebug("File [$formFileName] looks valid details are ".getVar_DumpOutput($files[$formFileName]));

                    return new UserUploadedFile(
                        $files[$formFileName]['name'],
                        $files[$formFileName]['tmp_name'],
                        $files[$formFileName]['size']
                    );
                }
                else{
                    throw new FileUploadException("File not uploaded. Status [".$files[$formFileName]['error']."] indicated error.");
                }
            }
            else{
                //var_dump($files);
                throw new FileUploadException("Error detected in upload: ".getFileUploadErrorMeaning($files[$formFileName]['error']));
            }
        }
    }




    function getFileUploadErrorMeaning($errorCode){

        switch($errorCode){
            case (UPLOAD_ERR_OK):{ //no error; possible file attack!
                return "There was a problem with your upload.";
            }
            case (UPLOAD_ERR_INI_SIZE): {//uploaded file exceeds the upload_max_filesize directive in php.ini
                return "The file you are trying to upload is too big.";
            }
            case (UPLOAD_ERR_FORM_SIZE):{ //uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form
                return "The file you are trying to upload is too big.";
            }
            case UPLOAD_ERR_PARTIAL: {//uploaded file was only partially uploaded
                //Todo - allow partial uploads
                return 	"The file you are trying upload was only partially uploaded.";
            }
            case (UPLOAD_ERR_NO_FILE): {//no file was uploaded
                return 	"You must select a file for upload.";
            }

            //TODO - handle these
//			UPLOAD_ERR_NO_TMP_DIR
//			UPLOAD_ERR_CANT_WRITE
//			UPLOAD_ERR_EXTENSION

            default: {	//a default error, just in case!  :)
            return	"There was a problem with your upload, error code is ".$errorCode;
            }
        }
    }


}
