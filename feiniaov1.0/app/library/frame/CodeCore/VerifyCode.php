<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/29
 * Time: 11:55
 */

namespace app\library\frame\CodeCore;

class VerifyCode
{
    public $width;
    public $height;
    public $numbers;
    public $codeType;    //1.数字 2.字母 3.混合
    public $color;
    public $fontColor;
    public $imageType;

    private $codeString;//验证字符串母体
    private $resource;  //图片资源

    public function __construct($w=100,$h=50,$n=4,$imageType='png',$codeType=1){
        $this->width = $w;
        $this->height = $h;
        $this->numbers = $n;
        $this->imageType = $imageType;
        $this->codeType = $codeType;
        /*    生成随机的验证字符串    */
//        $this->codeString = $this->createCode($this->codeType);
//        $this->show();
    }

    public function createCode($type){
        switch($type){
            case 1:
                /*生成纯数字，首先使用range(0,9)生成数组
                  *通过$this->verifyNums确定字符串的个数
                  *使用array_rand()从数组中随机获取相应个数
                  *使用join将数字拼接成字符串，存储到$this->codeString中
                 */
                $this->codeString = join('',array_rand(range(0, 9),$this->numbers));
                break;
            case 2:
                /*生成纯字母，
                   *小写字母数组range('a','z')
                   *大写字母数组range('A','Z')
                   *合并两个数组array_merge()
                   *更换键和值  array_flip()
                   *随机获取数组中的特定个数的元素 array_rand()
                   *拼接成字符串 implode()
                */
                $this->codeString = implode(array_rand(array_flip(array_merge(range('a','z'),range('A','Z'))),$this->numbers));
                break;
            case 3:
                //混合类型
                $words = str_shuffle('abcdefghjkmpopqrstuvwxyABCDEFGHIJKLMNPQRSTUVWXY3456789');
                $this->codeString = substr($words,0,$this->numbers);
                break;
        }
        return $this->codeString;
    }

    //开始准备生成图片
    /*方法名：show()
     *功能  ：调用生成图片的所有方法
     */
    public function show(){
        $this->createImg();//创建图片资源
        $this->fillBackground();   //填充背景颜色
        $this->fillPix();  //填充干扰点
        $this->fillArc();  //填充干扰弧线
        $this->writeFont();//写字
        $this->outPutImg();//输出图片
    }

    //创建图片资源:imagecreatetruecolor($width,$height)
    private function createImg(){
        $this->resource = imagecreatetruecolor($this->width,$this->height);
    }

    //填充背景颜色:imagefill($res,$x,$y,$color)
    //随机生成深色--->imagecolorallocate($res,$r,$g,$b)
    private function setDarkColor()
    {
        return imagecolorallocate($this->resource,mt_rand(130,255),mt_rand(130,255),mt_rand(130,255));
    }
    //随机生成浅色
    private function setLightColor()
    {
        return imagecolorallocate($this->resource,mt_rand(0,130),mt_rand(0,130),mt_rand(0,130));
    }
    //开始填充
    private function fillBackground()
    {
        imagefill($this->resource,0,0,$this->setDarkColor());
    }

    //随机生成干扰点-->imagesetpixel
    private function fillPix()
    {
        //计算产生多少个干扰点（单一像素），这里设置每20个像素产生一个
        $num = ceil(($this->width * $this->height) / 20);
        for($i = 0; $i < $num; $i++){
            imagesetpixel($this->resource,mt_rand(0,$this->width),mt_rand(0,$this->height),$this->setDarkColor());
        }
    }

    //随机画10条弧线->imagearc()
    private function fillArc()
    {
        for($i = 0;$i < 10;$i++){
            imagearc($this->resource,
                mt_rand(10,$this->width-10),
                mt_rand(5,$this->height-5),
                mt_rand(0,$this->width),
                mt_rand(0,$this->height),
                mt_rand(0,180),
                mt_rand(181,360),
                $this->setDarkColor());
        }
    }

    /*在画布上写文字
     *根据字符的个数，将画布横向分成相应的块
      $every = ceil($this->width/$this->verifyNums);
     *每一个小块的随机位置画上对应的字符
      imagechar();
     */
    private function writeFont()
    {
        $every = ceil($this->width / $this->numbers);
        for($i = 0;$i < $this->numbers;$i++){
            $x = mt_rand(($every * $i) + 5,$every * ($i + 1) - 5);
            $y = mt_rand(5,$this->height - 10);

            imagechar($this->resource,6,$x,$y,$this->codeString[$i],$this->setLightColor());
        }
    }

    //输出图片资源
    private function outPutImg()
    {
        //header('Content-type:image/图片类型')
        header('Content-type:image/'.$this->imageType);
        //根据图片类型，调用不同的方法输出图片
        //imagepng($img)/imagejpg($img)
        $func = 'image'.$this->imageType;
        $func($this->resource);
    }

    //设置验证码字符只能调用，不能修改，用来验证验证码是否输入正确
    public function __get($name){
        if($name = 'codeString'){
            return $this->codeString;
        }
    }

    //析构方法，自动销毁图片资源
    public function __destruct()
    {
        imagedestroy($this->resource);
    }


}
