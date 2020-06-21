var float_button = new Vue({
    el:"#float_button",
    template: '<div class="float-button" id="float-button"><ul><li><a id="to-top" onClick="gotoTop(0.01,3);return false;"><svg t="1584781732672" class="icon" width="40px" height="40px" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2517"><path d="M511.5648 358.4a12.7616 12.7616 0 0 0-9.6 3.8784L355.584 512.9088a12.8 12.8 0 1 0 18.368 17.8432L499.2 401.856V729.6a12.8 12.8 0 0 0 25.6 0V400.512l120.768 126.8736a12.8 12.8 0 1 0 18.5472-17.6512l-140.288-147.3536a12.7744 12.7744 0 0 0-10.5472-3.9168 12.9536 12.9536 0 0 0-1.7152-0.0512zM512 1024C229.2352 1024 0 794.7648 0 512S229.2352 0 512 0s512 229.2352 512 512-229.2352 512-512 512zM320 320h384a12.8 12.8 0 0 0 0-25.6H320a12.8 12.8 0 0 0 0 25.6z" p-id="2518"></path></svg></a></li><li><a id="refresh" href="/src/php/Display/refresh.php"><svg t="1584780765904" class="icon" width="40px" height="40px" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5497"><path d="M802.909091 542.254545c-13.963636 0-23.272727-9.309091-23.272727-23.272727 0-153.6-125.672727-279.272727-279.272728-279.272727-83.781818 0-160.581818 37.236364-214.109091 100.072727-9.309091 9.309091-23.272727 11.636364-32.581818 2.327273-9.309091-9.309091-11.636364-23.272727-2.327272-32.581818 62.836364-74.472727 153.6-116.363636 249.018181-116.363637 179.2 0 325.818182 146.618182 325.818182 325.818182 0 13.963636-11.636364 23.272727-23.272727 23.272727z" p-id="5498"></path><path d="M786.618182 574.836364l-44.218182-76.8c-9.309091-16.290909 2.327273-34.909091 20.945455-34.909091h88.436363c18.618182 0 30.254545 18.618182 20.945455 34.909091l-44.218182 76.8c-11.636364 13.963636-32.581818 13.963636-41.890909 0z" p-id="5499"></path><path d="M197.818182 421.236364l-44.218182 76.8c-9.309091 16.290909 2.327273 34.909091 20.945455 34.909091h88.436363c18.618182 0 30.254545-18.618182 20.945455-34.909091l-44.218182-76.8c-11.636364-16.290909-32.581818-16.290909-41.890909 0z" p-id="5500"></path><path d="M532.945455 828.509091c-179.2 0-325.818182-146.618182-325.818182-325.818182 0-13.963636 9.309091-23.272727 23.272727-23.272727s23.272727 9.309091 23.272727 23.272727c0 153.6 125.672727 279.272727 279.272728 279.272727 83.781818 0 160.581818-37.236364 214.10909-100.072727 9.309091-9.309091 23.272727-11.636364 32.581819-2.327273 9.309091 9.309091 11.636364 23.272727 2.327272 32.581819-60.509091 74.472727-151.272727 116.363636-249.018181 116.363636z" p-id="5501"></path><path d="M512 1024C230.4 1024 0 793.6 0 512S230.4 0 512 0s512 230.4 512 512-230.4 512-512 512z m0-972.8C258.327273 51.2 51.2 258.327273 51.2 512S258.327273 972.8 512 972.8 972.8 765.672727 972.8 512 765.672727 51.2 512 51.2z" p-id="5502"></path></svg></a></li></ul></div>'

});


// 置顶悬浮按钮的过渡置顶作用
function gotoTop(acceleration, stime) {
    acceleration = acceleration || 0.1;
    stime = stime || 10;
    var x1 = 0;
    var y1 = 0;
    var x2 = 0;
    var y2 = 0;
    var x3 = 0;
    var y3 = 0;
    if (document.documentElement) {
        x1 = document.documentElement.scrollLeft || 0;
        y1 = document.documentElement.scrollTop || 0;
    }
    if (document.body) {
        x2 = document.body.scrollLeft || 0;
        y2 = document.body.scrollTop || 0;
    }
    var x3 = window.scrollX || 0;
    var y3 = window.scrollY || 0;

    var x = Math.max(x1, Math.max(x2, x3));
    var y = Math.max(y1, Math.max(y2, y3));

    var speeding = 1 + acceleration;
    window.scrollTo(Math.floor(x / speeding), Math.floor(y / speeding));

    if (x > 0 || y > 0) {
        var run = "gotoTop(" + acceleration + ", " + stime + ")";
        window.setTimeout(run, stime);
    };

    return false;
}

