<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model {
    //避免收集非法数据,在提交之前设置TP自带的一个属性,使得在收集表单时只能提交规定的属性
    //把后来添加的品牌ID添加到允许接收的范围
    protected $insertFields = array('goods_name','market_price','shop_price','goods_desc','is_on_sale','is_delete','addtime','brand_id');
    //定义修改允许提交的字段
    protected $updateFields = array('id','goods_name','market_price','shop_price','goods_desc','is_on_sale','is_delete','addtime','brand_id');
    //定义验证规则
    protected $_validate = array(
        array('goods_name','require','商品名称不能为空',1),
        array('market_price','currency','市场价格必须为货币类型',1),
        array('shop_price','currency','本店价格必须为货币类型',1),
    );
    //使用tp自带的钩子函数,为数据提交之前插入时间信息
    protected function _before_insert(&$data, $options) {
        /********处理LOGO图片*********/
        if($_FILES['logo']['error'] == 0){
            /*
            $upload = new \Think\Upload();// 实例化上传类    
            $upload->maxSize   =     1024 * 1024 * 10;// 设置附件上传大小   
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型 
            $upload->rootPath  =     './Public/Uploads/';//上传跟目录
            $upload->savePath  =      'Goods/'; // 设置附件上传子目录    
            // 上传文件     
            $info   =   $upload->upload(); 
            //print_r($info);die;
            if(!$info) {// 上传错误提示错误信息   
                //把错误信息保存到模型的error属性中,在控制器new出来的对象调用getError()获取错误信息
                $this->error = $upload->getError();
                return FALSE;
            }else{// 上传成功 生成缩略图
                //var_dump($info);die;
                //拼接原图片的路径和名称
                $logo = $info['logo']['savepath'] . $info['logo']['savename'];
                // var_dump($logo);die;
                //拼接缩略图路径和名称
                $sm_logo = $info['logo']['savepath'] . 'sm' . $info['logo']['savename'];
                $mid_logo = $info['logo']['savepath'] . 'mid' . $info['logo']['savename'];
                $big_logo = $info['logo']['savepath'] . 'big' . $info['logo']['savename'];
                $mbig_logo = $info['logo']['savepath'] . 'mbig' . $info['logo']['savename'];
                $image = new \Think\Image();
                //打开要生成缩略图的原图
                $image->open('./Public/Uploads/' . $logo);
                // 按照原图的比例生成一个最大为150*150的缩略图并保存
                $image->thumb(700, 700)->save('./Public/Uploads/'.$mbig_logo);
                $image->thumb(350, 350)->save('./Public/Uploads/'.$big_logo);
                $image->thumb(150, 150)->save('./Public/Uploads/'.$mid_logo);
                $image->thumb(50, 50)->save('./Public/Uploads/'.$sm_logo);
                //把路径存放到表中
                $data['logo'] = $logo;
                $data['sm_logo'] = $sm_logo;
                $data['big_logo'] = $big_logo;
                $data['mbig_logo'] = $mbig_logo;
                $data['mid_logo'] = $mid_logo;
                }
                */
            //上面的代码封装成了函数
            $ret = uploadOne("logo", 'goods',array(
                array(700, 700),
                array(350, 350),
                array(130, 130),
                array(50, 50),
                ));
            $data['logo'] = $ret['images'][0];
            $data['mbig_logo'] = $ret['images'][1];
            $data['big_logo'] = $ret['images'][2];
            $data['mid_logo'] = $ret['images'][3];
            $data['sm_logo'] = $ret['images'][4];
            }
        $data['addtime'] = date('Y-m-d H-i-s',  time());
        //对商品描述用自定义的函数 removeXSS进行选择性过滤
        $data['goods_desc'] = removeXSS($data['goods_desc']);
        }
      //实现翻页 搜索 排序
    public function search($page = 3){
        /*********搜索***********/
        $where = array();//存放拼接的查询条件
        //获取get参数
        $gn = I('get.gn');//名称
        $fp = I('get.fp');//第一个价格
        $lp = I('get.lp');//第二个价格
        $ios = I('get.ios');//是否上架
        $fa = I('get.fa');//时间段的第一个参数
        $la = I('get.la');//时间段的第二个参数
        if($gn)
            $where["goods_name"] = array("like","%$gn%");//相当于条件语句 where goods_name like "%$gn%"
        if($fp && $lp)
            $where["shop_price"] = array("between",array($fp,$lp));
        elseif($fp)
            $where["shop_price"] = array("egt",$fp);//相当于大雨等于
        elseif($lp)
            $where["shop_price"] = array("elt",$lp);//小于等于
        if($ios)
            $where["is_on_sale"] = array("eq",$ios);
        if($fa && $la)
            $where["addtime"] = array("between",array($fa,$la));
        elseif($fa)
            $where["addtime"] = array("egt",$fa);//相当于大雨等于
        elseif($la)
            $where["addtime"] = array("elt",$la);//小于等于
        //获取品牌信息 进行搜索
        $brand_id = I('get.brand_id');
//        echo $brand_id;die;
        if($brand_id)
            $where["brand_id"] = array("eq",$brand_id);
//        var_dump($where);die;
        /*********分页***********/
        //取出符合条件的总的记录数
        $count = $this->where($where)->count();
        $pageObj = new \Think\Page($count,$page);
        //设置翻页样式
        $pageObj->setConfig("prev", "上一页");
        $pageObj->setConfig("next", "下一页");
        $pageString = $pageObj->show();
        /************排序***********/
        //初始化排序字段和排序方式
        $oderby = "a.id";//默认排序字段
        $oderway = "desc";//默认排序方式
        $odby = I('get.odby');
        if($odby){
            if($odby == "id_asc"){
                $oderway = "asc";
            }elseif ($odby == "price_desc") {
                $oderby = "shop_price";
            }elseif ($odby == "price_asc") {
                $oderby = "shop_price";
                $oderway = "asc";
            }
        }
            
        //取出符合条件的每页展示的数据
        $data = $this
                ->order("$oderby $oderway")
                ->field('a.*,b.brand_name')
                ->alias('a')
                ->join('left join p39_brand as b on a.brand_id=b.id')
                ->where($where)
                ->limit($pageObj->firstRow.','.$pageObj->listRows)
                ->select();
//        var_dump($data);die;
        return array(
            'odby' => $odby,
            'data' => $data,
            'page' => $pageString
        );
    }  
    protected function _before_update(&$data, $options) {
        //var_dump($options);die;
        //获取要修改的商品id
        $id = $options["where"]["id"];
        /********处理LOGO图片*********/
        if($_FILES['logo']['error'] == 0){
            $upload = new \Think\Upload();// 实例化上传类    
            $upload->maxSize   =     1024 * 1024 * 10 ;// 设置附件上传大小   
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型 
            $upload->rootPath  =     './Public/Uploads/';//上传跟目录
            $upload->savePath  =      'Goods/'; // 设置附件上传子目录    
            // 上传文件     
            $info   =   $upload->upload(); 
            //print_r($info);die;
            if(!$info) {// 上传错误提示错误信息   
                //把错误信息保存到模型的error属性中,在控制器new出来的对象调用getError()获取错误信息
                $this->error = $upload->getError();
                return FALSE;
            }else{// 上传成功 生成缩略图
                //var_dump($info);die;
                //拼接原图片的路径和名称
                $logo = $info['logo']['savepath'] . $info['logo']['savename'];
                // var_dump($logo);die;
                //拼接缩略图路径和名称
                $sm_logo = $info['logo']['savepath'] . 'sm' . $info['logo']['savename'];
                $mid_logo = $info['logo']['savepath'] . 'mid' . $info['logo']['savename'];
                $big_logo = $info['logo']['savepath'] . 'big' . $info['logo']['savename'];
                $mbig_logo = $info['logo']['savepath'] . 'mbig' . $info['logo']['savename'];
                $image = new \Think\Image();
                //打开要生成缩略图的原图
                $image->open('./Public/Uploads/' . $logo);
                // 按照原图的比例生成一个最大为150*150的缩略图并保存
                $image->thumb(700, 700)->save('./Public/Uploads/'.$mbig_logo);
                $image->thumb(350, 350)->save('./Public/Uploads/'.$big_logo);
                $image->thumb(150, 150)->save('./Public/Uploads/'.$mid_logo);
                $image->thumb(50, 50)->save('./Public/Uploads/'.$sm_logo);
                //把路径存放到表中
                $data['logo'] = $logo;
                $data['sm_logo'] = $sm_logo;
                $data['big_logo'] = $big_logo;
                $data['mbig_logo'] = $mbig_logo;
                $data['mid_logo'] = $mid_logo;
                }
                
            }
        $data['addtime'] = date('Y-m-d H-i-s',  time());
        /************删除原来的图片**************/
        //查询出原来图片的路径
        $oldLogo = $this->field('sm_logo,big_logo,mbig_logo,mid_logo,logo')->find($id);
        //依次删除
        unlink('./Public/Uploads/'.$oldLogo['logo']);
        unlink('./Public/Uploads/'.$oldLogo['sm_logo']);
        unlink('./Public/Uploads/'.$oldLogo['big_logo']);
        unlink('./Public/Uploads/'.$oldLogo['mbig_logo']);
        unlink('./Public/Uploads/'.$oldLogo['mid_logo']);
        //对商品描述用自定义的函数 removeXSS进行选择性过滤
        $data['goods_desc'] = removeXSS($data['goods_desc']);
    }
    //删除商品之前先删除对应的图片
    public function _before_delete($options) {
        $id = $options['where']['id'];
        //查询出原来图片的路径
        $oldLogo = $this->field('sm_logo,big_logo,mbig_logo,mid_logo,logo')->find($id);
        //依次删除
        /*
        unlink('./Public/Uploads/'.$oldLogo['logo']);
        unlink('./Public/Uploads/'.$oldLogo['sm_logo']);
        unlink('./Public/Uploads/'.$oldLogo['big_logo']);
        unlink('./Public/Uploads/'.$oldLogo['mbig_logo']);
        unlink('./Public/Uploads/'.$oldLogo['mid_logo']);
         */
        deleteImage($oldLogo);
    }
    //插入之后要做的事情
    public function _after_insert($data, $options) {
        //把对应的会员价格插入到对应的表中
        //获取POST提交过来的member_price价格
        $mlPrice = I('post.member_price');
        $mlModel = D('member_price');
        //遍历出获取到的价格
        foreach ($mlPrice as $k => $v) {
            $_v = (float)$v;//强制转换下
            if($_v > 0){
                $mlModel->add(array(
                    'price' => $v,
                    'level_id' => $k,
                    'goods_id' => $data['id']//这里的$data就是Goods表中的数据
                ));
            }
        }
        
    }
}

