<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/25
 * Time: 16:02
 */

namespace app\controllers;

use app\models\GoodsModel;

class IndexController extends BaseController
{

    public function __construct ()
    {
        parent::__construct();

    }

    public function index(){
//        $goodsModel = new GoodsModel();
//        $rowobj = $goodsModel->first(['id=7']);
//        $name =  $rowobj->goods_name;
         return $this->view('user/index');
    }



}