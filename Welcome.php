<html>
<head>
    <meta charset="utf-8">
    <title>文件处理</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        请输入文件路径：<input type="text" name="filedir_1">
        <input type="submit" class = "btn" value="删除" name="deletedir_1"><br>

        请输入文件路径：<input type="text" name="filedir_2">
        <input type="submit" value="删除" name="deletedir_2"><br>

        请输入文件路径：<input type="text" name="filedir_3">
        <input type="submit" value="删除" name="deletedir_3"><br>

        请输入文件路径：<input type="text" name="filedir_4">
        <input type="submit" value="删除" name="deletedir_4"><br>

        请输入文件路径：<input type="text" name="filedir_5">
        <input type="submit" value="删除" name="deletedir_5"><br>

        <input type="submit" value="开始处理" name="handledir">
        <input type="submit" value="清空" name="cleardir">
    </form>
</body>
<?php

function DeleteDir(){
    for ( $idx = 1; $idx <= 5; $idx++ )
    {
        if ($_POST["deletedir_" . $idx])
            $_POST["filedir_" .  $idx] = "";
    }
}

function HandleFile( $filename ){
    require("ConcreteClass1.php");
    $concrete1 = new ConcreteClass1($filename);
    $concrete1->GetFileContent();
    $concrete1->GenerateNewFile();
}

function HandleDir(){
    if (!$_POST["handledir"])
        return;

    for ( $idx = 1; $idx <= 5; $idx++ )
        echo $_POST["filedir_" .  $idx] . "<br>";

    $flag = true;
    $filename = array();
    for ( $idx = 1; $idx <= 5; $idx++ )
    {
        $temp = $_POST["filedir_" .  $idx];
        if ($temp != "")
        {
            if ( !file_exists($temp) )
            {
                $flag = false;
                echo $temp . " is invalid file. " . "<br>";
            }
            else
                $filename[sizeof($filename) + 1] = $temp;
        }
    }

    if ( $flag )
        HandleFile($filename);
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    DeleteDir();
    HandleDir();
}
?>
</html>