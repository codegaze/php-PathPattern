<?php

namespace PathPattern;

class Folder
{
    /**
     * The default value of the base path to add the pattern.
     * Can be set in __construct or getPath() tha use setBasePath()
     * or in  setBasePath() seperately
     * @var string
     */
    protected $basePath = './';

    /**
     * The default value of the path pattern to create
     * Can be set in __construct or getPath() tha use setBasePath()
     * or in  setBasePath() seperately
     * @var string
     */
    protected $pattern = ':Y/:m/:d';

    /** 
     * Creates an instance of the \PathPattern\Folder object 
     * @param $basePath overwrites the $basepath variable
     * @param $pattern overwrites the $pattern variable
     */
    public function __construct($basePath = null, $pattern = null)
    {

        if ($basePath !== null) {
            $this->setBasePath($basePath);
        }
        
        if ($pattern !== null) {
            $this->setPattern($pattern);
        }

    }

    /**
     * Method to set/overwrite the default $basePath value.
     * Echoes error if the path doesn't exist  
     * @param String $basePath
     */
    public function setBasePath($basePath)
    {

       if (!self::pathExists($basePath)) {
            echo 'Error: The path you set does not exist!';
            exit;
        } else {
            $this->basePath = $basePath;
        }

    }

    /**
     * Method to set/overwrite the default $pattern value 
     * @param String $pattern
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * The main method to return the path the user requested.
     * If the $basePath or $pattern is set then it overwrites the default values
     * @param  String $basePath
     * @param  String $pattern
     * @return String Returns the String result of \PathPattern\Folder\reConstructPath();
     */
    public function getPath($basePath = null, $pattern = null)
    {   
        if ($basePath !== null) {
            $this->setBasePath($basePath);
        }
        
        if ($pattern !== null) {
            $this->setPattern($pattern);
        }

        return $this->reConstructPath();
    }

    /**
     * Checks if given path exists and returns true or false
     * @param  string $path is the path to check if exists
     * @return boolean if the path exists
     */
    public static function pathExists($path)
    {

        if (!file_exists($path) || !is_dir($path)) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * Method to split each folder with '/' and check if is 
     * a date pattern with isDatePattern() method and create
     * the path if doesnt exist
     * @return string of reconstructed path to getPath() method
     */
    public function reConstructPath()
    {
        $dirs = explode("/", $this->pattern);
        $path = $this->basePath;       

        foreach ($dirs as $key => $directory) {
            
            $path.= $this->sanitizePath(self::isDatePattern($directory) . '/');
        
        }

        if (!self::pathExists($path)) {

            self::newFolder($path);
        }

        return $path;
    }

    /**
     * Checks if give string has one or more date patterns
     * defined by ':' character and returns the value
     * @param  string 
     * @return string with 
     */
    protected static function isDatePattern($path)
    {
        preg_match_all("/\:(\S)/", $path, $pathArray);
        if (count($pathArray[1]) > 0) {
            $path = '';
            foreach ($pathArray[1] as $key => $value) {
                $path.= date($value);
            }
        }
        return $path;
    }

    /**
     * Create a folder for given $folder or return exception
     * @param  string $folder The folder to create
     * @return string exception if something goes wrong
     */
    protected static function newFolder($folder)
    {
        // TODO
        // Add Exception 
        try {

            mkdir($folder, 0755, true);
        } catch (Exception $e) {
            echo 'error';
            exit;
        }
        
   
    }

    /**
     * Removes all the illegal folder characters given
     * @param  string $folder is the pattern to sanitize
     * @return string clean string with pattern to use 
     */
    protected static function sanitizePath($folder)
    {
        return preg_replace("/[:\"?*<>|]/", "", $folder);
    }
}