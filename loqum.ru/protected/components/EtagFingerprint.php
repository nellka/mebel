<?php
class EtagFingerprint {

    private $oldSession;
    public $session;
    public $etag;
    public $sessionDir;

    public function __construct($params) {

        if (isset($params['sessionDir'])) {
            $this->sessionDir = $params['sessionDir'];
        } else
            $this->sessionDir = '.';

        // etag autoinit from HTTP-header
        if (!isset($params['auto']) || $params['auto']==1) {
            if (isset($_SERVER["HTTP_IF_NONE_MATCH"])) {
                $params['etag'] = $_SERVER["HTTP_IF_NONE_MATCH"];
            }
        }

        if (isset ($params['etag'])) {
            $this->etag = $params['etag'];
            $this->loadSession();
        } else {
            $this->etag = substr(md5(time().sha1($_SERVER["REMOTE_ADDR"])),0,18);
            $this->createSession();
        }
    }

    public  function loadSession(){
        $filename = $this->getFileName();
        if (file_exists($filename))
            $this->oldSession = $this->session = unserialize(file_get_contents($filename));
    }

    public function saveSession(){
        if (empty($this->session))
            return 1;
        if ($this->session == $this->oldSession)
            return 1;
        $filename = $this->getFileName();
        return file_put_contents($filename,serialize($this->session));
    }

    public function createSession(){
        @unlink($this->getFileName()); // may or may not exist
        unset($this->session);
    }

    public function getFileName(){
        return $this->sessionDir . '/'. $this->etag;
    }

    public function sendFile()
    {
        $this->saveSession();
        header_remove();
        $imagefile = $_SERVER['DOCUMENT_ROOT'] . '/images/0x0.gif';
        header("Cache-Control: private, must-revalidate, proxy-revalidate");
        header("ETag: " . substr($this->etag, 0, 18)); // our "cookie"
        header("Content-type: image/gif");
        header("Content-length: " . filesize($imagefile));
        readfile($imagefile);
        die();
    }

}