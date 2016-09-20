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

<div class="form-div">
    <form action="/index.php/Admin/Goods/lst" name="searchForm">
        <img src="/Public/Admin/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
        <p>
            商品品牌:
            <!--<?php buildSelect('brand','barand_id','id','brand_name'); ?>-->
            <select name="brand_id">
                <option value=''>请选择</option>
                <?php foreach ($brandData as $k => $v): ?>
                <option value="<?php echo $v['id'];?>"><?php echo $v['brand_name'];?></option>
                <?php endforeach;?>
            </select>
        </p>
        <p>
            商品名称:
            <input type="text" name="gn" value="<?php echo I('get.gn');?>" size=60 />
        </p>
        <p>
            价　　格:
            从<input type="text" name="fp" value="<?php echo I('get.fp');?>" size=20 />
            到<input type="text" name="lp" value="<?php echo I('get.lp');?>" size=20 />
        </p>
        <p>
            是否上架:
            <?php $ios=I('get.ios')?>
            <input type="radio" name="ios" value="" <?php if($ios == '') echo 'checked="checked"';?>/>全部
            <input type="radio" name="ios" value="是" <?php if($ios == '是') echo 'checked="checked"';?>/>是
            <input type="radio" name="ios" value="否" <?php if($ios == '否') echo 'checked="checked"';?>/>否
        </p>
        <p>
            添加时间:
            从<input type="text" name="fa" id="fa" value="<?php echo I('get.fa');?>" size=20 />
            到<input type="text" name="la" id="la" value="<?php echo I('get.la');?>" size=20 />
        </p>
        <p>
            排序方式:
            <?php $odby=I('get.odby','id_desc'); ?>
            <input type="radio" name="odby" value="id_desc" onclick="this.parentNode.parentNode.submit();" <?php if($obdy == 'id_desc') echo 'checked="checked"'; ?> />以id降序
            <input type="radio" name="odby" value="id_asc" onclick="this.parentNode.parentNode.submit();" <?php if($obdy == 'asc') echo 'checked="checked"'; ?> />以id升序
            <input type="radio" name="odby" value="price_desc" onclick="this.parentNode.parentNode.submit();" <?php if($obdy == 'price_desc') echo 'checked="checked"'; ?> />以价格降序
            <input type="radio" name="odby" value="price_asc" onclick="this.parentNode.parentNode.submit();" <?php if($obdy == 'price_asc') echo 'checked="checked"'; ?> />以价格升序
        </p>
        <P>
            <input type="submit" value="搜索" />
	</P>
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>品牌</th>
                <th>商品名称</th>
                <th>LOGO</th>
                <th>本店价格</th>
                <th>市场价格</th>
                <th>上架</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            <?php foreach ($data as $k => $v): ?>
            <tr class="tron">
                <td align="center"><?php echo $v['id']; ?></td>
                <td align="center"><?php echo $v['brand_name']; ?></td>
                <td align="center" class="first-cell"><span><?php echo $v['goods_name']; ?></span></td>
                <!--<td align="center" ><img src='/Public/Uploads/<?php echo $v["sm_logo"]; ?>'/></td>-->
                <td align="center" ><?php showImage($v['sm_logo']); ?></td>
                <td align="center"><span onclick=""><?php echo $v['shop_price']; ?></span></td>
                <td align="center"><span><?php echo $v['market_price']; ?></span></td>
                <td align="center"><span><?php echo $v['is_on_sale']; ?></span></td>
                <td align="center"><span><?php echo $v['addtime']; ?></span></td>
                <td align="center">
                <a href="<?php echo U('edit?id='.$v['id']); ?>">修改</a>
                <a onclick="return confirm('确定要删除吗?')" href="<?php echo U('delete?id='.$v['id']); ?>">删除</a></td>
            </tr>
            <?php endforeach;?>
        </table>

    <!-- 分页开始 -->
        <table id="page-table" cellspacing="0">
            <tr>
                <td width="80%">&nbsp;</td>
                <td align="center" nowrap="true">
                    <?php echo $page;?>
                </td>
            </tr>
        </table>
    <!-- 分页结束 -->
    </div>
</form>


</body>
</html>
<!-- 时间插件 -->
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<link href="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/datepicker-zh_cn.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.css" />
<script type="text/javascript" src="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="/Public/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script>
    
    $.timepicker.setDefaults($.timepicker.regional['zh-CN']);
    $("#fa").datepicker({ dateFormat: "yy-mm-dd" });
//    $("#la").datepicker({ dateFormat: "yy-mm-dd" });
    $("#fa").datetimepicker();
    $("#la").datetimepicker();
</script>
<!--引入行高亮显示-->
<script type="text/javascript" src="/Public/Admin/Js/tron.js"></script>

<div id="footer"> 39期 </div>
</body>
</html>