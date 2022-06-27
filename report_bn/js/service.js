//
//$(document).delegate("li.ui-widget-content", 'click', function(){
//    $(this).toggleClass("ui-selected");
//});



$(document).delegate('.bb_add', 'click', function(e) {
     $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parents().parent().siblings().children("div").children(".mCSB_container"));
        
//        var count = $(".children__item").find("li.item_serv").length;
//        
//        $(this).parent("div").siblings().html(count); 
//    
//    
//        var llength = $(".children_leftbranch .box_big li").length;
//        $(".bys_num").html(llength);
//    
//        var rlength = $(".children_rightbranch .box_big li").length;
//        $(".iys_num").html(rlength);
////    
//        var pelength = $(".children_leftbranch .box_big li").length;
//        
//        console.log(rlength);
//        $(".count").html(pelength);
      $("ul.selectable").removeClass("selectable");

      $(".side_list").find("li.ui-selected a").addClass("on");
      $(".side_list").find("li.ui-selected").addClass("selectable-disabled");
      $(".side_list").find("li.ui-selected").removeClass("ui-selected");
      $(".side_list").find("li.selected-flag").removeClass("selected-flag");

        return false ;
});





$(document).ready(function(){
    
        $(document).delegate('.ym_add', 'click', function(e) {
            
            var selength = $(".side_list").find("li.ui-selected").length;
            
            console.log(selength);
            
            if( selength > 1 ) {
                
                alert("1개의 문항만 추가 가능합니다.");

            }
             else{
                
                $(".que_l .item_serv.ui-selected").clone().appendTo($(this).siblings(".y_wrap"));

              $(".side_list").find("li.ui-selected a").addClass("on");
              $(".side_list").find("li.ui-selected").addClass("selectable-disabled");
              $(".side_list").find("li.ui-selected").removeClass("ui-selected");
              $(".side_list").find("li.selected-flag").removeClass("selected-flag");
            }         
        });
});



$(document).ready(function(){
    
        $(document).delegate('.cb_bt1, .cb_bt2', 'click', function(e) {
            
            var selength = $(".side_list").find("li.ui-selected").length;
            
            console.log(selength);
            
            if( selength > 1 ) {
                
                alert("1개의 문항만 추가 가능합니다.");

            } 
             else{
                
             $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parent());

              $(".side_list").find("li.ui-selected a").addClass("on");
              $(".side_list").find("li.ui-selected").addClass("selectable-disabled");
              $(".side_list").find("li.ui-selected").removeClass("ui-selected");
              $(".side_list").find("li.selected-flag").removeClass("selected-flag");
            }         
        });
});



$(document).ready(function(){
    
        $(document).delegate('.pyo_add', 'click', function(e) {
                
                $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parent().siblings().children("ul"));

                
              $(".side_list").find("li.ui-selected a").addClass("on");
              $(".side_list").find("li.ui-selected").addClass("selectable-disabled");
              $(".side_list").find("li.ui-selected").removeClass("ui-selected");
              $(".side_list").find("li.selected-flag").removeClass("selected-flag");
            
//            var pelength = $(".side_list").find("li.ui-selected").length;
//            
//            console.log(pelength);
//            
//            if( pelength > 6 ) {
//                
//                alert("특성문항은 최대 6개까지만 입력 가능합니다.");
//            }
//             else{
//                
//                $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parent().siblings().children("ul"));
//
//                
//              $(".side_list").find("li.ui-selected a").addClass("on");
//              $(".side_list").find("li.ui-selected").addClass("selectable-disabled");
//              $(".side_list").find("li.ui-selected").removeClass("ui-selected");
//              $(".side_list").find("li.selected-flag").removeClass("selected-flag");
//            }
        });
        
    
    

    
             
});

$(document).ready(function(){
    
        $(document).delegate('.spe_add', 'click', function(e) {
                
            
                $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parents(".spe_btn").siblings(".spe_box"));

                $(".side_list").find("li.ui-selected a.on").removeClass("on");
                $(".side_list").find("li.ui-selected").addClass("selectable-disabled");
                $(".side_list").find("li.ui-selected").addClass("reset");
                $(".side_list").find("li.ui-selected").removeClass("ui-selected");
                $(".side_list").find("li.selected-flag").removeClass("selected-flag");
            
//            
//            var pelength = $(".side_list").find("li.ui-selected").length;
//            
//            console.log(pelength);
//            
//            if( pelength > 6 ) {
//                
//                alert("요소만족도는 최대 6개까지만 입력 가능합니다.");
//                
//            }
//             else{
//                
//                 $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parents(".spe_btn").siblings(".spe_box"));
//
//                $(".side_list").find("li.ui-selected a.on").removeClass("on");
//                $(".side_list").find("li.ui-selected").addClass("selectable-disabled");
//                $(".side_list").find("li.ui-selected").removeClass("ui-selected");
//                $(".side_list").find("li.selected-flag").removeClass("selected-flag");
//
//            }    
        });
});



        
        $(document).on("click",".chi_del",function(){
            $(this).parents(".children__item").remove();
            
        });    
        
    
    
        $(document).on("click",".bb_re",function(){
            $(this).parents(".center_wrap, .box_wrap ").find("li.item_serv").remove();
            
              $(".side_list").find("li.selectable-disabled").removeClass("selectable-disabled");

        });     



        $(document).on("click",".bb_re",function(){
            $(this).parents(".center_wrap, .box_wrap ").find("li.item_serv").remove();

            var myFeatured = $(this).parents('.box_wrap').children("li.item_serv").attr('id');
                var theHidden;
            
            
                $('.box_wrap li').each(function(){
                    theHidden = $(this).attr('id');
                    console.log(theHidden);
                    if(theHidden == myFeatured){ 
                        $('li#'+theHidden).removeClass("ui-selected");	
                          $('li#'+theHidden).removeClass("selectable-disabled");
                          $('li#'+theHidden).children("a").removeClass("on");
                    }
                });
             $(".que_l").find(".item_serv.selected-flag").removeClass("selected-flag");
             
            
            

        });     
    
        $(document).on("click",".pyo_re",function(){
              $(".pyo_box").find("li").remove();
              $(".side_list").find("li.ui-selected a").removeClass("on");
              $(".que_l").find(".item_serv.ui-selected").removeClass("ui-selected");
            
            
            
              $(".side_list").find("li.selectable-disabled a.on").removeClass("on");
              $(".side_list").find("li.selectable-disabled").removeClass("selectable-disabled");
              $(".side_list").find("li.selected-flag").removeClass("selected-flag");
        });     
    


        $(document).delegate('.spe_re', 'click', function(e) {
              $(".spe_box").find("li").remove();
              $(".side_list").find("li.ui-selected a").removeClass("on");
              $(".que_l").find(".item_serv.ui-selected").removeClass("ui-selected");
            
            
              $(".side_list").find("li.selectable-disabled a.on").removeClass("on");
              $(".side_list").find("li.reset").removeClass("selectable-disabled");
            
              $(".side_list").find("li.selected-flag").removeClass("selected-flag");
             
        });




        $(document).on("click",".box_bot",function(){     
            $(this).parents(".children__item").clone().insertAfter($(this).parents(".children__item"));
            $(this).parents(".children__item").next().find(".item_serv").remove();
             $(this).parents(".children__item").next().find("textarea").val("");
             $(this).parents(".children__item").next().find("input").val("");
            $(".content-rd").mCustomScrollbar({
                        theme:"light-3",
                    });
    
        });

        $(document).on("click",".rbox_bot",function(){     
            $(this).parents(".children__item").clone().insertAfter($(this).parents(".children__item"));
            $(this).parents(".children__item").next().find(".item_serv").remove();
             $(this).parents(".children__item").next().find("textarea").val("");
            
            $(".node.rbox_n").css("height","130px");
            $(".content-rd").mCustomScrollbar({
                        theme:"light-3",
                    });
    

        });
    
        $(document).on("click",".close",function(){     
            $(this).parents("li.item_serv").remove();

            var r2length = $(".children_leftbranch .box_big li").length;
            $(".bys_num").html(r2length);

            var r2length = $(".children_rightbranch .box_big li").length;
            $(".iys_num").html(r2length);

            
            var myFeatured = $(this).parents('li.item_serv').attr('id');
                var theHidden;
                $('li.item_serv').each(function(){
                    theHidden = $(this).attr('id');
                    if(theHidden == myFeatured){ 
                        $('li#'+theHidden).removeClass("ui-selected");	
                          $('li#'+theHidden).removeClass("selectable-disabled");
                          $('li#'+theHidden).children("a").removeClass("on");
                    }
                });
             $(".que_l").find(".item_serv.selected-flag").removeClass("selected-flag");
             
            
        });
    
    
        $(document).on('click', '.box_bot', function(e) {
                $(this).parents().siblings().children("li.selected").remove();
        });




        $(document).on("click",".close",function(){     
            $(this).parents(".case_box").children("li.item_serv").remove();
            $(this).parents(".case_box").children("li:nth-child(2).item_serv").remove();
        });
    





        $(document).ready(function(){
            $('table input').on('paste', function(e){
                var $this = $(this);
                $.each(e.originalEvent.clipboardData.items, function(i, v){
                    if (v.type === 'text/plain'){
                        v.getAsString(function(text){
                            var x = $this.closest('td').index(),
                                y = $this.closest('tr').index(),
                                obj = {};
                            text = text.trim('\r\n');
                            $.each(text.split('\r\n'), function(i2, v2){
                                $.each(v2.split('\t'), function(i3, v3){
                                    var row = y+i2, col = x+i3;
                                    obj['cell-'+row+'-'+col] = v3;
                                    $this.closest('table').find('tr:eq('+row+') td:eq('+col+') input').val(v3);
                                });
                            });
                        });
                    }
                });

            });
        });





        $(document).delegate('.table_add, .table_addr', 'click', function(e) {
             
             $(this).parents("table").clone().insertAfter($(this).parents("table"));
             $(this).parents("table").next().find("input").val("");
            
             var tlength = $(".mCSB_container").children("table").length;
            
            if(tlength > 3) {
                $(".mCSB_horizontal.mCSB_inside > .mCSB_container").css("padding-right","30px");
            }
            
            
            $('table input').on('paste', function(e){
                var $this = $(this);
                $.each(e.originalEvent.clipboardData.items, function(i, v){
                    if (v.type === 'text/plain'){
                        v.getAsString(function(text){
                            var x = $this.closest('td').index(),
                                y = $this.closest('tr').index(),
                                obj = {};
                            text = text.trim('\r\n');
                            $.each(text.split('\r\n'), function(i2, v2){
                                $.each(v2.split('\t'), function(i3, v3){
                                    var row = y+i2, col = x+i3;
                                    obj['cell-'+row+'-'+col] = v3;
                                    $this.closest('table').find('tr:eq('+row+') td:eq('+col+') input').val(v3);
                                });
                            });
                            $('div').text(JSON.stringify(obj));
                        });
                    }
                });

            });
        });


        $(document).delegate('.table_del', 'click', function(e) {
             $(this).parents("table").remove();
        });



        $(document).delegate('.table_re', 'click', function(e) {
             $(this).parents("table").find("input").val("");
        });


        $( document ).ready(function() {
          $(".mop_cus input:radio").click(function() {
            if($(this).val() == "none") {
              $(".cus_que").hide();
            } else {
              $(".cus_que").show();
            }
          });
        });
