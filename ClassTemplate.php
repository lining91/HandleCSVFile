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
    public $keynum = 0;
    public $rowcount = 0;
}
?>