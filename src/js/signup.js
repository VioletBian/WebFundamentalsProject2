$(function(){

    $("#sub").click(function(){

        var pwd = $("input[name='password']").val();

        var cpwd = $("input[name='confirm_password']").val();
        if(pwd != cpwd){
            alert("两次密码不一致!");
            $("input[name='password']").val("");
            $("input[name='confirm_password']").val("");
            return false;
        }
    });


});
function fnCreateAlert(msg,trueOrFalse){
    var className="";
    if(trueOrFalse){
        className="toast-success";
    }else{
        className="toast-warning";
    }
    var oDiv = $('<div></div>');
    oDiv.addClass('toast-top-right');
    oDiv.addClass('tip');
    oDiv.attr({
        id:'toast-top-right',
        'aria-live':'polite',
        role:'alert'
    });
    oDiv.html('<div class="toast '+className+'" style="display: block;border-radius: 5px;">'+
        '<div class="toast-title">Tip</div>'+
        '<div class="toast-message">'+msg+'</div>'+
        '</div>');
    oDiv.css('top','-80px');
    oDiv.animate({top:12},1000,function(){
        setTimeout(function(){
            oDiv.animate({opacity:0},800,function(){
                oDiv.remove();
            });
        },1000);
    });
    // $('body').append(oDiv)
    oDiv.insertBefore($('#signup_form'));
}

window.onload = function () {

    // document.getElementById("password").addEventListener("blur",isSecurity(this.value));
    document.getElementById("password").addEventListener("blur",function () {
        console.log(this.value);
        isSecurity(this.value)

    });

}
var f = function (v) {
    return document.getElementById(v)

}
var iss = {
    color:["CC0000","FFCC33","66CC00","CCCCCC"],
    text:["弱","中","强"],
    width:["50","100","150","10"],
    reset:function(){
        f("B").style.backgroundColor = iss.color[3];
        f("B").style.width = iss.width[3];
        f("A").innerHTML = "Verifying...";
    },
    level0:function(){
        f("B").style.backgroundColor = iss.color[0];
        f("B").style.width = iss.width[0];
        f("A").innerHTML = "Weak";
    },
    level1:function(){
        f("B").style.backgroundColor = iss.color[1];
        f("B").style.width = iss.width[1];
        f("A").innerHTML = "Medium";
    },
    level2:function(){
        f("B").style.backgroundColor = iss.color[2];
        f("B").style.width = iss.width[2];
        f("A").innerHTML = "Strong";
    }
}
function isSecurity(v){
    if (v.length < 3) { iss.reset();return;}
    var lv = -1;
    if (v.match(/[a-z]/ig)){lv++;}
    if (v.match(/[0-9]/ig)){lv++;}
    if (v.match(/(.[^a-z0-9])/ig)){lv++;}
    if (v.length < 4 && lv > 0){lv++;}
    iss.reset();
    switch(lv) {
        case 0:
            iss.level0();
            break;
        case 1:
            iss.level1();
            break;
        case 2:
            iss.level2();
            break;
        default:
            iss.reset();
    }
}