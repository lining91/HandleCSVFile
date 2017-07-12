<?php

    $files = array("IOS.csv", "1.csv", "2.csv");
    $title = "";
    $info = array();

    function GetFromFile(){
        global $files, $title, $info;
        foreach ($files as $key => $filename) {
            echo $filename . "<br>" . "gggggggggg";
            $fp = fopen($filename, "r+");
            if ($title == "")
            {
                $title = fgets($fp);
            }
            while( $content = fgets($fp) )
            {
                $content_temp = explode(",",$content);  //  将字符串以','分割成数组
                $key_0 = $content_temp[0];
                $key_1 = $content_temp[1];
                $key_2 = $content_temp[2];
                $key_3 = $content_temp[3];

                if ( !$info[$key_0])
                {
                    $info[$key_0] = array();
                    $info[$key_0][$key_1] = array();
                    $info[$key_0][$key_1][$key_2] = $key_3;
                }
                else
                {
                    if ( !$info[$key_0][$key_1] )
                    {
                        $info[$key_0][$key_1] = array();
                        $info[$key_0][$key_1][$key_2] = $key_3;
                    }
                    else
                    {
                        if ( $info[$key_0][$key_1][$key_2] )
                            $info[$key_0][$key_1][$key_2] += $key_3;
                        else
                            $info[$key_0][$key_1][$key_2] = $key_3;
                    }
                }
            }
            fclose($fp);
        }
    }

    function CreateFile(){
        global $info;
        print_r($info);
        $newfp = fopen("new.csv", "w");
        $len = fwrite($newfp, $title);
        foreach ($info as $key0 => $value0) {
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
    }

    GetFromFile();
    CreateFile();
?>