
var ratio = document.getElementsByName("filter-way");
var inputs = document.getElementsByName('filter-input');
var btn = document.getElementById('submit');
ratioBound(0);
ratioBound(1);
btn.onclick = function(){

}
function ratioBound(i){
    ratio.item(i).onclick = function(){
        inputs.item(i).required = 'required';
        inputs.item(i).disabled = null;
        inputs.item(1-i).required = null;
        inputs.item((1-i)).disabled = 'disabled';
    }
}
