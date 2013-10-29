<?php

namespace Intahwebz;

//TODO - shouldn't this be in utils?

interface FileFetcher {

    /**
     * @param $formFileName
     * @return mixed
     * @throws \InvalidArgumentException
     */
    function getUploadedFile($formFileName);
}




 