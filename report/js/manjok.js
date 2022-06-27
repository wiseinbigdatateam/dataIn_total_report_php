function lengthCheckofExp(obj) {
  if (obj.value.length >= obj.maxLength) {
    //obj.maxLength = 2
    return false;
  }
}

$(document).delegate(".side_list li", "mouseenter", function (e) {
  $(this)
    .find(".dec_in")
    .attr("placeholder", $(this).find("a.overtext").text());
  $(this).find(".dec_in").attr("title", $(this).find("a.overtext").text());
});

$(document).delegate(".bb_add", "click", function (e) {
  // 2021-07-29 추가
  const lists = document.querySelectorAll(
    ".pro_ul.ui-selectable .item_serv.ui-selected"
  );
  if (lists.length == 0) {
    alert("문항을 설정해주세요.");
    return false;
  }

  $(".que_l .item_serv.ui-selected")
    .clone()
    .appendTo(
      $(this)
        .parents()
        .parent()
        .siblings()
        .children("div")
        .children(".mCSB_container")
    );

  var pelength = $(".side_list").find("li.ui-selected").length;
  //console.log(pelength);
  var bbsreplll = $(this).attr("id");
  //alert(bbsreplll);
  var bbsreplll2 = bbsreplll.replace("bb_add", "");

  //alert(bbsreplll);
  //alert(bbsreplll2);

  $("#select_quiz_cnt" + bbsreplll2 + "").html(pelength);

  //alert(pelength);
  //alert("select_quiz_cnt"+bbsreplll2+"");

  $("ul.selectable").removeClass("selectable");

  $(".side_list").find("li.ui-selected a").addClass("on");
  $(".side_list").find("li.ui-selected").addClass("appended");
  $(".side_list").find("li.ui-selected").removeClass("ui-selected");
  $(".side_list").find("li.selected-flag").removeClass("selected-flag");
  $(".side_list").find("li.ui-selectee").removeClass("ui-selectee");

  dWeight();
});

$(document).delegate(".bb_add_m", "click", function (e) {
  // 2021-07-29 추가
  const lists = document.querySelectorAll(
    ".pro_ul.ui-selectable .item_serv.ui-selected"
  );
  if (lists.length == 0) {
    alert("문항을 설정해주세요.");
    return false;
  }
  $(".que_l .item_serv.ui-selected")
    .clone()
    .appendTo(
      $(this)
        .parents()
        .parent()
        .siblings()
        .children("div")
        .children(".mCSB_container")
    );

  var pelength = $(".side_list").find("li.ui-selected").length;
  //console.log(pelength);
  $("#select_quiz_m_cnt").html(pelength);

  $("ul.selectable").removeClass("selectable");

  $(".side_list").find("li.ui-selected a").addClass("on");
  $(".side_list").find("li.ui-selected").addClass("appended");
  $(".side_list").find("li.ui-selected").removeClass("ui-selected");
  $(".side_list").find("li.selected-flag").removeClass("selected-flag");
  $(".side_list").find("li.ui-selectee").removeClass("ui-selectee");

  dWeight();
});

$(document).delegate(".bb_add_y", "click", function (e) {
  // 2021-07-29 추가
  const lists = document.querySelectorAll(
    ".pro_ul.ui-selectable .item_serv.ui-selected"
  );
  if (lists.length == 0) {
    alert("문항을 설정해주세요.");
    return false;
  }
  $(".que_l .item_serv.ui-selected")
    .clone()
    .appendTo(
      $(this)
        .parents()
        .parent()
        .siblings()
        .children("div")
        .children(".mCSB_container")
    );

  var pelength = $(".side_list").find("li.ui-selected").length;
  //console.log(pelength);
  var bbsreplll = $(this).attr("id");
  //alert(bbsreplll);

  var bbsreplll2 = bbsreplll.replace("bb_add_y", "");

  //alert(bbsreplll);
  //alert(bbsreplll2);

  $("#select_quiz_y_cnt" + bbsreplll2 + "").html(pelength);

  //alert(pelength);
  //alert("select_quiz_cnt"+bbsreplll2+"");

  $("ul.selectable").removeClass("selectable");

  $(".side_list").find("li.ui-selected a").addClass("on");
  $(".side_list").find("li.ui-selected").addClass("appended");
  $(".side_list").find("li.ui-selected").removeClass("ui-selected");
  $(".side_list").find("li.selected-flag").removeClass("selected-flag");
  $(".side_list").find("li.ui-selectee").removeClass("ui-selectee");
});

$(document).delegate(".main_pro li a", "mouseenter", function (e) {
  $(this).attr("title", $(this).text());
});

$(document).ready(function () {
  $(document).delegate(".ym_add", "click", function (e) {
    // 2021-07-29 추가
    const lists = document.querySelectorAll(
      ".pro_ul.ui-selectable .item_serv.ui-selected"
    );
    if (lists.length == 0) {
      alert("문항을 설정해주세요.");
      return false;
    }

    var selength = $(".side_list").find("li.ui-selected").length;

    console.log(selength);

    if (selength > 1) {
      alert("1개의 문항만 추가 가능합니다.");
    } else {
      $(".que_l .item_serv.ui-selected")
        .clone()
        .appendTo($(this).siblings(".y_wrap"));

      $(".side_list").find("li.ui-selected a").addClass("on");
      $(".side_list").find("li.ui-selected").addClass("appended");
      $(".side_list").find("li.ui-selected").removeClass("ui-selected");
      $(".side_list").find("li.selected-flag").removeClass("selected-flag");
    }
    dWeight();
  });
});

$(document).ready(function () {
  $(document).delegate(".cb_bt1, .cb_bt2", "click", function (e) {
    var selength = $(".side_list").find("li.ui-selected").length;

    console.log(selength);

    if (selength > 1) {
      alert("1개의 문항만 추가 가능합니다.");
    } else {
      $(".que_l .item_serv.ui-selected").clone().appendTo($(this).parent());

      $(".side_list").find("li.ui-selected a").addClass("on");
      $(".side_list").find("li.ui-selected").addClass("appended");
      $(".side_list").find("li.ui-selected").removeClass("ui-selected");
      $(".side_list").find("li.selected-flag").removeClass("selected-flag");
    }
  });
});

$(document).ready(function () {
  $(document).delegate(".pyo_add", "click", function (e) {
    $(".que_l .item_serv.ui-selected")
      .clone()
      .appendTo($(this).parent().siblings().children("ul"));

    $(".side_list").find("li.ui-selected a").addClass("on");
    $(".side_list").find("li.ui-selected").addClass("appended");
    $(".side_list").find("li.ui-selected").removeClass("ui-selected");
    $(".side_list").find("li.selected-flag").removeClass("selected-flag");
  });
});

$(document).ready(function () {
  $(document).delegate(".spe_add", "click", function (e) {
    $(".que_l .item_serv.ui-selected")
      .clone()
      .appendTo($(this).parents(".spe_btn").siblings(".spe_box"));

    $(".side_list").find("li.ui-selected a.on").removeClass("on");
    $(".side_list").find("li.ui-selected").addClass("appended");
    $(".side_list").find("li.ui-selected").addClass("reset");
    $(".side_list").find("li.ui-selected").removeClass("ui-selected");
    $(".side_list").find("li.selected-flag").removeClass("selected-flag");
  });
});

$(document).on("click", ".chi_del", function () {
  $(this).parents(".children__item").remove();

  $(".side_list").find("li.appended").removeClass("appended");

  var itemids3 = $.makeArray(
    $(".main_flow")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });
});

$(document).on("click", ".chi_del_1", function () {
  var attach_count_1 = Number($("#attach_count_1").val());
  attach_count_1 = attach_count_1 - 1;
  if (attach_count_1 < 1) {
    attach_count_1 = 1;
  } else {
    $(this).parents(".children__item").remove();
  }

  $("#attach_count_1").val(attach_count_1);
  $("#box_bot" + attach_count_1 + "").show();
});

$(document).on("click", ".chi_del_1_y", function () {
  var attach_count_2 = Number($("#attach_count_2").val());
  attach_count_2 = attach_count_2 - 1;
  if (attach_count_2 < 1) {
    attach_count_2 = 1;
  } else {
    $(this).parents(".children__item2").remove();
  }

  $("#attach_count_2").val(attach_count_2);
  $("#rbox_bot" + attach_count_2 + "").show();
});

$(document).on("click", ".bb_re", function () {
  $(this).parents(".center_wrap, .box_wrap ").find("li.item_serv").remove();

  $(".side_list").find("li.appended").removeClass("appended");
});

$(document).on("click", ".bb_re", function () {
  $(this).parents(".center_wrap, .box_wrap ").find("li.item_serv").remove();

  var myFeatured = $(this)
    .parents(".box_wrap")
    .children("li.item_serv")
    .attr("id");
  var theHidden;

  $(".box_wrap li").each(function () {
    theHidden = $(this).attr("id");
    console.log(theHidden);
    if (theHidden == myFeatured) {
      $("li#" + theHidden).removeClass("ui-selected");
      $("li#" + theHidden).removeClass("appended");
      $("li#" + theHidden)
        .children("a")
        .removeClass("on");
    }
  });
  $(".que_l").find(".item_serv.selected-flag").removeClass("selected-flag");
});

$(document).on("click", ".pyo_re", function () {
  $(this).parents().siblings(".pyo_box").find("li").remove();

  $(".side_list").find("li.appended").removeClass("appended");

  var itemids3 = $.makeArray(
    $(".main_flow")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });
});

$(document).delegate(".spe_re", "click", function (e) {
  $(".spe_box").find("li").remove();

  $(".side_list").find("li.appended").removeClass("appended");

  var itemids3 = $.makeArray(
    $(".main_mop")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });
});

$(document).on("click", ".box_bot", function () {
  $(this)
    .parents(".children__item")
    .clone()
    .insertAfter($(this).parents(".children__item"));
  $(this).parents(".children__item").next().find(".item_serv").remove();
  $(this).parents(".children__item").next().find("textarea").val("");
  $(this).parents(".children__item").next().find("input").val("");
  $(".content-rd").mCustomScrollbar({
    theme: "light-3",
  });
});

$(document).on("click", ".rbox_bot", function () {
  $(this)
    .parents(".children__item")
    .clone()
    .insertAfter($(this).parents(".children__item"));
  $(this).parents(".children__item").next().find(".item_serv").remove();
  $(this).parents(".children__item").next().find("textarea").val("");

  $(".content-rd").mCustomScrollbar({
    theme: "light-3",
  });
});

$(document).on("click", ".box_bot_1", function () {
  $(this)
    .parents(".children__item")
    .clone()
    .insertAfter($(this).parents(".children__item"));
  $(this).parents(".children__item").next().find(".item_serv").remove();
  $(this).parents(".children__item").next().find("textarea").val("");
  $(this).parents(".children__item").next().find("input").val("");
  $(".content-rd").mCustomScrollbar({
    theme: "light-3",
  });

  var bbsreplll = $(this).attr("id");
  //alert(bbsreplll);

  $("#" + bbsreplll + "").hide();

  var $div = $('div[id^="box_bot"]:last');
  var $div_select_p = $('ul[id^="select_type_x_p"]:last');
  var $div_select_c = $('div[id^="select_type_x_c"]:last');
  var $div_select_cnt = $('div[id^="select_quiz_cnt"]:last');
  var $div_add = $('button[id^="bb_add"]:last');
  var $div_elementweight = $('input[id^="elementweight"]:last');
  var $div_weight = $('input[id^="weight"]:last');

  var org_num = parseInt($div.prop("id").match(/\d+/g), 10);
  var num = org_num + 1;

  var $klon = $div.prop("id", "box_bot" + num);
  var $klon_select_p = $div_select_p.prop("id", "select_type_x_p" + num);
  var $klon_select_c = $div_select_c.prop("id", "select_type_x_c" + num);
  var $klon_select_cnt = $div_select_cnt.prop("id", "select_quiz_cnt" + num);
  var $klon_add = $div_add.prop("id", "bb_add" + num);
  //var $klon_no_x_p = $div_no_x_p.prop('id', 'factor_no_x_p'+num );
  //var $klon_no_x_c = $div_no_x_c.prop('id', 'factor_no_x_c'+num );
  //var $klon_elementweight = $div_elementweight('id','elementweight'+num);
  //var $klon_weight = $div_weight('id','weight'+num);

  $("#select_quiz_cnt" + num + "").html("");
  $("#elementweight" + num + "").val("0");
  $("#weight" + num + "").val("0");

  //alert("elementweight"+num+"");

  var attach_count_1 = Number($("#attach_count_1").val());
  attach_count_1 = attach_count_1 + 1;
  $("#attach_count_1").val(attach_count_1);

  //alert('box_bot'+num);
  dWeight();
});

$(document).on("click", ".rbox_bot_1", function () {
  $(this)
    .parents(".children__item2")
    .clone()
    .insertAfter($(this).parents(".children__item2"));
  $(this).parents(".children__item2").next().find(".item_serv").remove();
  $(this).parents(".children__item2").next().find("textarea").val("");

  $(".content-rd").mCustomScrollbar({
    theme: "light-3",
  });

  var bbsreplll = $(this).attr("id");
  //alert(bbsreplll);

  $("#" + bbsreplll + "").hide();

  var $div = $('div[id^="rbox_bot"]:last');
  var $div_select_p = $('ul[id^="select_type_y_p"]:last');
  var $div_select_cnt = $('div[id^="select_quiz_y_cnt"]:last');
  var $div_add = $('button[id^="bb_add_y"]:last');

  var org_num = parseInt($div.prop("id").match(/\d+/g), 10);
  var num = org_num + 1;

  var $klon = $div.prop("id", "rbox_bot" + num);
  var $klon_select_p = $div_select_p.prop("id", "select_type_y_p" + num);
  var $klon_select_cnt = $div_select_cnt.prop("id", "select_quiz_y_cnt" + num);
  var $klon_add = $div_add.prop("id", "bb_add_y" + num);

  $("#select_quiz_y_cnt" + num + "").html("");

  var attach_count_2 = Number($("#attach_count_2").val());
  attach_count_2 = attach_count_2 + 1;
  $("#attach_count_2").val(attach_count_2);
});

$(document).on("click", ".close", function () {
  $(this).parents("li.item_serv").remove();

  $(".side_list").find("li.appended").removeClass("appended");

  var itemids3 = $.makeArray(
    $(".main_pro")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });
  dWeight();
});

$(document).on("click", ".box_bot", function (e) {
  $(this).parents().siblings().children("li.selected").remove();
});

$(document).on("click", ".close", function () {
  $(this).parents(".case_box").children("li.item_serv").remove();
  $(this).parents(".case_box").children("li:nth-child(2).item_serv").remove();
});

$(document).ready(function () {
  $("table input").on("paste", function (e) {
    var $this = $(this);
    $.each(e.originalEvent.clipboardData.items, function (i, v) {
      if (v.type === "text/plain") {
        v.getAsString(function (text) {
          var x = $this.closest("td").index(),
            y = $this.closest("tr").index(),
            obj = {};
          text = text.trim("\r\n");
          $.each(text.split("\r\n"), function (i2, v2) {
            $.each(v2.split("\t"), function (i3, v3) {
              var row = y + i2,
                col = x + i3;
              obj["cell-" + row + "-" + col] = v3;
              $this
                .closest("table")
                .find("tr:eq(" + row + ") td:eq(" + col + ") input")
                .val(v3);
            });
          });
        });
      }
    });
  });
});

$(document).delegate(".table_add, .table_addr", "click", function (e) {
  //  2021-07-28 추가분
  var tableCount = $(this).parents("div.content-xd").find(".susik-t").length;
  console.log(tableCount);
  if (tableCount > 2) {
    return false;
  }
  // -------------------

  $(this).parents("table").clone().insertAfter($(this).parents("table"));
  $(this).parents("table").next().find("input").val("");

  var tlength = $(".mCSB_container").children("table").length;
  if (tlength > 4) {
    $(".mCSB_horizontal.mCSB_inside > .mCSB_container").css(
      "padding-right",
      "30px"
    );
    // return false;
  }

  $("table input").on("paste", function (e) {
    var $this = $(this);
    $.each(e.originalEvent.clipboardData.items, function (i, v) {
      if (v.type === "text/plain") {
        v.getAsString(function (text) {
          var x = $this.closest("td").index(),
            y = $this.closest("tr").index(),
            obj = {};
          text = text.trim("\r\n");
          $.each(text.split("\r\n"), function (i2, v2) {
            $.each(v2.split("\t"), function (i3, v3) {
              var row = y + i2,
                col = x + i3;
              obj["cell-" + row + "-" + col] = v3;
              $this
                .closest("table")
                .find("tr:eq(" + row + ") td:eq(" + col + ") input")
                .val(v3);
            });
          });
        });
      }
    });
  });
  // $('table input').on('paste', function(e){
  //     var $this = $(this);
  //     $.each(e.originalEvent.clipboardData.items, function(i, v){
  //         if (v.type === 'text/plain'){
  //             v.getAsString(function(text){
  //                 var x = $this.closest('td').index(),
  //                     y = $this.closest('tr').index(),
  //                     obj = {};
  //                 text = text.trim('\r\n');
  //                 $.each(text.split('\r\n'), function(i2, v2){
  //                     $.each(v2.split('\t'), function(i3, v3){
  //                         var row = y+i2, col = x+i3;
  //                         obj['cell-'+row+'-'+col] = v3;
  //                         $this.closest('table').find('tr:eq('+row+') td:eq('+col+') input').val(v3);
  //                     });
  //                 });
  //             });
  //         }
  //     });

  // });
});

$(document).delegate(".table_del", "click", function (e) {
  $(this).parents("table").remove();
});

$(document).delegate(".table_re", "click", function (e) {
  $(this).parents("table").find("input").val("");
});

$(document).ready(function () {
  $(".mop_cus input:radio").click(function () {
    if ($(this).val() == "none") {
      $(".cus_que").hide();
    } else {
      $(".cus_que").show();
    }
  });
});

//만족도 테이블 반영 / 비반영

$(document).ready(function () {
  $(".attr-table input:radio").click(function () {
    if ($(this).val() == "table-not") {
      $(this).parents(".trtop").siblings(".tablew").find(".tr_tr").hide();
    } else {
      $(this).parents(".trtop").siblings(".tablew").find(".tr_tr").show();
    }
  });
});

//          서비스평가쿼리

$(document).ready(function () {
  $(document).delegate(".ser_add", "click", function (e) {
    var selength = $(".side_list").find("li.ui-selected").length;

    console.log(selength);

    if (selength > 1) {
      alert("1개의 문항만 추가 가능합니다.");
    } else {
      $(".que_l .item_serv.ui-selected")
        .clone()
        .appendTo($(this).parents(".ser_btn"));

      $(".side_list").find("li.ui-selected a").addClass("on");
      $(".side_list").find("li.ui-selected").addClass("appended");
      $(".side_list").find("li.ui-selected").removeClass("ui-selected");
      $(".side_list").find("li.selected-flag").removeClass("selected-flag");
    }
  });
});

$(document).on("click", ".ser_re", function () {
  $(this).parents().siblings(".ser_box").find("li").remove();
  $(".side_list").find("li.ui-selected a").removeClass("on");
  $(".que_l").find(".item_serv.ui-selected").removeClass("ui-selected");

  $(".side_list").find("li.appended a.on").removeClass("on");
  $(".side_list").find("li.appended").removeClass("appended");
  $(".side_list").find("li.selected-flag").removeClass("selected-flag");
});

$(document).delegate(".jib_bot", "click", function (e) {
  $(this).parents(".ser").clone().insertAfter($(this).parents(".ser"));
  $(this).parents(".ser").next().find(".item_serv").remove();
  var attach_count_1 = Number($("#attach_count_1").val());

  var $div = $('div[id^="jib_bot"]:last');
  var $div_select_p = $('div[id^="select_type_x_p"]:last');
  //var org_num = parseInt( $div.prop("id").match(/\d+/g), 10 );
  //var num = org_num+1;
  //alert(num);
  //var $klon_select_p = $div_select_p.prop('id', 'select_type_x_p'+num);

  var clonemax = 5;

  if ($(".ser").length >= clonemax) {
    $(".ser").eq(4).remove();
    alert("집단구분항목은 4개까지 입력가능합니다.");
  } else {
    $(".jib_bot").css("pointer-events", "inherit");
    attach_count_1 = attach_count_1 + 1;
    $("#attach_count_1").val(attach_count_1);
    var $klon = $div.prop("id", "jib_bot" + attach_count_1);
    var $klon_select_p = $div_select_p.prop(
      "id",
      "select_type_x_p" + attach_count_1
    );

    var bbsreplll = $(this).attr("id");
    //alert(bbsreplll);
    $("#" + bbsreplll + "").hide();
  }
});

$(document).delegate(".ser_del", "click", function (e) {
  $(this).parents(".ser").remove();
  $(".side_list").find("li.appended").removeClass("appended");

  var attach_count_1 = Number($("#attach_count_1").val());
  attach_count_1 = attach_count_1 - 1;
  if (attach_count_1 < 1) {
    attach_count_1 = 1;
  }
  $("#attach_count_1").val(attach_count_1);
  $("#jib_bot" + attach_count_1 + "").show();

  var itemids3 = $.makeArray(
    $(".main_dam1")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });
});

$(document).delegate(".rbl_add", "click", function (e) {
  $(".que_l .item_serv.ui-selected")
    .clone()
    .appendTo($(this).parents(".rwb_l").find(".mCSB_container"));

  $(".side_list").find("li.ui-selected a").addClass("on");
  $(".side_list").find("li.ui-selected").addClass("appended");
  $(".side_list").find("li.ui-selected").removeClass("ui-selected");
  $(".side_list").find("li.selected-flag").removeClass("selected-flag");

  var itemids = $.makeArray(
    $(this)
      .parents(".rwb_l")
      .find("li.item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  console.log(itemids);
});

$(document).delegate("span", "click", function () {
  var checkbox = $(this).find("input[type=checkbox]");
  checkbox.prop("checked", !checkbox.prop("checked"));

  $(this).toggleClass("checked");
});

$(document).on("click", ".rwb_bot", function () {
  $(this)
    .parents(".rwb_wrap")
    .clone()
    .insertAfter($(this).parents(".rwb_wrap"));
  $(this).parents(".rwb_wrap").next().find(".item_serv").remove();
  $(this).parents(".rwb_wrap").next().find("textarea").val("");
  $(this).parents(".rwb_wrap").next().find("input").val("");
  $(this).parents(".rwb_wrap").next().find("input").val("");
  $(this).parents(".rwb_wrap").next().find("span").removeClass("checked");
  $(this)
    .parents(".rwb_wrap")
    .next()
    .find(".content-rd")
    .children(".mCustomScrollBox")
    .remove();

  $(document).ready(function () {
    $(".content-rd").mCustomScrollbar({
      theme: "light-3",
    });
  });

  $(".dis_toggle").keyup(function () {
    $(".box_big input[type=text]").val($(this).val());
  });

  var bbsreplll = $(this).attr("id");
  $("#" + bbsreplll + "").hide();

  var $div = $('div[id^="rwb_bot"]:last');
  var $div_select_p = $('ul[id^="select_type_x_p"]:last');
  var $div_select_cnt = $('div[id^="select_quiz_cnt"]:last');
  var $div_add = $('button[id^="bb_add"]:last');

  var org_num = parseInt($div.prop("id").match(/\d+/g), 10);
  var num = org_num + 1;

  var $klon = $div.prop("id", "rwb_bot" + num);
  var $klon_select_p = $div_select_p.prop("id", "select_type_x_p" + num);
  var $klon_select_cnt = $div_select_cnt.prop("id", "select_quiz_cnt" + num);
  var $klon_add = $div_add.prop("id", "bb_add" + num);

  $("#select_quiz_cnt" + num + "").html("");

  var attach_count_1 = Number($("#attach_count_1").val());
  attach_count_1 = attach_count_1 + 1;
  $("#attach_count_1").val(attach_count_1);
});

$(document).on("click", ".rwb_bot1", function () {
  $(this)
    .parents(".rwb_wrap")
    .clone()
    .insertAfter($(this).parents(".rwb_wrap"));
  $(this).parents(".rwb_wrap").next().find(".item_serv").remove();
  $(this).parents(".rwb_wrap").next().find("textarea").val("");
  $(this).parents(".rwb_wrap").next().find("input").val("");
  $(this).parents(".rwb_wrap").next().find("input").val("");
  $(this).parents(".rwb_wrap").next().find("span").removeClass("checked");
  $(this)
    .parents(".rwb_wrap")
    .next()
    .find(".content-rd")
    .children(".mCustomScrollBox")
    .remove();

  $(document).ready(function () {
    $(".content-rd").mCustomScrollbar({
      theme: "light-3",
    });
  });

  $(".dis_toggle").keyup(function () {
    $(".box_big input[type=text]").val($(this).val());
  });

  var bbsreplll = $(this).attr("id");
  $("#" + bbsreplll + "").hide();

  var $div = $('div[id^="rwb_bot1"]:last');
  var $div_select_p = $('ul[id^="select_type_x1_p"]:last');
  var $div_select_cnt = $('div[id^="select_quiz1_cnt"]:last');
  var $div_add = $('button[id^="bb_add"]:last');

  //var org_num = parseInt( $div.prop("id").match(/\d+/g), 10 );
  //var num = org_num+1;
  var attach_count_1 = Number($("#attach_count_1").val());
  var org_num = Number($("#attach_count_1").val());
  attach_count_1 = attach_count_1 + 1;
  num = attach_count_1;

  var $klon = $div.prop("id", "rwb_bot1" + num);
  var $klon_select_p = $div_select_p.prop("id", "select_type_x1_p" + num);
  var $klon_select_cnt = $div_select_cnt.prop("id", "select_quiz1_cnt" + num);
  var $klon_add = $div_add.prop("id", "bb_add" + num);

  $("#select_quiz_cnt" + num + "").html("");
  $("#attach_count_1").val(attach_count_1);
});

$(document).on("click", ".rwb_bot2", function () {
  $(this)
    .parents(".rwb_wrap")
    .clone()
    .insertAfter($(this).parents(".rwb_wrap"));
  $(this).parents(".rwb_wrap").next().find(".item_serv").remove();
  $(this).parents(".rwb_wrap").next().find("textarea").val("");
  $(this).parents(".rwb_wrap").next().find("input").val("");
  $(this).parents(".rwb_wrap").next().find("input").val("");
  $(this).parents(".rwb_wrap").next().find("span").removeClass("checked");
  $(this)
    .parents(".rwb_wrap")
    .next()
    .find(".content-rd")
    .children(".mCustomScrollBox")
    .remove();

  $(document).ready(function () {
    $(".content-rd").mCustomScrollbar({
      theme: "light-3",
    });
  });

  $(".dis_toggle").keyup(function () {
    $(".box_big input[type=text]").val($(this).val());
  });

  var bbsreplll = $(this).attr("id");
  $("#" + bbsreplll + "").hide();

  var $div = $('div[id^="rwb_bot2"]:last');
  var $div_select_p = $('ul[id^="select_type_x2_p"]:last');
  var $div_select_cnt = $('div[id^="select_quiz2_cnt"]:last');
  var $div_add = $('button[id^="bb_add2"]:last');

  //var org_num = parseInt( $div.prop("id").match(/\d+/g), 10 );
  //var num = org_num+1;

  var attach_count_2 = Number($("#attach_count_2").val());
  var org_num = Number($("#attach_count_2").val());
  attach_count_2 = attach_count_2 + 1;
  var num = attach_count_2;

  var $klon = $div.prop("id", "rwb_bot2" + num);
  var $klon_select_p = $div_select_p.prop("id", "select_type_x2_p" + num);
  var $klon_select_cnt = $div_select_cnt.prop("id", "select_quiz2_cnt" + num);
  var $klon_add = $div_add.prop("id", "bb_add2" + num);

  $("#select_quiz2_cnt" + num + "").html("");
  $("#attach_count_2").val(attach_count_2);
});

$(document).on("click", ".rwb_bot3", function () {
  $(this)
    .parents(".rwb_wrap")
    .clone()
    .insertAfter($(this).parents(".rwb_wrap"));
  $(this).parents(".rwb_wrap").next().find(".item_serv").remove();
  $(this).parents(".rwb_wrap").next().find("textarea").val("");
  $(this).parents(".rwb_wrap").next().find("input").val("");
  $(this).parents(".rwb_wrap").next().find("input").val("");
  $(this).parents(".rwb_wrap").next().find("span").removeClass("checked");
  $(this)
    .parents(".rwb_wrap")
    .next()
    .find(".content-rd")
    .children(".mCustomScrollBox")
    .remove();

  $(document).ready(function () {
    $(".content-rd").mCustomScrollbar({
      theme: "light-3",
    });
  });

  $(".dis_toggle").keyup(function () {
    $(".box_big input[type=text]").val($(this).val());
  });

  var bbsreplll = $(this).attr("id");
  $("#" + bbsreplll + "").hide();

  var $div = $('div[id^="rwb_bot3"]:last');
  var $div_select_p = $('ul[id^="select_type_x3_p"]:last');
  var $div_select_cnt = $('div[id^="select_quiz3_cnt"]:last');
  var $div_add = $('button[id^="bb_add3"]:last');

  //var org_num = parseInt( $div.prop("id").match(/\d+/g), 10 );
  //var num = org_num+1;
  var attach_count_3 = Number($("#attach_count_3").val());
  var org_num = Number($("#attach_count_3").val());
  attach_count_3 = attach_count_3 + 1;
  var num = attach_count_3;

  var $klon = $div.prop("id", "rwb_bot3" + num);
  var $klon_select_p = $div_select_p.prop("id", "select_type_x3_p" + num);
  var $klon_select_cnt = $div_select_cnt.prop("id", "select_quiz3_cnt" + num);
  var $klon_add = $div_add.prop("id", "bb_add3" + num);

  $("#select_quiz3_cnt" + num + "").html("");
  $("#attach_count_3").val(attach_count_3);
});

$(document).on("click", ".rwb_bot4", function () {
  $(this)
    .parents(".rwb_wrap")
    .clone()
    .insertAfter($(this).parents(".rwb_wrap"));
  $(this).parents(".rwb_wrap").next().find(".item_serv").remove();
  $(this).parents(".rwb_wrap").next().find("textarea").val("");
  $(this).parents(".rwb_wrap").next().find("input").val("");
  $(this).parents(".rwb_wrap").next().find("input").val("");
  $(this).parents(".rwb_wrap").next().find("span").removeClass("checked");
  $(this)
    .parents(".rwb_wrap")
    .next()
    .find(".content-rd")
    .children(".mCustomScrollBox")
    .remove();

  $(document).ready(function () {
    $(".content-rd").mCustomScrollbar({
      theme: "light-3",
    });
  });

  $(".dis_toggle").keyup(function () {
    $(".box_big input[type=text]").val($(this).val());
  });

  var bbsreplll = $(this).attr("id");
  $("#" + bbsreplll + "").hide();

  var $div = $('div[id^="rwb_bot4"]:last');
  var $div_select_p = $('ul[id^="select_type_x4_p"]:last');
  var $div_select_cnt = $('div[id^="select_quiz4_cnt"]:last');
  var $div_add = $('button[id^="bb_add4"]:last');

  //var org_num = parseInt( $div.prop("id").match(/\d+/g), 10 );
  //var num = org_num+1;
  var attach_count_4 = Number($("#attach_count_4").val());
  var org_num = Number($("#attach_count_4").val());
  attach_count_4 = attach_count_4 + 1;
  var num = attach_count_4;

  var $klon = $div.prop("id", "rwb_bot4" + num);
  var $klon_select_p = $div_select_p.prop("id", "select_type_x4_p" + num);
  var $klon_select_cnt = $div_select_cnt.prop("id", "select_quiz4_cnt" + num);
  var $klon_add = $div_add.prop("id", "bb_add4" + num);

  $("#select_quiz4_cnt" + num + "").html("");
  $("#attach_count_4").val(attach_count_4);
});

$(document).on("click", ".rwg_bot", function () {
  $(this).prev(".rwg_wrap").clone().insertAfter($(this).prev(".rwg_wrap"));
  $(".content-rd").mCustomScrollbar({
    theme: "light-3",
  });

  $(this).prev(".rwg_wrap").find("input").val("");

  var attach_count_2 = Number($("#attach_count_2").val());
  attach_count_2 = attach_count_2 + 1;
  $("#attach_count_2").val(attach_count_2);
});

$(document).ready(function () {
  $(".dis_toggle2").keyup(function () {
    //$(this).parents(".s2_l").find('input[type=text]').val($(this).val());
  });
});

$(document).ready(function () {
  //$(".dis_toggle").prop('disabled', true);
  $("input[type=radio]").click(function () {
    if ($(this).prop("class") == "r2l_yes") {
      //$(this).siblings(".dis_toggle").prop("disabled", false);
    } else {
      //$(this).parents("span").siblings("span").find(".dis_toggle").prop("disabled", true);
      $(this).parents("span").siblings("span").find(".dis_toggle").val("");
      //$(".box_big input[type=text]").val("");
    }
  });
});

$(document).ready(function () {
  //$(".dis_toggle2").prop('disabled', true);
  $("input[type=radio]").click(function () {
    if ($(this).prop("class") == "r2l_yes") {
      //$(this).siblings(".dis_toggle2").prop("disabled", false);
    } else {
      //$(this).parents("span").siblings("span").find(".dis_toggle2").prop("disabled", true);
      $(this).parents("span").siblings("span").find(".dis_toggle2").val("");
      //$(".box_big input[type=text]").val("");
    }
  });
});

$(document).delegate(".rbl_add", "click", function (e) {
  $(".dis_toggle").keyup(function () {
    $(".box_big input[type=text]").val($(this).val());
  });

  $(this).parents(".rwb_wrap").find(".r_jong").removeClass("checked");
});

$(document).ready(function () {
  $(".dis_toggle2").keyup(function () {
    //$(this).parents(".s2_l").find('input[type=text]').val($(this).val());
  });

  $("#damyun_option_samept_1").keyup(function () {
    //$(".left_input_score").val($(this).val());
  });
});

$(document).ready(function () {
  //$(".rwg_input input").prop('disabled', true);
  $(".radio_2rt").click(function () {
    if ($(".radio_2rt span").prop("class") == "yes_no") {
      //$(".rwg_input input").prop("disabled", false);
    } else {
      //$(".rwg_input input").prop("disabled", true);
    }
  });
});

$(document).ready(function () {
  $(document).delegate(".r_jong", "click", function () {
    if ($(this).hasClass("checked")) {
      //$(this).parent('.rwb_c').siblings('.rwb_l').find(".jong_div").css('pointer-events',"none");
      //$(this).parent('.rwb_c').siblings('.rwb_l').find(".jong_div").removeClass('checked');
      //$(this).parent('.rwb_c').siblings('.rwb_l').find(".jong_div input").prop('checked',false);
    } else {
      //$(this).parent('.rwb_c').siblings('.rwb_l').find(".jong_div").css('pointer-events',"inherit");
    }
  });
});

$(document).delegate(".rwb_minus", "click", function () {
  $(this).parents(".rwb_wrap").remove();

  $(".side_list").find("li.appended").removeClass("appended");

  var itemids3 = $.makeArray(
    $(".main_ser")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });

  var itemids3 = $.makeArray(
    $(".main_dam")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });

  var attach_count_1 = Number($("#attach_count_1").val());
  attach_count_1 = attach_count_1 - 1;
  if (attach_count_1 < 1) {
    attach_count_1 = 1;
  }

  $("#attach_count_1").val(attach_count_1);
  $("#rwb_bot" + attach_count_1 + "").show();
});

$(document).delegate(".rwb_minus2", "click", function () {
  $(this).parents(".rwb_wrap").remove();

  $(".side_list").find("li.appended").removeClass("appended");

  var itemids3 = $.makeArray(
    $(".main_ser")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });

  var itemids3 = $.makeArray(
    $(".main_dam")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });

  var attach_count_2 = Number($("#attach_count_2").val());
  attach_count_2 = attach_count_2 - 1;
  if (attach_count_2 < 1) {
    attach_count_2 = 1;
  }

  $("#attach_count_2").val(attach_count_2);
  $("#rwb_bot2" + attach_count_2 + "").show();
});

$(document).delegate(".rwb_minus3", "click", function () {
  $(this).parents(".rwb_wrap").remove();

  $(".side_list").find("li.appended").removeClass("appended");

  var itemids3 = $.makeArray(
    $(".main_ser")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });

  var itemids3 = $.makeArray(
    $(".main_dam")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });

  var attach_count_3 = Number($("#attach_count_3").val());
  attach_count_3 = attach_count_3 - 1;
  if (attach_count_3 < 1) {
    attach_count_3 = 1;
  }

  $("#attach_count_3").val(attach_count_3);
  $("#rwb_bot3" + attach_count_3 + "").show();
});

$(document).delegate(".rwb_minus4", "click", function () {
  $(this).parents(".rwb_wrap").remove();

  $(".side_list").find("li.appended").removeClass("appended");

  var itemids3 = $.makeArray(
    $(".main_ser")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });

  var itemids3 = $.makeArray(
    $(".main_dam")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });

  var attach_count_4 = Number($("#attach_count_4").val());
  attach_count_4 = attach_count_4 - 1;
  if (attach_count_4 < 1) {
    attach_count_4 = 1;
  }

  $("#attach_count_4").val(attach_count_4);
  $("#rwb_bot4" + attach_count_4 + "").show();
});

$(document).delegate(".minus_rwg", "click", function () {
  $(this).parents(".rwg_wrap").remove();

  var attach_count_2 = Number($("#attach_count_2").val());
  attach_count_2 = attach_count_2 - 1;
  if (attach_count_2 < 1) {
    attach_count_2 = 1;
  }
  $("#attach_count_2").val(attach_count_2);
});

$(document).delegate(".minus_re", "click", function () {
  $(this).parents(".rwg_wrap").find("input").val("");
});

$(document).delegate(".da3_add", "click", function (e) {
  var selength = $(".side_list").find("li.ui-selected").length;

  console.log(selength);

  if (selength > 1) {
    alert("1개의 문항만 추가 가능합니다.");
  } else {
    $(".que_l .item_serv.ui-selected")
      .clone()
      .appendTo($(this).parent(".da3_btn"));

    $(".side_list").find("li.ui-selected a").addClass("on");
    $(".side_list").find("li.ui-selected").addClass("appended");
    $(".side_list").find("li.ui-selected").removeClass("ui-selected");
    $(".side_list").find("li.selected-flag").removeClass("selected-flag");
  }

  go_display_table();
});

$(document).ready(function () {
  $(".da3_table table input")
    .on("input", function () {
      var $tr = $(this).closest("tr"); // get tr which contains the input
      var tot = 0; // variable to sore sum
      $("input", $tr).each(function () {
        // iterate over inputs
        tot += Number($(this).val()) || 0; // parse and add value, if NaN then add 0
      });
      $("td:last", $tr).text(tot); // update last column value
    })
    .trigger("input"); // trigger input to set initial value in column
});

$(document).ready(function () {
  $(".da3 .icon_box input[type=radio]").prop("checked", true);
  $(".icon_box")
    .siblings(".da3_table")
    .children(".da3t_wrap")
    .css("display", "none");

  $(".da3 .icon_box input[type=radio]").click(function () {
    if ($(this).prop("class") == "da3_no") {
      var itemids3 = $.makeArray(
        $(".damy_mop")
          .find(".item_serv")
          .map(function () {
            return $(this).attr("id");
          })
      );

      $.each(itemids3, function () {
        $("#" + this).addClass("appended");
      });

      $(this).parents(".da3y_wrap2").siblings(".da3_btn").addClass("on");

      $(this)
        .parents(".icon_box")
        .siblings(".da3_table")
        .children(".da3t_wrap")
        .find(".score_da")
        .val("");
      $(this)
        .parents(".icon_box")
        .siblings(".da3_table")
        .children(".da3t_wrap")
        .find(".score_sum")
        .text("0");

      $(this)
        .parents(".icon_box")
        .siblings(".da3_table")
        .children(".da3t_wrap")
        .css("display", "none");

      $(".da3_btn").find("li").remove();
      $(".side_list").find("li.appended").removeClass("appended");
    } else {
      $(this).parents(".da3y_wrap").siblings(".da3_btn").removeClass("on");
      $(this)
        .parents(".icon_box")
        .siblings(".da3_table")
        .children(".da3t_wrap")
        .css("display", "block");
    }
  });
});

// 의사결정모델

$(document).delegate(".decp_add", "click", function (e) {
  $(".que_l .item_serv.ui-selected")
    .clone()
    .appendTo($(this).parent().siblings().children("ul"));

  $(".side_list").find("li.ui-selected a").addClass("on");
  $(".side_list").find("li.ui-selected").addClass("appended");
  $(".side_list").find("li.ui-selected").removeClass("ui-selected");
  $(".side_list").find("li.selected-flag").removeClass("selected-flag");
});

$(document).on("click", ".decp_re", function () {
  $(this).parents().siblings(".dec_box").find("li").remove();

  $(".side_list").find("li.appended").removeClass("appended");

  var itemids3 = $.makeArray(
    $(".main_flow")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });
});

$(document).delegate(".dec_min1", "click", function (e) {
  $(this).parents(".node").siblings("ol").remove();
  $(this).css("display", "none");
  $(this).siblings(".dec_add").css("display", "block");

  $(".side_list").find("li.appended").removeClass("appended");

  var itemids3 = $.makeArray(
    $(".main_dec2")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });

  var str_type_x_g = $("#select_type_x_g").html();
  $("#factor_no_x_g").val(str_type_x_g);
  $("#decision_2_frm").attr("action", "/report_bn/decision_2_child_action.php");
  $("#decision_2_frm").submit();
});

$(document).delegate(".dec_add1", "click", function (e) {
  var a = $("input[name='quiz_list']:checked").length;

  $("input[name='quiz_list']:checked").each(function() {
    console.log($(this).parent().find("label").text());
    $(this).parent().parent().addClass("ui-selected");
  });

  console.log(a);
  console.log($("label[for='"+$("input[name='quiz_list']:checked:eq(2)").attr("id")+"']").text());
  console.log(123123);

  let item_serv_array = [];
  let item_serv_string = "";
  for (let i = 0; i < a; i++) {
    /*
    item_serv_array[i] = $(".que_l .item_serv.ui-selected .overtext")[
      i
    ].innerHTML;
    item_serv_string +=
      $(".que_l .item_serv.ui-selected .overtext")[i].innerHTML + "_";
    */
    item_serv_array[i] = $("label[for='"+$("input[name='quiz_list']:checked:eq("+i+")").attr("id")+"']").text();
    item_serv_string += $("label[for='"+$("input[name='quiz_list']:checked:eq("+i+")").attr("id")+"']").text() + "_";
  }
  console.log(item_serv_array);
  let displayArr = item_serv_string.split("_");
  displayArr.pop();
  let displayArr2 = Array.from(new Set(displayArr));
  console.log(displayArr2);

  /*if( a != 1 && a != 3 && a != 6 && a != 9 && a != 10 ){
                
                alert('변수는 1개, 3개, 6개, 9개, 10개만 입력가능합니다.');*/
  if (a != 1 && a != 3 && a != 6 && a != 10 && a != 15 && a != 21 && a != 28) {
    alert("변수는 1개, 3개, 6개, 10개, 15개, 21개, 28개만 입력가능합니다.");
  } else {
    $(this).parents(".node").after("<ol></ol>");
    $(this).css("display", "none");
    $(this).siblings(".dec_min").css("display", "block");
    $("ol").addClass("children");
    /*
    $(".que_l .item_serv.ui-selected")
      .clone()
      .appendTo($(this).parents(".node").siblings(".children"));
    */

    $(".que_l")
    .find("input[name='quiz_list']:checked")
    .parent()
    .parent()
    .clone()
    .appendTo($(this).parents(".node").siblings(".children"));
    
    /*
      console.log('dec_add1 click');

      console.log('displayArr2 length => ' + displayArr2.length);
      console.log('displayArr2 => ' + displayArr2);
    */
    if (displayArr2.length > 3) {
      for (let i = a - 2; i > displayArr2.length - 2; i--) {
        console.log($("ol li")[i], i);
        $("ol").not(".confirmed").find("li")[i].style.display = "none";
      }
      for (let i = 0; i < displayArr2.length - 1; i++) {
        $("ol")
          .not(".confirmed")
          .find(".item_serv .node .dec_in")
          [i].setAttribute("placeholder", displayArr2[i]);
      }
      $("ol")
        .not(".confirmed")
        .find(".item_serv .node .dec_in")
        [a - 1].setAttribute(
          "placeholder",
          displayArr2[displayArr2.length - 1]
        );
    } else if (displayArr2.length == 3) {
      for (let i = 0; i < displayArr2.length - 1; i++) {
        $("ol")
          .not(".confirmed")
          .find(".item_serv .node .dec_in")[i]
          .setAttribute("placeholder", displayArr2[i]);
      }

      $("ol")
        .not(".confirmed")
        .find(".item_serv .node .dec_in")
        [a - 1].setAttribute(
          "placeholder",
          displayArr2[displayArr2.length - 1]
        );
    } else if (displayArr2.length == 2) {
      $(".que_l .item_serv.ui-selected")
        .clone()
        .appendTo($(this).parents(".node").siblings(".children"));
      $("ol")
        .not(".confirmed")
        .find(".item_serv .node .dec_in")[0]
        .setAttribute("placeholder", displayArr2[0]);
      $("ol")
        .not(".confirmed")
        .find(".item_serv .node .dec_in")[1]
        .setAttribute("placeholder", displayArr2[1]);
    }

    $("ol")
    .find(".item_serv .node .dec_in")
    .each(function() {
      console.log($(this).attr("name"));
      console.log($(this).attr("placeholder"));
      if($(this).attr("placeholder") == "" || $(this).attr("placeholder") == undefined) {
        console.log('remove');
        //$(this).parent().parent().remove();
      } else {
        $(this).val($(this).attr("placeholder"));
      }
    });

    console.log('aaa');

    $("ol").not(".confirmed").addClass("confirmed");
    $(".mindmap").find("li.item_serv").addClass("children__item");

    $(".mindmap").find(".node").removeClass("form-check");

    $("ul.selectable").removeClass("selectable");

    $(".side_list").find("li.ui-selected a").addClass("on");
    $(".side_list").find("li.ui-selected").addClass("appended");
    $(".side_list").find("li.ui-selected").removeClass("ui-selected");
    $(".side_list").find("li.selected-flag").removeClass("selected-flag");

    /* 2022 modify */
    /*
    $(".children").find(".item_serv .node .close").hide();
    $(".children").find("label").hide();
    $(".children").find(".score_div").hide();
    */
    $(".children").find("input[name='quiz_list']").remove();
    $(".children").find(".item_serv .node .close").addClass("displayNone");
    $(".children").find("label").addClass("displayNone");
    $(".children").find(".score_div").addClass("displayNone");

    $(".node_root").find(".node__text").css("display", "inline-flex");
    $(".node_root").find(".dec_in").css("display", "inline-flex");

    $(".children").find(".dec_bwrap").css("display", "inline-flex");
    
    $("input[name='quiz_list']").prop("checked", false);
    /* 2022 modify */

    var str_type_x_g = $("#select_type_x_g").html();
    $("#factor_no_x_g").val(str_type_x_g);
    $("#decision_2_frm").attr("action", "/report_bn/decision_2_child_action.php");
    $("#decision_2_frm").submit();
    
  }
});

$(document).delegate(".dec_add2", "click", function (e) {
  var b = $(".side_list").find("li.ui-selected").length;

  console.log(b);

  if (b != 1 && b != 3 && b != 9 && b != 10) {
    alert("변수는 1개, 3개, 9개, 10개만 입력가능합니다.");
  } else {
    $(this).parents(".node").after("<ol></ol>");
    $(this).css("display", "none");
    $(this).siblings(".dec_min").css("display", "block");
    $("ol").addClass("children");

    $(".que_l .item_serv.ui-selected")
      .clone()
      .appendTo($(this).parents(".node").siblings(".children"));

    $("ol li").addClass("children__item");
    var thisa = $(this).find(".dec_in").length();

    console.log(thisa);

    $(".main_dec2").find("li.item_serv").addClass("children__item");

    $(".side_list").find("li.ui-selected a").addClass("on");
    $(".side_list").find("li.ui-selected").addClass("appended");
    $(".side_list").find("li.ui-selected").removeClass("ui-selected");
    $(".side_list").find("li.selected-flag").removeClass("selected-flag");
  }
});

$(document).delegate(".dec_add3", "click", function (e) {
  $(".que_l .item_serv.ui-selected")
    .clone()
    .appendTo($(this).parents(".dec_btn").siblings(".dec_box"));

  $(".side_list").find("li.ui-selected a.on").removeClass("on");
  $(".side_list").find("li.ui-selected").addClass("appended");
  $(".side_list").find("li.ui-selected").addClass("reset");
  $(".side_list").find("li.ui-selected").removeClass("ui-selected");
  $(".side_list").find("li.selected-flag").removeClass("selected-flag");
});

$(document).delegate(".dec_re", "click", function (e) {
  $(this).parents().siblings(".dec_box").find("li").remove();
  $(".side_list").find("li.appended").removeClass("appended");

  var itemids3 = $.makeArray(
    $(".main_dec1")
      .find(".item_serv")
      .map(function () {
        return $(this).attr("id");
      })
  );

  $.each(itemids3, function () {
    $("#" + this).addClass("appended");
  });
});

// 가중치

function dWeight() {
  let vari = document.querySelectorAll(".y_wrap");
  let weight = document.querySelectorAll('.yo_num[placeholder="가중치%"]');
  for (let i = 0; i < weight.length; i++) {
    if (vari[i].innerText.length < 1) {
      weight[i].setAttribute("disabled", true);
      weight[i].value = "";
    } else {
      weight[i].removeAttribute("disabled");
    }
  }

  vari = document.querySelectorAll(
    ".children_leftbranch ul.box_big > .mCS-light-3.mCSB_inside > div.mCSB_container"
  );
  weight = document.querySelectorAll(".bwm_r.tabb4 input");
  for (let i = 0; i < weight.length; i++) {
    if (vari[i].innerText.length < 1) {
      weight[i].setAttribute("disabled", true);
      weight[i].value = "";
    } else {
      weight[i].removeAttribute("disabled");
    }
  }

  vari = document.querySelectorAll(".center_wrap .bwt_l .mCSB_container");
  weight = document.querySelectorAll(".center_ga.tabb4 input");
  for (let i = 0; i < weight.length; i++) {
    if (vari[i].innerText.length < 1) {
      weight[i].setAttribute("disabled", true);
      weight[i].value = "";
    } else {
      weight[i].removeAttribute("disabled");
    }
  }

  //   const weightInput = document.querySelectorAll('[placeholder="가중치%"]');
  //   for (let i = 0; i < weightInput.length; i++) {
  //     weightInput[i].addEventListener("keyup", function () {
  //       this.value = this.value.replace();
  //     });
  //   }
}

function yoso() {
  let vari = document.querySelectorAll(".y_wrap");
  let weight = document.querySelectorAll('.yo_num[placeholder="가중치%"]');
  let flag = 0;
  for (let i = 0; i < weight.length; i++) {
    if (vari[i].innerText.length > 0 && weight[i].value > 0) {
    } else if (vari[i].innerText.length > 0 && weight[i].value <= 0) {
      //alert("요소만족도의 가중치값을 입력해주세요.");
      //return false;
    }
  }
  return true;
}

dWeight();
