<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo ADMIN_THEME?>images/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMIN_THEME?>images/system.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMIN_THEME?>images/dialog.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMIN_THEME?>images/main.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMIN_THEME?>images/switchbox.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMIN_THEME?>images/table_form.css" rel="stylesheet" type="text/css" />
<script src="<?php echo ADMIN_THEME?>js/jquery.min.js"></script>
<script src="<?php echo COMMON_THEME?>js/layer.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_THEME?>js/dialog.js"></script>
<script type="text/javascript">var sitepath = "<?php echo SITE_PATH;?>";</script>
<script type="text/javascript" src="<?php echo LANG_PATH?>lang.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_THEME?>js/core.js"></script>
<title>后台管理</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
<div class="content-menu ib-a blue line-x">
<a href='<?php echo purl("admin")?>'><em>广告位管理</em></a><span>|</span>
<a href='<?php echo purl("admin/alist", array('aid'=>$aid))?>'><em>广告管理</em></a><span>|</span>
<a href='<?php echo purl("admin/adda", array('aid'=>$aid))?>' class="on"><em>添加广告</em></a><span>|</span>
<a href='<?php echo purl("admin/cache")?>'><em>更新广告缓存</em></a>
<a href='<?php echo purl("admin/flood")?>'><em>批量添加</em></a>
</div>
<div class="bk10"></div>
<div class="table-list">
<form action="" method="post">
<input name="data[id]" type="hidden" id="id" value="<?php echo $data['id']?>">
<table width="100%" class="table_form ">
	<tr>
        <th width="200">广告名称：</th>
        <td><input type="text" placeholder="一键绑定一级栏目" class="input-text" style="width:200px;" value="<?php echo $data['name']?>" name="data[name]"></td>
    </tr>
    
  
    <tr>
        <th>广告类型：</th>
        <td>
        <select name="data[typeid]" id="typeid" onChange="getField(this)">
        <option value="0">≡ 请选择类型 ≡</option>
        <?php
        foreach ($type as $tid=>$t) {
			$selected = $tid==$data['typeid'] ? " selected" : "";

			echo '<option value="' . $tid . '" ' . $selected . '>' . $t['name'] . '</option>';
		}
		?>
        </select>
        </td>
    </tr>
    <tr hidden>
        <th>开始时间：</th>
        <td><?php echo content_date("startdate", isset($data['startdate']) ? array($data['startdate']) : array(time()));?><div class="onShow">默认为当前时间</div></td>
    </tr>
    <tr hidden>
        <th>结束时间：</th>
        <td><?php echo content_date("enddate", isset($data['enddate']) && $data['enddate'] ? array($data['enddate']) : "");?><div class="onShow">留空默认为永久广告</div></td>
    </tr>
    <tr hidden>
        <th>广告状态：</th>
        <td><input name="data[disabled]" type="radio" value="0" <?php if ($data['disabled']==0 || !isset($data['disabled'])) echo "checked";?>>&nbsp;启用&nbsp;&nbsp;
        <input name="data[disabled]" type="radio" value="1" <?php if ($data['disabled']==1) echo "checked";?>>&nbsp;禁用
        </td>
    </tr>
    <tbody id="type_field">
     <?php echo $fields;?>
    </tbody>
	<tr>
        <th></th>
        <td><input type="submit" class="button" value="提交" name="submit"></td>
    </tr>
</table>
</form>
</div>
</div>
<input type="hidden" value="<?php echo purl("admin/ajaxgetcat");?>" id="url">
<script type="text/javascript">
function getField(obj) {
	var tid = obj.value;
	$.get("<?php echo purl('admin/ajaxfield');?>", {tid:tid}, function(data) {
		if (data){
            console.log(data);
            $("#type_field").html(data);
        } 															 
	});
}
function post(catid)
{
    var url  =  $('#url').val()+'&catid='+catid;
        $.get(url,'',function(data)
        {   
            var obj =   eval('('+data+')');
            var select = $('<select style="margin-left:3px;" class="cat newcat" name="data[catids][]"><option value="0">所有子栏目适用</option></select>');
            $.each(obj.root,function(name,value) {

                    var ob = value;
                    if(!ob){return;}
                    var option = '<option value="'+ob.catid+'" child="'+ob.child+'">'+ob.catname+'</option>';
                    select.append(option);

                });
             console.log(obj.root);
             $('#bindcat').append(select);
            
        })
}
function change()
{
     $('.cat').change(function()
    {   
        var catid  =  $(this).val();
        $('.newcat').remove();
        post(catid);

    }) 

$("#bindcat").on("change",".newcat", function() {
    var catid = $(this).val();
    post(catid);
});

}
function removeOpt()
{

}
function addnew(obj)
{
     post(catid);
}
$(function()
{
     change();
    //  $('.newcat').on('click','option',function(){ 
    //        alert($(this));
    // });
})

</script>
</body>
</html>