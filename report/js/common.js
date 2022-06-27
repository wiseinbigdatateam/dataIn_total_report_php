$(document).ready(function() {
    var currentPosition = parseInt($("#list").css("top"));
    $(window).scroll(function() {
        var position = $(window).scrollTop();
        $("#list").stop().animate({ "top": position + currentPosition + "px" }, 800);

        if ($(document).scrollTop() > 50) {
            $('.sec_title2').css("top", "40px");
            $('.sec_title3').css("top", "80px");
        };
    });
})

function setList(listId, listUrl, listParam) {
    $.post(listUrl, listParam, function(data) {
        $("#" + listId).html(data);
    });
    return false;
}

function goUrl(url) {
    document.location = url;
}

function fnScrollTop(sec) {
    var section = document.getElementById(sec).offsetTop;
    window.scrollTo({ top: section, behavior: 'smooth' });
}

//의사결정모델 노드 추가하는 스크립트
function addNode(element) {
    var id = 0;
    var depthLimit = 4;

    var query = 'input[name="quiz_list"]:checked';
    var selectedEls = document.querySelectorAll(query);
    var elementId = element.id;
    var newElementId = elementId + '_' + id;
    var depth = (elementId.match(/_/g) || []).length;
    id++;
    var element_ol = document.getElementById("children_" + elementId);

    if (selectedEls.length == 0) {
        console.log("문항리스트를 선택해주세요.");
    } else {
        if (element_ol == null) {
            var addedOl = document.createElement("ol");
            addedOl.setAttribute("id", "children_" + elementId);
            addedOl.setAttribute("class", "children children_rightbranch");
            var element_target = "";
            if (depth == 0) {
                element_target = document.getElementById("mindmapId");
            } else {
                element_target = document.getElementById("li_" + elementId);
            }
            element_target.appendChild(addedOl);
            element_ol = addedOl;
        }
        depth++;

        selectedEls.forEach((el) => {
            var str = '<button type="button" onclick="deleteNode(this)" id=' + newElementId + '>-</button>';
            str += '<div class="node"><div class="node__text">' + newElementId + el.value + '</div>';
            str += '<input type="text" class="node__input"></div>';
            id++;

            console.log(newElementId);

            if (depth != depthLimit) {
                str += '<button type="button" onclick="addNode(this)" id =' + newElementId + '>+</button>';
            }
            var addedDiv = document.createElement("li");
            addedDiv.setAttribute("id", "li_" + newElementId);
            addedDiv.setAttribute("class", "children__item")
            addedDiv.innerHTML = str;
            element_ol.appendChild(addedDiv);

            var inp = document.getElementsByTagName("input");
            for (var i = 0; i < inp.length; i++) {
                if (inp[i].type == 'checkbox') {
                    inp[i].checked = false;
                }
            }

        });
    }
}

//체크박스 전체해제하는 스크립트
function cancleAll() {
    var checkboxes = document.getElementsByName('quiz_list');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
    }
};

//집단구분항목 추가하는 버튼
function addGroup(element) {
    var addedTr = document.createElement("tr");
    var str = '<td>';
    str += '<div className="input-group">';
    str += '<span className="input-group-text w130 m10 border-right"> 집단구분항목</span>';
    str += '<input type="text" className="form-control input-border w300" placeholder="문항리스트에서 추가하세요" readOnly/>';
    str += '<button className="btn-secondary btn-plus">+</button>';
    str += '<button className="btn-outline-secondary btn-minus">-</button>';
    str += '</div>';
    str += '</td>';
    addedTr.appendChild(str);
};