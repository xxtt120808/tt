$(".tron").mouseover(function(){
    //修改当前tr里每个TD的背景色
    $(this).find("td").css('backgroundColor','#DEE7E5');
})
$(".tron").mouseout(function(){
     $(this).find("td").css('backgroundColor','#FFF');
})


