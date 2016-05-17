<?php
namespace Admin\Controller;
use Think\Controller;
class CateController extends Controller {
    public function index(){
    	//创建对象 
    	$cate = M('category');
    	 $num = !empty($_GET['num']) ? $_GET['num'] : 5;

        //获取关键字
        if(!empty($_GET['keyword'])){
            //有关键字
            $where = "name like '%".$_GET['keyword']."%'";
        }else{
            $where = '';
        }


        // 查询满足要求的总记录数
        $count = $cate->where($where)->count();
        // 实例化分页类 传入总记录数和每页显示的记录数
        $Page = new \Think\Page($count,$num);
        //获取limit参数
        $limit = $Page->firstRow.','.$Page->listRows;

         //执行查询
        $res = $cate->where($where)->order('concat(path,id) asc')->limit($limit)->select();

        // 分页显示输出
        $pages = $Page->show();
        //遍历
        foreach ($res as $k => $v) {
            //获取要添加|---个数
            $c = count(explode(',',$v['path']))-2;
            $res[$k]['name'] = str_repeat('|--',$c).$v['name'];
        }
        // var_dump($cates);

        // die;
      	var_dump($res);
        //分配变量
        $this->assign('res',$res);
        $this->assign('pages',$pages);
    	//解析模板
        //解析模板
    	$this->display();
    }
    public function add(){
    	//创建对象 连接 分类表
    	$cate = M('category');
    	//查询 分类 
    	$res = $cate->order('concat(path,id) asc')->select();
    	//如何显示
    	foreach ($res as $k => $v) {
            //获取要添加|---个数
            $c = count(explode(',',$v['path']))-2;
            $res[$k]['name'] = str_repeat('|--',$c).$v['name'];

        }
    	//分配变量
    	$this -> assign('res',$res);
    	//解析模板
    	$this->display();
    }
    public function insert(){

    }
}