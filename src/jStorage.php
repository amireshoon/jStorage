<?php

namespace jStorage;

define('jSTORAGE_VERSION', '1.0.0');

class App {
    
    /**
     * @var Storage
     */
    protected $storage;

    /**
     * @var Path
     */
    protected $path;

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
                    fwrite($fp, json_encode($content));
                    fclose($fp);
                    $this->storage = json_decode(file_get_contents($path));
                    $this->path = $path;
                }else {
                    if( is_dir($exploded[$i]) === false ) {
                        mkdir($exploded[$i]);
                    }
                }
            }
        }else {
            $this->storage = json_decode(file_get_contents($path));
            $this->path = $path;
        }

        if(!is_bool($gitignore)) {
            $ignores = file_get_contents($gitignore);
            if(!strstr($ignores, $path)) {
                $fp = fopen($gitignore, "wb");
                $ignores .= $path . "\r\n";
                fwrite($fp, $ignores);
                fclose($fp);
            }
        }

    }

    public function commit() {
        $fp = fopen($this->path, "wb");
        fwrite($fp, json_encode($this->storage));
        fclose($fp);
        $this->storage = json_decode(file_get_contents($this->path));
    }

    public function add($key, $value) {
        $jStorageKey = hash('crc32', $key . \implode(" ",$value), false);
        if($this->is_key_exists($jStorageKey)) {
            return $this->jStorageRespose(
                [
                    'error' => false,
                    'message' => 'this data and value was inserted before.',
                    'jStorageKey' => $jStorageKey
                ]
            );
        }else {
            $this->storage[] = [
                'jStorage_key' => $jStorageKey,
                'jStorage_value' => [
                    'key' => $key,
                    'value' => $value
                ]
            ];
            return $this->jStorageRespose(
                [
                    'error' => false,
                    'jStorageKey' => $jStorageKey
                ]
            );
        }
    }

    public function update($key, $value) {
        for($i = 0; $i <= sizeof($this->storage) - 1 ;$i++) {
            $child = $this->storage[$i];
            $childData = $child->jStorage_value;
            if($childData->key == $key) {
                $this->storage[$i]->jStorage_value->value = $value;
                return $this->jStorageRespose(
                        [
                            'error' => false,
                            'message' => 'value updated.'
                        ]
                    );
            }
        }
        return $this->jStorageRespose(
                [
                    'error' => false,
                    'message' => 'key not founded.'
                ]
            );
    }

    public function remove($key) {
        for($i = 0; $i <= sizeof($this->storage) - 1 ;$i++) {
            $child = $this->storage[$i];
            $childData = $child->jStorage_value;
            if($childData->key == $key) {
                unset($this->storage[$i]);
                return $this->jStorageRespose(
                        [
                            'error' => false,
                            'message' => 'key removed.'
                        ]
                    );
            }
        }
        return $this->jStorageRespose(
            [
                'error' => false,
                'message' => 'key not found.'
            ]
        );
    }

    public function get($key) {
        for($i = 0; $i <= sizeof($this->storage) - 1 ;$i++) {
            $child = $this->storage[$i];
            $childData = $child->jStorage_value;
            if($childData->key == $key) {
                return $this->jStorageRespose(
                        [
                            'error' => false,
                            'message' => 'data received.'
                        ],
                        $childData
                    );
            }
        }
    }

    private function is_key_exists($jStorageKey) {
        for($i = 0; $i <= sizeof($this->storage) - 1;$i++) {
            $child = $this->storage[$i];
            if($child->jStorage_key == $jStorageKey) {
                return true;
            }
        }
        return false;
    }

    private function jStorageRespose(...$response) {
        $message = array();
        foreach($response as $msg) {
            $message[] = $msg;
        }
        $message[] = [
            'jStorageVersion' => jSTORAGE_VERSION,
            'jStoragePath' => $this->path,
            'jStorageSize' => filesize($this->path) . '/bytes'
        ];
        return json_encode($message);
    }
}
