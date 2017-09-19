<?php
 class Vcode {
  private $width; //宽
  private $height; //高
  private $num;  //数量
  private $code; //验证码
  private $img;  //图像的资源
  
  //构造方法， 三个参数
  function __construct($width=80, $height=20, $num=4) {
   $this->width = $width;
   $this->height = $height;
   $this->num = $num;
   $this->code = $this->createcode(); //调用自己的方法
  }
  
  //获取字符的验证码， 用于保存在服务器中
  function getcode() {
   return $this->code;
  }
  
  //输出图像
  function outimg() {
   //创建背景 (颜色， 大小， 边框)
   $this->createback();
  
   //画字 (大小， 字体颜色)
   $this->outstring();
  
   //干扰元素(点， 线条)
  
   $this->setdisturbcolor();
   //输出图像
   $this->printimg();
  }
  
  //创建背景
  private function createback() {
   //创建资源
   $this->img = imagecreatetruecolor($this->width, $this->height);
   //设置随机的背景颜色
   $bgcolor = imagecolorallocate($this->img, rand(225, 255), rand(225, 255), rand(225, 255)); 
   //设置背景填充
   imagefill($this->img, 0, 0, $bgcolor);
   //画边框
   $bordercolor = imagecolorallocate($this->img, 0, 0, 0);
  
    imagerectangle($this->img, 0, 0, $this->width-1, $this->height-1, $bordercolor);
  }
  
  //画字
  private function outstring() {
   for($i=0; $i<$this->num; $i++) {
  
    $color= imagecolorallocate($this->img, rand(0, 128), rand(0, 128), rand(0, 128)); 
  
    $fontsize=rand(3,5); //字体大小
  
    $x = 3+($this->width/$this->num)*$i; //水平位置
    $y = rand(0, imagefontheight($fontsize)-3);
  
    //画出每个字符
    imagechar($this->img, $fontsize, $x, $y, $this->code{$i}, $color);
   }
  }
  
  //设置干扰元素
  private function setdisturbcolor() {
   //加上点数
   for($i=0; $i<100; $i++) {
    $color= imagecolorallocate($this->img, rand(0, 255), rand(0, 255), rand(0, 255)); 
    imagesetpixel($this->img, rand(1, $this->width-2), rand(1, $this->height-2), $color);
   }
  
   //加线条
   for($i=0; $i<10; $i++) {
    $color= imagecolorallocate($this->img, rand(0, 255), rand(0, 128), rand(0, 255)); 
    imagearc($this->img,rand(-10, $this->width+10), rand(-10, $this->height+10), rand(30, 300), rand(30, 300), 55,44, $color);
   }
  }
  
  //输出图像
  private function printimg() {
   if (imagetypes() & IMG_GIF) {
     header("Content-type: image/gif");
     imagegif($this->img);
   } elseif (function_exists("imagejpeg")) {
     header("Content-type: image/jpeg");
     imagegif($this->img);
   } elseif (imagetypes() & IMG_PNG) {
     header("Content-type: image/png");
     imagegif($this->img);
   } else {
     die("No image support in this PHP server");
   } 
  
  }
  
  //生成验证码字符串
  private function createcode() {
   $codes = "3456789abcdefghijkmnpqrstuvwxyABCDEFGHIJKLMNPQRSTUVWXY";
  
   $code = "";
  
   for($i=0; $i < $this->num; $i++) {
    $code .=$codes{rand(0, strlen($codes)-1)}; 
   }
  
   return $code;
  }
  
  //用于自动销毁图像资源
  function __destruct() {
   imagedestroy($this->img);
  }
  
 }

?>
<?php
 //开启session
 session_start();
 include "vcode.class.php";
 //构造方法
 $vcode = new Vcode(80, 30, 4);
 //将验证码放到服务器自己的空间保存一份
 $_SESSION['code'] = $vcode->getcode();
 //将验证码图片输出
 $vcode->outimg();
?>

　
<?php
// 表单代码如下所示：
 session_start();
if(isset($_POST['dosubmit'])) {
 if(strtoupper($_SESSION['code']) == strtoupper($_POST['code']) ) {
  echo "输入成功!<br>";
 }else{
  echo "输入不对!<br>";
 }
}
?>
  
<body>
 <form action="reg.php" method="post">
  username: <input type="text" name="username"> <br>
  password: <input type="password" name="password"> <br>
  code: <input type="text" onkeyup="if(this.value!=this.value.toUpperCase()) this.value=this.value.toUpperCase()" size="6" name="code"> 
    <img src="code.php" onclick="this.src='code.php?'+Math.random()" /> <br>
  <input type="submit" name="dosubmit" value="登 录"> <br>
 </form>
</body>