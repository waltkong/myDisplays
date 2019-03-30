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
    //http://local.feiniao.com/index.php?url=index/index


    public function index(){
        $a = 1;
        $b=2;
        $code = app('code')->getCode();

        return app('response')->view('welcome');
    }

    public function test(){
        $req = app('request')->all();
        $goodsModel = new GoodsModel();
        $rowobj = $goodsModel->first(['id=7']);
        $name =  $rowobj->goods_name;

        $res =  app('Cache')->set('aa','haha',3600*24);
        $get = app('Cache')->get('aa');
        $file = app('file')->upload('a');
        $down = app('file')->download('aa');
        $export =  app('excel')->export('aa.txt');
        $encrypt = app('encrypt')->encrypt('aa');
        $check = app('form')->checkEmail('aa');
        $jwt = app('jwt')->issue(['aa'=>1]);
        $res = app('log')->info('aa');

    }

}