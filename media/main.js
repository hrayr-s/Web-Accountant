
jQuery(document).ready(function(){
	jQuery(".nav > div > a").click(function(){
		return navigation(this);;
	});
});
function navigation(item) {
	if(jQuery(item).attr("data-ajax")==0)
		return true;
	jQuery(".nav").addClass("menu");
	var url = jQuery(item).attr("href");
	jQuery.ajax({
  url: url,
  cache: false,
  data: {returnDatatype:"ajax"}
}).done(function( data ) {
    jQuery( "#content" ).slideUp(500).addClass("bord").queue(function(){ jQuery(this).html(data).slideDown(500);$(this).dequeue();});
  });
	return false;
}
function loading() {
	jQuery("#content").addClass("loading");
}