var urlQuery = getQueryString("login");
function getQueryString(name) {
    var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
    var r = window.location.search.substr(1).match(reg);
    if (r != null) {
        console.log(r);
        return unescape(r[2]);
    }
    return null;
}
console.log(urlQuery);
var pass = document.getElementById("id_password");
var user = document.getElementById("id_username");
if (urlQuery == "wrongpass"){
    pass.style.border = "2px solid rgba(218, 12, 12, 0.822)";
    pass.placeholder = "乂(ﾟДﾟ三ﾟДﾟ)乂 Wrong password!";
    fnCreateAlert("Wrong password",false);
}
if (urlQuery == 'wronguser'){
    user.style.border = "2px solid rgba(218, 12, 12, 0.822)";
    user.placeholder = "Σ（ﾟдﾟlll）?? User even do not exist?"
    fnCreateAlert("User nonexist",false);

}


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
    oDiv.html('<div class="toast '+className+'" style="display: block;border-radius: 5px;background-color: #cb402a">'+
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
    oDiv.insertBefore($('#login_form'));
}
