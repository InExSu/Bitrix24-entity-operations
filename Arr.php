<?php
class Arr {
    private $numbers = [];

    public function add($number){
        $this->numbers[] = $number;
        return $this;
    }
    public function push($number){
        $this->numbers = array_merge($this->numbers, $number);
        return $this;
    }
    public function summa(){
        return array_sum($this->numbers);
    }
}

$arr = new Arr;

echo $arr->add(1)->push([2,3])->summa();