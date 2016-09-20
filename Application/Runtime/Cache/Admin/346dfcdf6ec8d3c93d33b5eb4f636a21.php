<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 商品列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
</head>
<body>
<h1>
	<?php if($_page_btn_name): ?>
    <span class="action-span"><a href="<?php echo $_page_btn_link; ?>"><?php echo $_page_btn_name; ?></a></span>
    <?php endif; ?>
    <span class="action-span1"><a href="#">管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $_page_title; ?> </span>
    <div style="clear:both"></div>
</h1>

<!--  内容  -->


<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="general-tab">通用信息</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/index.php/Admin/Goods/add.html" method="post">
            <table width="90%" id="general-table" align="center">
                <tr>
                    <td class="label">商品品牌：</td>
                    <td>
<!--                        <select name="brand_id">
                            <option value=''>请选择</option>
                            <?php foreach ($brandData as $k => $v): ?>
                            <option value="<?php echo $v['id'];?>"><?php echo $v['brand_name'];?></option>
                            <?php endforeach;?>
                        </select>-->
                        <?php buildSelect('brand','barand_id','id','brand_name'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value=""size="60" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">商品图片：</td>
                    <td><input type="file" name="logo" value=""size="60" />
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="0" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">会员价格：</td>
                    <td>
                        <?php foreach($mlData as $k => $v):?>
                        <?php echo $v['level_name'];?>：<input type="text" name="member_price[<?php echo $v['id'];?>]" size='8'>元</br>
                        <?php endforeach;?>
                    </td>
                </tr>    
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="0" size="20" />
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="1" checked="checked"/> 是
                        <input type="radio" name="is_on_sale" value="0"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">商品描述：</td>
                    <td>
                        <textarea name="goods_desc" id = "goods_desc"></textarea>
                    </td>
                </tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>


</body>
</html>
<!--导入在线编辑器-->
<link href="/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    UM.getEditor('goods_desc', {
        initialFrameWidth : "100%",
        initialFrameHeight : 350
     });
</script>


<div id="footer"> 39期 </div>
</body>
</html>