<?php

namespace Brain\Supports;

class Download
{
    private static $_instance = null;

    private $path;

    /**
     * Undocumented function
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Undocumented function
     *
     * @param string $path
     * @return self|null
     */
    public static function getIntance(string $path) : ?self
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new Download($path);
        }
        return self::$_instance;
    }

    /**
     * Undocumented function
     *
     * @param string $file
     * @return string|null
     */
    public function Download(string $file) : ?string
    {
        $file = $this->path . DIRECTORY_SEPARATOR . $file;
        if(file_exists($file)) {
            if(! $this->makeHeader($file)) {
                dd("Une erreur s'est produit lors du téléchargement du ficher");
                return null;
            }
        }
        return redirectTo('/');
    }

    /**
     * Undocumented function
     *
     * @param string $file
     * @return integer|null
     */
    private function makeHeader(string $file) : ?int
    {
        header("Expires: 0");
        header("Pragma: public");
        header("Content-Length: ".filesize($file));
        header("Content-Type: application/download");
        header("Content-Transfert-Encoding: binary");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachement; filename=".basename($file).";");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        
        return readfile($file);
    }
}