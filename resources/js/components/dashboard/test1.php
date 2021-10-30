<?php
class test
/** @test */
{
    public $num;
    public function __construct($num)
    {
        $this->num = $num;
    }
    public function receved($num2)
    {
        // $num = $this->num;
        $sum = 0;
        for ($i = $this->num; $i <= $num2; $i++) {
            $sum += $i;
        }
        echo ($sum);
    }
}
$class = new test(1);
$class->receved(5);

    //the body of the function}
