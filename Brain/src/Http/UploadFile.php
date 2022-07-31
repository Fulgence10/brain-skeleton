<?php 

namespace Brain\Http;

class UploadFile {

    private array $files;

    private string $currentFile;

    /**
     *
     * @param string $currentFile
     */
    public function __construct(string $currentFile)
    {
        $this->files = $_FILES;

        $this->currentFile = $currentFile;
    }

    /**
     *
     * @return string|null
     */
    public function getFileName() : ?string
    {
        return $this->files[$this->currentFile]['name'];
    }

    /**
     *
     * @return string|null
     */
    public function getTmpPath() : ?string
    {
        return $this->files[$this->currentFile]['tmp_name'];
    }


    /**
     *
     * @return boolean
     */
    public function fileExists() : bool
    {
        return isset($this->files[$this->currentFile]) && $this->files[$this->currentFile]['error'] <= 0;
    }

    /**
     *
     * @return string|null
     */
    public function getExtenxion() : ?string
    {
        $filename = $this->getFileName();

        $ex = substr($filename, strpos($filename, '.', 1));
        
        return trim($ex, '.');
    }

    /**
     *
     * @param string $path
     * @return void
     */
    public function moveTo(string $path)
    {
        if(! $this->fileExists()) {
            return false;
        }
        
        return move_uploaded_file($this->getTmpPath(), $path);
    }

    /**
     *
     * @param string $finalPath
     * @param integer $w
     * @param integer $h
     * @param integer $q
     * @return boolean
     */
    function reSeize (string $finalPath, int $w, int $h = null, int $q = 100) : bool
    {
        $imgSize = \getimagesize($this->getTmpPath());

        $imgRessource = imagecreatefromjpeg($this->getTmpPath());
        
        if(is_null($h)) {
            $h = ($imgSize[1] * ($w / $imgSize[0]));
        }
        
        $imgFinal = \imagecreatetruecolor($w, $h);
       
        imagecopyresampled(
            $imgFinal, 
            $imgRessource, 0,0,0,0, 
            $w, $h, 
            $imgSize[0], $imgSize[1]
        );
       
        imagejpeg($imgFinal, $finalPath, $q);
        
        return true;
    }

}
