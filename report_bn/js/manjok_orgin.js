
    
function lengthCheckofExp(obj)
    {
        if(obj.value.length >= obj.maxLength) //obj.maxLength = 2
        {
            return false;
        }
    }

$(document).delegate('.side_list li', 'mouseenter', function(e) {
    $(this).find('.dec_in').attr('placeholder', $(this).find("a.overtext").text());
    $(this).find('.dec_in').attr('title', $(this).find("a.overtext").text());

    
});




$(document).delegate('.bb_add', 'click', function(e) {
     $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parents().parent().siblings().children("div").children(".mCSB_container"));

      $("ul.selectable").removeClass("selectable");

      $(".side_list").find("li.ui-selected a").addClass("on");
      $(".side_list").find("li.ui-selected").addClass("appended");
      $(".side_list").find("li.ui-selected").removeClass("ui-selected");
      $(".side_list").find("li.selected-flag").removeClass("selected-flag");

      
});



$(document).delegate('.main_pro li a', 'mouseenter', function(e) {
    $(this).attr('title', $(this).text());
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
              $(".side_list").find("li.ui-selected").addClass("appended");
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
              $(".side_list").find("li.ui-selected").addClass("appended");
              $(".side_list").find("li.ui-selected").removeClass("ui-selected");
              $(".side_list").find("li.selected-flag").removeClass("selected-flag");
            }         
        });
});



$(document).ready(function(){
    
        $(document).delegate('.pyo_add', 'click', function(e) {
                
                $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parent().siblings().children("ul"));

                
              $(".side_list").find("li.ui-selected a").addClass("on");
              $(".side_list").find("li.ui-selected").addClass("appended");
              $(".side_list").find("li.ui-selected").removeClass("ui-selected");
              $(".side_list").find("li.selected-flag").removeClass("selected-flag");

        });
        
});

$(document).ready(function(){
    
        $(document).delegate('.spe_add', 'click', function(e) {
                
            
                $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parents(".spe_btn").siblings(".spe_box"));

                $(".side_list").find("li.ui-selected a.on").removeClass("on");
                $(".side_list").find("li.ui-selected").addClass("appended");
                $(".side_list").find("li.ui-selected").addClass("reset");
                $(".side_list").find("li.ui-selected").removeClass("ui-selected");
                $(".side_list").find("li.selected-flag").removeClass("selected-flag");

        });
});



        
        $(document).on("click",".chi_del",function(){
            
              
             
             
             $(this).parents(".children__item").remove();
             
             $(".side_list").find("li.appended").removeClass("appended");
             
             
             
             
              var itemids3 = $.makeArray($(".main_flow").find(".item_serv").map(function(){
                    return $(this).attr("id");
                }));
            
                $.each(itemids3, function() {
                   $("#" + this).addClass('appended');
                });
            
        });    
        
    
    
        $(document).on("click",".bb_re",function(){
            $(this).parents(".center_wrap, .box_wrap ").find("li.item_serv").remove();
            
              $(".side_list").find("li.appended").removeClass("appended");

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
                          $('li#'+theHidden).removeClass("appended");
                          $('li#'+theHidden).children("a").removeClass("on");
                    }
                });
             $(".que_l").find(".item_serv.selected-flag").removeClass("selected-flag");
             
            
            

        });     
    
        $(document).on("click",".pyo_re",function(){
              $(this).parents().siblings(".pyo_box").find("li").remove();
            
              $(".side_list").find("li.appended").removeClass("appended");
             
              var itemids3 = $.makeArray($(".main_flow").find(".item_serv").map(function(){
                    return $(this).attr("id");}));
            
                $.each(itemids3, function() {
                   $("#" + this).addClass('appended');
                });
            
        });     
    


        $(document).delegate('.spe_re', 'click', function(e) {
              $(".spe_box").find("li").remove();
            
             $(".side_list").find("li.appended").removeClass("appended");
             
             
             
             
              var itemids3 = $.makeArray($(".main_mop").find(".item_serv").map(function(){
                    return $(this).attr("id");
                }));
            
                $.each(itemids3, function() {
                   $("#" + this).addClass('appended');
                });
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
            
            $(".content-rd").mCustomScrollbar({
                        theme:"light-3",
                    });
    

        });
    
        $(document).on("click",".close",function(){     
            $(this).parents("li.item_serv").remove();

            
             $(".side_list").find("li.appended").removeClass("appended");
             
             
             
             
              var itemids3 = $.makeArray($(".main_pro").find(".item_serv").map(function(){
                    return $(this).attr("id");
                }));
            
                $.each(itemids3, function() {
                   $("#" + this).addClass('appended');
                });
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
            
            if(tlength > 4) {
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











//          서비스평가쿼리



    $(document).ready(function(){
        
        
    
        $(document).delegate('.ser_add', 'click', function(e) {
            
            var selength = $(".side_list").find("li.ui-selected").length;
            
            console.log(selength);
            
            if( selength > 1 ) {
                
                alert("1개의 문항만 추가 가능합니다.");

            } 
             else{
                
                $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parents(".ser_btn"));

              $(".side_list").find("li.ui-selected a").addClass("on");
              $(".side_list").find("li.ui-selected").addClass("appended");
              $(".side_list").find("li.ui-selected").removeClass("ui-selected");
              $(".side_list").find("li.selected-flag").removeClass("selected-flag");
            }         
        });
    });





        $(document).on("click",".ser_re",function(){
              $(this).parents().siblings(".ser_box").find("li").remove();
              $(".side_list").find("li.ui-selected a").removeClass("on");
              $(".que_l").find(".item_serv.ui-selected").removeClass("ui-selected");
            
            
            
              $(".side_list").find("li.appended a.on").removeClass("on");
              $(".side_list").find("li.appended").removeClass("appended");
              $(".side_list").find("li.selected-flag").removeClass("selected-flag");
        });     
    




        $(document).delegate('.jib_bot', 'click', function(e) {
            $(this).parents(".ser").clone().insertAfter($(this).parents(".ser")); 
            $(this).parents(".ser").next().find(".item_serv").remove();
            
            var clonemax = 5;
            
            if ($(".ser").length >= clonemax) {
               $(".ser").eq(4).remove();
                alert('집단구분항목은 4개까지 입력가능합니다.');
            
            }else{
	           $('.jib_bot').css("pointer-events","inherit");
            }
        });


        $(document).delegate('.ser_del', 'click', function(e) {
            $(this).parents(".ser").remove();
             $(".side_list").find("li.appended").removeClass("appended");
             
             
             
             
              var itemids3 = $.makeArray($(".main_dam1").find(".item_serv").map(function(){
                    return $(this).attr("id");
                }));
            
                $.each(itemids3, function() {
                   $("#" + this).addClass('appended');
                });
        });




        $(document).delegate('.rbl_add', 'click', function(e) {
            
            
             $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parents(".rwb_l").find(".mCSB_container"));
            

              $(".side_list").find("li.ui-selected a").addClass("on");
              $(".side_list").find("li.ui-selected").addClass("appended");
              $(".side_list").find("li.ui-selected").removeClass("ui-selected");
              $(".side_list").find("li.selected-flag").removeClass("selected-flag");
            
                var itemids = $.makeArray($(this).parents(".rwb_l").find("li.item_serv").map(function(){
                    return $(this).attr("id");
                }));
            
            console.log(itemids);
            
            });

        $(document).delegate('span', 'click' ,function (){
            var checkbox = $(this).find('input[type=checkbox]');
           checkbox.prop("checked", !checkbox.prop("checked"));
            
            $(this).toggleClass("checked");
        });

        

        $(document).on("click",".rwb_bot",function(){     
            $(this).parents(".rwb_wrap").clone().insertAfter($(this).parents(".rwb_wrap"));
            $(this).parents(".rwb_wrap").next().find(".item_serv").remove();
             $(this).parents(".rwb_wrap").next().find("textarea").val("");
             $(this).parents(".rwb_wrap").next().find("input").val("");
             $(this).parents(".rwb_wrap").next().find("input").val("");
             $(this).parents(".rwb_wrap").next().find("span").removeClass("checked");
             $(this).parents(".rwb_wrap").next().find(".content-rd").children(".mCustomScrollBox").remove();
           
            $(document).ready(function(){

                $(".content-rd").mCustomScrollbar({
                                theme:"light-3",
                            });
            });
            
            

                $(".dis_toggle").keyup(function(){
                    $('.box_big input[type=text]').val($(this).val());
                });
            
        });





        $(document).on("click",".rwg_bot",function(){     
            $(this).prev(".rwg_wrap").clone().insertAfter($(this).prev(".rwg_wrap"));
            $(".content-rd").mCustomScrollbar({
                        theme:"light-3",
                    });
    
             $(this).prev(".rwg_wrap").find('input').val("");
            });


            $(document).ready(function(){
                $(".dis_toggle2").keyup(function(){
                    $(this).parents(".s2_l").find('input[type=text]').val($(this).val());
                });
        
        
        });







         $(document).ready(function(){
            $(".dis_toggle").prop('disabled', true);
            $('input[type=radio]').click(function(){
                if($(this).prop('class') == "r2l_yes"){
                 $(this).siblings(".dis_toggle").prop("disabled", false);
              }else{
                $(this).parents("span").siblings("span").find(".dis_toggle").prop("disabled", true);
                $(this).parents("span").siblings("span").find(".dis_toggle").val("");
                $(".box_big input[type=text]").val("");
              }

            });

         });


         $(document).ready(function(){
            $(".dis_toggle2").prop('disabled', true);
            $('input[type=radio]').click(function(){
                if($(this).prop('class') == "r2l_yes"){
                 $(this).siblings(".dis_toggle2").prop("disabled", false);
              }else{
                $(this).parents("span").siblings("span").find(".dis_toggle2").prop("disabled", true);
                $(this).parents("span").siblings("span").find(".dis_toggle2").val("");
                $(".box_big input[type=text]").val("");
              }

            });

         });


        $(document).delegate('.rbl_add', 'click', function(e) {
                $(".dis_toggle").keyup(function(){
                    $('.box_big input[type=text]').val($(this).val());
                });
            
            
                $(this).parents('.rwb_wrap').find('.r_jong').removeClass('checked');
            });


            $(document).ready(function(){
                $(".dis_toggle2").keyup(function(){
                    $(this).parents(".s2_l").find('input[type=text]').val($(this).val());
                });
            });




         $(document).ready(function(){
            $(".rwg_input input").prop('disabled', true);
            $('.radio_2rt').click(function(){
                if($(".radio_2rt span").prop('class') == "yes_no"){
                 $(".rwg_input input").prop("disabled", false);
              }else{
                $(".rwg_input input").prop("disabled", true);
              }

            });

         });


         $(document).ready(function(){
            $(document).delegate('.r_jong',"click",function(){
                
                if($(this).hasClass('checked')){
                    $(this).parent('.rwb_c').siblings('.rwb_l').find(".jong_div").css('pointer-events',"none");
                    $(this).parent('.rwb_c').siblings('.rwb_l').find(".jong_div").removeClass('checked'); $(this).parent('.rwb_c').siblings('.rwb_l').find(".jong_div input").prop('checked',false);
              }else{ 
                  $(this).parent('.rwb_c').siblings('.rwb_l').find(".jong_div").css('pointer-events',"inherit"); 
              }
            });
             
         });

         $(document).delegate(".rwb_minus", "click", function(){

             
             
             $(this).parents(".rwb_wrap").remove();
             
             $(".side_list").find("li.appended").removeClass("appended");
             
             
             
             
              var itemids3 = $.makeArray($(".main_ser").find(".item_serv").map(function(){
                    return $(this).attr("id");
                }));
            
                $.each(itemids3, function() {
                   $("#" + this).addClass('appended');
                });
             
             
              var itemids3 = $.makeArray($(".main_dam").find(".item_serv").map(function(){
                    return $(this).attr("id");
                }));
            
                $.each(itemids3, function() {
                   $("#" + this).addClass('appended');
                });
             
         });

         $(document).delegate(".minus_rwg", "click", function(){
     
             $(this).parents(".rwg_wrap").remove();

         });

         $(document).delegate(".minus_re", "click", function(){
     
             $(this).parents(".rwg_wrap").find('input').val("");

         });




            $(document).delegate('.da3_add', 'click', function(e) {

                var selength = $(".side_list").find("li.ui-selected").length;

                console.log(selength);

                if( selength > 1 ) {

                    alert("1개의 문항만 추가 가능합니다.");

                }
                 else{

                    $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parent(".da3_btn"));

                  $(".side_list").find("li.ui-selected a").addClass("on");
                  $(".side_list").find("li.ui-selected").addClass("appended");
                  $(".side_list").find("li.ui-selected").removeClass("ui-selected");
                  $(".side_list").find("li.selected-flag").removeClass("selected-flag");
                }    
            });


                $(document).ready(function(){
                    $('.da3_table table input').on('input', function() {
                      var $tr = $(this).closest('tr'); // get tr which contains the input
                      var tot = 0; // variable to sore sum
                      $('input', $tr).each(function() { // iterate over inputs
                        tot += Number($(this).val()) || 0; // parse and add value, if NaN then add 0
                      });
                      $('td:last', $tr).text(tot); // update last column value
                    }).trigger('input'); // trigger input to set initial value in column
                });







         $(document).ready(function(){
             
            $(".da3 .icon_box input[type=radio]").prop('checked', true);
            $('.icon_box').siblings('.da3_table').children(".da3t_wrap").css("display","none");
             
             
            $('.da3 .icon_box input[type=radio]').click(function(){
                if($(this).prop('class') == "da3_no"){
                    
                  var itemids3 = $.makeArray($(".damy_mop").find(".item_serv").map(function(){
                        return $(this).attr("id");
                    }));
                    
                    
                    $.each(itemids3, function() {
                       $("#" + this).addClass('appended');
                    });
                    
                    
                    $(this).parents('.da3y_wrap2').siblings('.da3_btn').addClass("on");
                   
                     $(this).parents('.icon_box').siblings('.da3_table').children(".da3t_wrap").find('.score_da').val("");
                     $(this).parents('.icon_box').siblings('.da3_table').children(".da3t_wrap").find('.score_sum').text("0");
                    
                    
                    
                    $(this).parents('.icon_box').siblings('.da3_table').children(".da3t_wrap").css("display","none");
                    
                    $('.da3_btn').find('li').remove();
             $(".side_list").find("li.appended").removeClass("appended");

              }else{
                    $(this).parents('.da3y_wrap').siblings('.da3_btn').removeClass("on");
                   $(this).parents('.icon_box').siblings('.da3_table').children(".da3t_wrap").css("display","block");
              }

            });

         });





// 의사결정모델



        $(document).delegate('.decp_add', 'click', function(e) {
                
                $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parent().siblings().children("ul"));

                
              $(".side_list").find("li.ui-selected a").addClass("on");
              $(".side_list").find("li.ui-selected").addClass("appended");
              $(".side_list").find("li.ui-selected").removeClass("ui-selected");
              $(".side_list").find("li.selected-flag").removeClass("selected-flag");

        });

        $(document).on("click",".decp_re",function(){
              $(this).parents().siblings(".dec_box").find("li").remove();
            
              $(".side_list").find("li.appended").removeClass("appended");
             
              var itemids3 = $.makeArray($(".main_flow").find(".item_serv").map(function(){
                    return $(this).attr("id");}));
            
                $.each(itemids3, function() {
                   $("#" + this).addClass('appended');
                });
            
        });     
    




        $(document).delegate('.dec_min1', 'click', function(e) {
            $(this).parents('.node').siblings('ol').remove();
            $(this).css('display',"none");
            $(this).siblings('.dec_add').css('display',"block");
            
            
            
              $(".side_list").find("li.appended").removeClass("appended");
             
              var itemids3 = $.makeArray($(".main_dec2").find(".item_serv").map(function(){
                    return $(this).attr("id");}));
            
                $.each(itemids3, function() {
                   $("#" + this).addClass('appended');
                });
        });

        $(document).delegate('.dec_add1', 'click', function(e) {
            var a = $('.side_list').find('li.ui-selected').length;
            
            console.log(a);
            
            
            if( a != 1 && a != 3 && a != 9 && a != 10 ){
                
                alert('변수는 1개, 3개, 9개, 10개만 입력가능합니다.');
            }else{
                
            $(this).parents('.node').after("<ol></ol>");
            $(this).css('display',"none");
            $(this).siblings('.dec_min').css('display',"block");
            $('ol').addClass('children');
             $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parents('.node').siblings('.children'));
            
            
              $('.main_dec2').find('li.item_serv').addClass('children__item');
            
              $("ul.selectable").removeClass("selectable");

              $(".side_list").find("li.ui-selected a").addClass("on");
              $(".side_list").find("li.ui-selected").addClass("appended");
              $(".side_list").find("li.ui-selected").removeClass("ui-selected");
              $(".side_list").find("li.selected-flag").removeClass("selected-flag");
                
            }
            
            
        });



        $(document).delegate('.dec_add2', 'click', function(e) {
            var b = $('.side_list').find('li.ui-selected').length;
            
            console.log(b);
            
            
            if( b != 1 && b != 3 && b != 9 && b != 10 ){
                
                alert('변수는 1개, 3개, 9개, 10개만 입력가능합니다.');
            }else{
                
            $(this).parents('.node').after("<ol></ol>");
            $(this).css('display',"none");
            $(this).siblings('.dec_min').css('display',"block");
            $('ol').addClass('children');
                
              
             $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parents('.node').siblings('.children'));
            
            $('ol li').addClass('children__item');
             var thisa = $(this).find('.dec_in').length();
                
                console.log(thisa);
                
                
                
              $('.main_dec2').find('li.item_serv').addClass('children__item');
            

              $(".side_list").find("li.ui-selected a").addClass("on");
              $(".side_list").find("li.ui-selected").addClass("appended");
              $(".side_list").find("li.ui-selected").removeClass("ui-selected");
              $(".side_list").find("li.selected-flag").removeClass("selected-flag");
                
            };
            

        });
  
    
        $(document).delegate('.dec_add3', 'click', function(e) {
                
                $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parents(".dec_btn").siblings(".dec_box"));

                $(".side_list").find("li.ui-selected a.on").removeClass("on");
                $(".side_list").find("li.ui-selected").addClass("appended");
                $(".side_list").find("li.ui-selected").addClass("reset");
                $(".side_list").find("li.ui-selected").removeClass("ui-selected");
                $(".side_list").find("li.selected-flag").removeClass("selected-flag");

        });
            
    
        $(document).delegate('.dec_re', 'click', function(e) {
                
              $(this).parents().siblings(".dec_box").find("li").remove();
              $(".side_list").find("li.appended").removeClass("appended");
            
             
              var itemids3 = $.makeArray($(".main_dec1").find(".item_serv").map(function(){
                    return $(this).attr("id");
                }));
            
                $.each(itemids3, function() {
                   $("#" + this).addClass('appended');
                });

        });
            
            
            
            
            
            
            
