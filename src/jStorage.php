<?php

namespace jStorage;

class App {
    
    /**
     * @var Storage
     */
    protected $storage;

    /**
     * Initialize storage
     * 
     * @param String        path
     * Use for store main storage file in project.
     * @param String|bool   gitignore
     * Use for add storage file to .gitignore file
     * Set false or leave empty to abort that proccess.
     */
    public function __construct($path = '/main.json', $gitignore = false) {
        if(!file_exists($path)) {
            $exploded = explode('/',$path);
            for($i = 0; $i <= sizeof($exploded) - 1;$i++) {
                if(strpos($exploded[$i],'.json')) {
                    $content = array();
                    $fp = fopen($path, "wb");
                    fwrite($fp, \json_encode($content));
                    fclose($fp);
                    $this->storage = file_get_contents($path);
                }else {
                    if( is_dir($exploded[$i]) === false ) {
                        mkdir($exploded[$i]);
                    }
                }
            }
        }else {
            $this->storage = file_get_contents($path);
        }

        if(!is_bool($gitignore)) {
            $ignores = file_get_contents($gitignore);
            if(!strstr($ignores, $path)) {
                echo ' has not';
                $fp = fopen($gitignore, "wb");
                $ignores .= $path . "\r\n";
                fwrite($fp, $ignores);
                fclose($fp);
            }
        }

    }

    public function add() {

    }

    public function update() {

    }

    public function remove() {

    }

    public function get() {
        
    }

}
