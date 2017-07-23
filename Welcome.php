<html>
<head>
    <meta charset="utf-8">
    <title>文件处理</title>
</head>
<body style="margin-top: 100px;text-align:center" >
    <div>
        <h2>请输入文件路径<h2>
    </div>

    <div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h3><h3>
        路径1：<input type="text" name="filedir_1">
        <input type="submit" class = "btn" value="删除" name="deletedir_1"><br>

        路径2：<input type="text" name="filedir_2">
        <input type="submit" value="删除" name="deletedir_2"><br>

        路径3：<input type="text" name="filedir_3">
        <input type="submit" value="删除" name="deletedir_3"><br>

        路径4：<input type="text" name="filedir_4">
        <input type="submit" value="删除" name="deletedir_4"><br>

        路径5：<input type="text" name="filedir_5">
        <input type="submit" value="删除" name="deletedir_5"><br>
        <br>

        <p style="margin-right: 140px">关键字列数：
        <select name="keynum">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        </p>

        新文件名字：<input type="text" name="newfilename">
        <br><br>

        <p style="margin-left: 0px"><input type="submit" value="开始处理" name="handledir">
        <input type="submit" value="清空" name="cleardir">
        </p>
    </form>
    </div>

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
    $concrete1 = new ConcreteClass1( $filename, $_POST["newfilename"], $_POST["keynum"] );
    $concrete1->Handle();
}

function HandleDir(){
    if (!$_POST["newfilename"])
    {
        echo "error : 请输入要生成的新文件名！<br>";
        return;
    }

    if (!$_POST["handledir"])
        return;

    $flag = true;
    $filename = array();
    for ( $idx = 1; $idx <= 5; $idx++ )
    {
        $temp = $_POST["filedir_" .  $idx];
        if ($temp != "")
        {
            $curDir = dirname(__FILE__);
            $temp = $curDir . "\\" . $temp;
            if ( !file_exists(iconv( "UTF-8", "GBK", $temp )) )
            {
                $flag = false;
                echo $temp . "error :  无效文件路径. " . "<br>";
            }
            else
                $filename[sizeof($filename) + 1] = $temp;
        }
    }

    echo "<br>";
    if ( !$flag )
        return;

    echo "待处理文件：<br>";
    foreach ( $filename as $key => $value )
        echo $value . "<br>";

    echo "新文件名字：<br>" . $_POST["newfilename"] . "<br>";
    echo "<br><br>";
    HandleFile( $filename );
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    DeleteDir();
    HandleDir();
}
?>
</html>