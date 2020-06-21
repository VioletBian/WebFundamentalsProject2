<?php
class hot {
    private $count = 0;
    private $array = array();
    private $id;
    private $maxNum = 0;
    public function __construct($i){
        $this->id = $i;
        switch ($i){
            case "Content": {$this->maxNum = 3; break;}
            case "AsciiName": {$this->maxNum = 6; break;}
            case "CountryName": {$this->maxNum = 4; break;}
        }
    }

    public function __get($name){
        return $this->$name;
    }
    function __set($name, $value){
        $this->$name = $value;
    }

    public function pusher($str) {
        array_push($this->array,$str);
        $this->count++;
    }
    public function hotSelector($result){
        while ($row = $result->fetch() && $this->count < $this->maxNum) {
            $this->pusher($row[$this->id]);
        }

    }

}

?>