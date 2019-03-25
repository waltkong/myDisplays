<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/25
 * Time: 13:58
 */

//参考文档  http://www.thinkphp.cn/code/2581.html
class Model
{
    private $db;

    public $table = '';

    public $tableFullName;

    private $db_config;

    public function __construct ()
    {
        require_once "Database.php";
        $this->db = Database::getInstance();
        $this->db_config = $this->db->db_config;
        $this->tableFullName = empty($this->tableFullName)?$this->db_config['DB_PREFIX'].$this->table :$this->tableFullName;
    }
    /**
     * 查找一个
     * $wheres   ["name='test'","age > 20"]
     * @param array $wheres
     * @throws exception
     */
    public function first( array $wheres){
        $qs = $this->db->table($this->tableFullName);
        foreach ($wheres as $where){
            $qs = $qs->where($where);
        }
        return $qs->find();
    }
    /**
     * 查找多个
     * $wheres   ["name='test'","age > 20"]
     * $order
     * @param array $wheres
     * @throws exception
     */
    public function get(array $wheres, $order='id desc',$limit=5000 ){
        $qs = $this->db->table($this->tableFullName);
        foreach ($wheres as $where){
            $qs = $qs->where($where);
        }
        return $qs->order('id desc')->limit(2)->select();
    }
    /**
     * 更新
     * @param $wheres
     * @param $data
     * @throws exception
     */
    public function update( $wheres, $data){
        $qs = $this->db->table($this->tableFullName);
        foreach ($wheres as $where){
            $qs = $qs->where($where);
        }
        $qs->update($data);
    }
    /**
     * 添加
     * @param $data
     * @throws exception
     */
    public function add( array $data){
        $qs = $this->db->table($this->tableFullName);
        $lastId = $qs->add($data);
        return $lastId;
    }

    /**
     * 删除
     * @param $wheres
     * @throws exception
     */
    public function delete( $wheres){
        $qs = $this->db->table($this->tableFullName);
        foreach ($wheres as $where){
            $qs = $qs->where($where);
        }
        $qs->delete();
    }

    public function raw($sql){
        $result = $this->db->query($sql);
        return $result;
    }

}
