<?php
include('./MPDF57/mpdf.php');
$mpdf=new mPDF('UTF-8','A4','','',15,15,44,15);

$mpdf->useAdobeCJK = true;
$mpdf->SetAutoFont(AUTOFONT_ALL);
$mpdf->SetDisplayMode('fullpage');
// $mpdf->watermark_font = 'GB';
// $mpdf->SetWatermarkText('中国水印',0.1);
$url = 'http://localhost/wtyphp/wty.html';
$strContent = file_get_contents($url);  //读取html 文件进行解析

$mpdf->showWatermarkText = true;
$mpdf->SetAutoFont();
//$mpdf->SetHTMLHeader( '头部' );
//$mpdf->SetHTMLFooter( '底部' );
header("Content-type: text/html; charset=utf-8");
$mpdf->WriteHTML($strContent);
// // $mpdf->Output('ss.pdf');
// $mpdf->Output('tmp.pdf',true);
// $mpdf->Output('tmp.pdf','d');  //保存成文件
$mpdf->Output();   //直接输出pdf格式进行预览
exit;
?>