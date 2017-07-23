<?php

abstract class CAHandleFile
{
    abstract public function GetFileContent();
    abstract public function GenerateNewFile();
    abstract public function Handle();

    public $filename = array();
    public $filecontent = array();
    public $title = "";
    public $newfilename = "";
    public $continueflag = true;
    public $keynum = 0;                 //  关键字列数
    public $rowcount = 0;               //  文件具有的列数
}
?>