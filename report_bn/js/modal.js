$(document).ready(function(){
    
    $(".pop_case1 .pop_list ul li").on("click",function(){
        $(this).siblings().removeClass("on");
        $(this).addClass("on");
        $(".pop_case1_2").css("display","block");
    });
    
    
    $(".pop_case1_2 .pop_list ul li").on("click",function(){
        $(this).siblings().removeClass("on");
        $(this).addClass("on");
    });
    
    
    
    $(".close_pop").on("click",function(){
        $(this).parents(".pop_box").css("display","none");
        $(".pop_c.on").removeClass("on");
    });

    
    
    $(".pop_case1 .close_pop").on("click",function(){
        $('.pop_case1_2').css('display',"none");
    });
    
    
    $(".case_1").on("click",function(){
        $(".pop_case1").css("display","block");
    });
    
    
    $(document).delegate('.pop_c', 'click', function(){
        
        if( $(".pop_c").hasClass("on") ){
            $(".pop_c2btn").removeClass("none");
        }else{
            $(".pop_c2btn").addClass("none");
        }
        
    });
    
    $(".pop_c2btn").on("click",function(){
        
        $(".pop_box").find(".pop_li.on").clone().appendTo(".case_box");
        $(".pop_box").css("display","none");
        $(".pop_box").find(".pop_li.on").removeClass("on");
        $(".case_box li:last-child").after("<span>and</span>").$;
        $(".case_box span:nth-child(3n)").addClass("and");
            $(".pop_c2btn").addClass("none");
        
        
    });
    
    
    
    $(document).delegate('.pop_close', 'click', function(){
        $(this).parents().next(".pop_c").next(".and").remove();
        $(this).parents().next(".pop_c").remove();
        $(this).parents(".pop_t").remove();
        
    });
    
    
    
    
    $(".case_box .close").on("click",function(){
        $(this).parents("li").css("background-color","red");
    });
    
//    
//    $(".right_btn").on("click",function(){
//          
//        $(".m2_pop").css("display","block");
//    });
//    
    
//    $(".end").on("click",function(){
//          
//        $(".m5_1pop").css("display","block");
//    });
//    
//    
    
    
    
    $(".ok_btn").on("click",function(){
          
        $(".m2_pop").css("display","none");
        $(".ser-pop").css("display","none");
        $(".ser4-pop").css("display","none");
    });
    
    $(".no_btn").on("click",function(){
        $(".ser4-pop").css("display","none");
    });
    
    $(".pj_ok").on("click",function(){
          
        $(".ser4_1-pop").css("display","none");
    });
    
    
    
    
    $(document).ready(function(){
        $(".pj_list li").on("click",function(){
            $(".pj_list li").removeClass("on");
            $(this).addClass("on");
        });
        
        $(".side_main ul li").on("click",function(){
            $(".common_pop").css("display","block");
        });
        
        
        $(".pj_close").on("click",function(){
            $(".common_pop").css("display","none");
        });
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
});