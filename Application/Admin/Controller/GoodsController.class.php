<?php
namespace Admin\Controller;
use Think\Controller;
//商品控制器
class GoodsController extends Controller{
	//显示和处理表单
	public function add(){
		//判断是否有POST提交数据
		if (IS_POST){
                    echo '<pre>';
//                    var_dump($_POST);die;
                    echo '</pre>';
			$model = D('goods');
			//添加数据,并过滤XSS攻击
			//I('post.')表示过滤后的数据,参数1表示表单类型,1是添加 2是修改
                        //create方法主要有两个功能 ①添 加数据 ②处理模型中定义的规则
			if($model->create(I('post.'),1)){
//                            echo '<pre>';
//                            var_dump($model);
//                            echo '</pre>';die;
				//如果添加成功,就跳转跳转到"lst"页面
				if($model->add()){
					$this->success("添加成功",U('lst'));
					exit;
				}
			}
			//添加失败,从模型中取出失败的信息
			$error = $model->getError();
			$this->error($error);
		}
                //取出所有的品牌
                $brandModel = D('brand');
                $brandData = $brandModel->select();
                
                //取出所有的会员级别
                $mlModel = D('member_level');
                $mlData = $mlModel->select();
                
                $this->assign(array(
                    'mlData' => $mlData,
                    "brandData" => $brandData,
                    "_page_title"=>"添加商品",
                     "_page_btn_name" => "商品列表",
                     "_page_btn_link" => U("lst")
                 ));
		$this->display();
	}
        public function lst(){
            $model = D('goods');
            $data = $model->search();
            
            $brandModel = D('brand');
            $brandData = $brandModel->select();
            
            $this->assign($data);
            $this->assign(array(
            "brandData"=>$brandData,
           "_page_title"=>"商品列表",
            "_page_btn_name" => "添加商品",
            "_page_btn_link" => U("add")
        ));
            $this->display();
        }
    public function edit(){
        //获取要修改的id
        $id = I('get.id');
        $model = D('goods');
        //判断是否有POST提交数据
        if (IS_POST){
            //添加数据,并过滤XSS攻击
            //I('post.')表示过滤后的数据,参数1表示表单类型,1是添加 2是修改
            //create方法主要有两个功能 ①添 加数据 ②处理模型中定义的规则
            if($model->create(I('post.'),2)){
                //如果添加成功,就跳转跳转到"lst"页面
                if(($model->save()) !== FALSE){
                    $this->success("添加成功",U('lst'));
                    exit;
                }
            }
            //添加失败,从模型中取出失败的信息
            $error = $model->getError();
            $this->error($error);
        }
        //取出品牌中的所有数据
        $brandModel = D('brand');
        $brandData = $brandModel->select();
        //根据id取出要修改的商品信息
        $data = $model->find($id);
        $this->assign('data',$data);//assign把数据传到页面
        $this->assign(array(
            "brandData" => $brandData,
           "_page_title"=>"修改商品",
            "_page_btn_name" => "商品列表",
            "_page_btn_link" => U("lst")
        ));
        $this->display();
    }
    public function delete(){
        $id = I('get.id');
        $model = D("goods");
        if($model->delete($id) !== FALSE){
            $this->success('删除成功',U('lst'));
        }  else {
            $this->error('删除失败,原因是:'.$model->getError());
        }
    }
}