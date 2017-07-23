<?php
require("ClassTemplate.php");

//  该文件用于处理condition1,condition2,condition3,value1这种格式的情况,
//  对具有相同condition1,condition2,condition3行的value1进行相加

class ConcreteClass1 extends CAHandleFile{
    public $RowNum = 0;

    function __construct($name, $newfilename, $keynum){
        $this->filename = $name;
        $this->newfilename = $newfilename;
        $this->keynum = $keynum;
    }

    public function IsValidRow($rowcount){
        echo "IsValidRow : rowcount = " . $rowcount . "<br>";
        if ($rowcount == 0)
        {
            $this->continueflag = false;
            echo $tempfile . "列数为0！" . "<br>";
            return false;
        }

        if ( $this->rowcount == 0 )
            $this->rowcount = $rowcount;

        if ( $this->rowcount != $rowcount )
        {
            echo "文件的列数不一样！" . " $this->rowcount, $rowcount。<br>";
            $this->continueflag = false;
            return false;
        }

        if ( $this->rowcount <= $this->keynum )
        {
            $this->continueflag = false;
            echo "文件列数：" . $this->rowcount . ", 关键字列数：" . $this->keynum . "<br>";
            return false;
        }

        echo $this->rowcount . "<br>";
        return true;
    }

    public function HandleInput_1( $content ){
        $key_0 = intval($content[0]);
        if ( !$this->filecontent[$key_0] )
            $this->filecontent[$key_0] = array();

        $filecontent_temp = &$this->filecontent[$key_0];
        $valuenum = $this->rowcount - $this->keynum;
        for ($idx = 0; $idx < $valuenum; $idx++ )
        {
            if ( $filecontent_temp[$idx] )
                $filecontent_temp[$idx] += $content[$idx + $this->keynum];
            else
                $filecontent_temp[$idx] = $content[$idx + $this->keynum];
        }
    }

    public function HandleOutput_1( &$newfp ){
        foreach ($this->filecontent as $key0 => $value0) {
                $valuenum = $this->rowcount - $this->keynum;
                $temp = array( $key0 );
                for ( $idx = 0; $idx < $valuenum; $idx++)
                {
                    $temp[$idx + $this->keynum] = $value0[$idx];
                }
                $newstr = implode(",", $temp);        //  将数组元素用','组合成字符串
                $newstr = $newstr . "\n";
                fwrite($newfp, $newstr);
        }
    }

    public function HandleInput_2( $content ){
        $key_0 = intval($content[0]);
        $key_1 = intval($content[1]);
        if ( !$this->filecontent[$key_0] )
            $this->filecontent[$key_0] = array();

        if ( !$this->filecontent[$key_0][$key_1] )
            $this->filecontent[$key_0][$key_1] = array();

        $filecontent_temp = &$this->filecontent[$key_0][$key_1];
        $valuenum = $this->rowcount - $this->keynum;
        for ($idx = 0; $idx < $valuenum; $idx++ )
        {
            if ( $filecontent_temp[$idx] )
                $filecontent_temp[$idx] += $content[$idx + $this->keynum];
            else
                $filecontent_temp[$idx] = $content[$idx + $this->keynum];
        }
    }

    public function HandleOutput_2( &$newfp ){
        foreach ($this->filecontent as $key0 => $value0) {
            foreach ($value0 as $key1 => $value1) {
                $valuenum = $this->rowcount - $this->keynum;
                $temp = array( $key0, $key1 );
                for ( $idx = 0; $idx < $valuenum; $idx++)
                {
                    $temp[$idx + $this->keynum] = $value1[$idx];
                }
                $newstr = implode(",", $temp);        //  将数组元素用','组合成字符串
                $newstr = $newstr . "\n";
                fwrite($newfp, $newstr);
            }
        }
    }

    public function HandleInput_3( $content ){
        $key_0 = intval($content[0]);
        $key_1 = intval($content[1]);
        $key_2 = intval($content[2]);

        if ( !$this->filecontent[$key_0] )
            $this->filecontent[$key_0] = array();

        if ( !$this->filecontent[$key_0][$key_1] )
            $this->filecontent[$key_0][$key_1] = array();

        if ( !$this->filecontent[$key_0][$key_1][$key_2] )
            $this->filecontent[$key_0][$key_1][$key_2] = array();

        $filecontent_temp = &$this->filecontent[$key_0][$key_1][$key_2];
        $valuenum = $this->rowcount - $this->keynum;
        for ($idx = 0; $idx < $valuenum; $idx++ )
        {
            if ( $filecontent_temp[$idx] )
                $filecontent_temp[$idx] += $content[$idx + $this->keynum];
            else
                $filecontent_temp[$idx] = $content[$idx + $this->keynum];
        }
    }

    public function HandleOutput_3( &$newfp ){
        foreach ($this->filecontent as $key0 => $value0) {
            foreach ($value0 as $key1 => $value1) {
                foreach ($value1 as $key2 => $value2) {
                    $valuenum = $this->rowcount - $this->keynum;
                    $temp = array( $key0, $key1, $key2 );
                    for ( $idx = 0; $idx < $valuenum; $idx++)
                    {
                        $temp[$idx + $this->keynum] = $value2[$idx];
                    }
                    $newstr = implode(",", $temp);        //  将数组元素用','组合成字符串
                    $newstr = $newstr . "\n";
                    fwrite($newfp, $newstr);
                }
            }
        }
    }

    public function GetFileContent(){
        echo "begin GetFileContent function <br>";
        foreach ($this->filename as $key => $tempfile) {
            echo "文件路径：<br> " . $tempfile . "<br>";
            $fp = fopen(iconv( "UTF-8", "GBK", $tempfile ), "r+");
            $this->title = fgets($fp);
            echo "title :  $this->title <br>";
            if ( !$this->IsValidRow(sizeof(explode(",", $this->title))) )
                return;
            $valuenum = $this->rowcount - $this->keynum;
            while( $content = fgets($fp) )
            {
                $content_temp = explode(",",$content);  //  将字符串以','分割成数组
                $fun = "HandleInput_" . $this->keynum;
                $this->$fun( $content_temp );
            }
            fclose($fp);
        }
        echo "finish GetFileContent function <br>";
    }
    public function GenerateNewFile(){
        echo "begin GenerateNewFile <br>";
        $newfilepath = dirname(__FILE__) . "\\" . $this->newfilename;
        echo "生成文件路径：<br>" . $newfilepath . "<br>";
        $newfp = fopen(iconv( "UTF-8", "GBK", $this->newfilename ), "w");
        $len = fwrite($newfp, $this->title);
        $fun = "HandleOutput_" . $this->keynum;
        $this->$fun( $newfp );

        fclose($newfp);
        echo "finish GenerateNewFile <br>";
    }

    public function Handle()
    {
        echo "------------- 华丽的分割线 -------------------- <br>";
        echo "------------- 华丽的分割线 -------------------- <br>";
        echo "HandleHandleHandleHandleHandleHandle<br>";
        $this->GetFileContent();
        if (!$this->continueflag)
            return;

        $this->GenerateNewFile();
    }
}
?>