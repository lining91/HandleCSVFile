<?php
require("ClassTemplate.php");

//  该文件用于处理condition1,condition2,condition3,value1这种格式的情况,
//  对具有相同condition1,condition2,condition3行的value1进行相加

class ConcreteClass1 extends CAHandleFile{

    function __construct($name){
        $this->filename = $name;
    }

    public function GetFileContent(){
        echo "begin GetFileContent function <br>";
        foreach ($this->filename as $key => $tempfile) {
            $fp = fopen($tempfile, "r+");
            echo "filename is : " . $tempfile . "<br>";
            $this->title = fgets($fp);
            while( $content = fgets($fp) )
            {
                $content_temp = explode(",",$content);  //  将字符串以','分割成数组
                $key_0 = $content_temp[0];
                $key_1 = $content_temp[1];
                $key_2 = $content_temp[2];
                $key_3 = $content_temp[3];

                if ( !$this->filecontent[$key_0])
                {
                    $this->filecontent[$key_0] = array();
                    $this->filecontent[$key_0][$key_1] = array();
                    $this->filecontent[$key_0][$key_1][$key_2] = $key_3;
                }
                else
                {
                    if ( !$this->filecontent[$key_0][$key_1] )
                    {
                        $this->filecontent[$key_0][$key_1] = array();
                        $this->filecontent[$key_0][$key_1][$key_2] = $key_3;
                    }
                    else
                    {
                        if ( $this->filecontent[$key_0][$key_1][$key_2] )
                            $this->filecontent[$key_0][$key_1][$key_2] += $key_3;
                        else
                            $this->filecontent[$key_0][$key_1][$key_2] = $key_3;
                    }
                }
            }
            fclose($fp);
        }
        echo "finish GetFileContent function <br>";
        echo "------------- parting line -------------------- <br>";
        echo "------------- parting line -------------------- <br>";
    }
    public function GenerateNewFile(){
        echo "begin GenerateNewFile <br>";
        $newfp = fopen("new.csv", "w");
        $len = fwrite($newfp, $this->title);
        foreach ($this->filecontent as $key0 => $value0) {
            foreach ($value0 as $key1 => $value1) {
                foreach ($value1 as $key2 => $value2) {
                    $temp = array( $key0, $key1, $key2, $value2 );
                    $newstr = implode(",", $temp);        //  将数组元素用','组合成字符串
                    $newstr = $newstr . "\n";
                    fwrite($newfp, $newstr);
                }
            }
        }
        fclose($newfp);
        echo "finish GenerateNewFile <br>";
    }
}
?>