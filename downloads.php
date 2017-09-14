<?php
    function downloads(){
        $file_name =$_GET["filename"];
        $file_sub_path =$_SERVER['DOCUMENT_ROOT'].__ROOT__.'Public/static/download/'; //需要下载的文件所在的位置
        if(!file_exists($file_sub_path.$file_name)){
            echo "文件不存在请检查文件名及后缀是否正确";die;
        }
        $file = fopen($file_sub_path.$file_name,"r");
        //返回的文件类型
        Header("Content-type: application/octet-stream");
        //按照字节大小返回
        Header("Accept-Ranges: bytes");
        //返回文件的大小
        Header("Accept-Length: ".filesize($file_dir.$file_name));
        //这里对客户端的弹出对话框，对应的文件名
        Header("Content-Disposition: attachment; filename=".$file_dir.$file_name);
        //修改之前，一次性将数据传输给客户端
        echo fread($file, filesize($file_dir.$file_name));
        //修改之后，一次只传输1024个字节的数据给客户端
        //向客户端回送数据
        $buffer=2048;//
        //判断文件是否读完
        while (!feof($file)) {
            //将文件读入内存
            $file_data=fread($file,$buffer);
            //每次向客户端回送1024个字节的数据
            echo $file_data;
        }
        fclose($file);      
    }
?>