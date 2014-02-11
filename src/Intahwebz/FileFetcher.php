<?php

namespace Intahwebz;

interface FileFetcher {

    /**
     * @param $formFileName
     * @return mixed
     * @throws \InvalidArgumentException
     */
    function getUploadedFile($formFileName);
}




 