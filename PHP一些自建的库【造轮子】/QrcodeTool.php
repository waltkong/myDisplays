<?php
namespace App\Library\Tools;
####  文档地址  https://www.simplesoftware.io/docs/simple-qrcode/zh
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


/**
 *   vendor     "qcloud/cos-sdk-v5": ">=1.3",
 *      生成二维码的二进制数据
 */

class QrcodeTool
{


    /**
     *获取二维码的图片src
     * $data
     */
    public function getSrc($data,$size=300,$logoUrl=''){
        $qrCode = self::generate($data,$size,$logoUrl);
        $src =  "data:image/png;base64,".base64_encode($qrCode);
        return $src;
    }

    /**
     *生成二维码的二进制数据
     */
    public function generate($data,$size=300,$logoUrl=''){
        if(is_array($data)){
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $qrCode = QrCode::format('png')->   //Will return a PNG image
        size($size)->             ////设置像素尺寸
        errorCorrection('H')->   //容错级别提高
        encoding('UTF-8');     //encode
        if(!empty($logoUrl)){
            $qrCode = $qrCode->merge($logoUrl, .1, true);  //生成一个中间有LOGO图片的二维码,且LOGO图片占整个二维码图片的10%. 绝对路径
        }
        return $qrCode->generate($data);   //二进制数据
    }


    /**
     *文件流通用返回
     */
    public function fileStreamCommonReturn($data,$filename,$size=300){
        $qrcodeTool = new self();
        return response()->stream(function() use($data,$qrcodeTool,$size){
            echo $qrcodeTool->generate($data,$size);
        },200,["Content-type"=>"image/png","Content-Disposition"=>"attachment; filename={$filename}"]);
    }


    /**
     * 生成并保存二维码图片到本地
     * @param $data
     * @param int $size
     * @param string $logoUrl
     * @param string $imgFullName
     * @return string 图片全路径
     */
    public function storageQrcode( $data, $size=300, $logoUrl='', $imgFullName=''){
        $qrCode = self::generate($data,$size,$logoUrl);
        if(empty($imgFullName)){
            $imgFullName=date('Ymd').'/'.rand(10000,99999).'.png';
        }
        Storage::disk('public')->put($imgFullName,$qrCode);
        return $imgFullName;
    }

}