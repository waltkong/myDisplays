<?php
namespace App\Library\Tools;

use Picqer\Barcode\BarcodeGeneratorPNG;

/**
 * vendor -  picqer/php-barcode-generator
 * picqer/php-barcode-generator  条形码
 */
class BarcodeTool
{

    /**
     * 获取条码的前台url
     * @param $data  //条码号 唯一标示
     */
    public function getSrc( $data ){
        $generator = new BarcodeGeneratorPNG();
        $src = 'data:image/png;base64,'.base64_encode($generator->getBarcode($data, $generator::TYPE_CODE_128));   // $generator::TYPE_CODE_128
        return $src;
    }


    /**
     * 生成条码 的二进制数据
     * @param $data //条码数据
     */
    public function generate( $data ){
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode( $data , $generator::TYPE_CODE_128);
        return $barcode;
    }

}
