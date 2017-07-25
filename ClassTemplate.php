<?php
abstract class CAHandleFile
{
    abstract public function GetFileContent();
    abstract public function GenerateNewFile();

    public $filename = array();
    public $filecontent = array();
    public $title = "";
}
?>