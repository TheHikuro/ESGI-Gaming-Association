$(function() {
    window.SelectCategory = function(id) {
        //hide not selected divs
        $(document.getElementById('panel')).children('div').map(function() { if(this.id != id){ $(this).addClass('hidden') } });
        //show selected div
        $(document.getElementById(id)).removeClass('hidden');
    }
});