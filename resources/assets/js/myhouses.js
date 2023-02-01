$(document.body).on("mouseenter", ".myhouses li", function(a) {
	// $(this).find('.remove').css('visibility', 'visible');
	// $('.remove-house').css('width', ($('.edit-house').width() + 27)+'px');
})
 .on("mouseleave", ".myhouses li", function() {
	// $(this).find('.remove').css('visibility', 'hidden');
 });

$(document.body).on("click", ".remove-house-", function(a) {
	var r = confirm("آیااطمینان دارید این آگهی حذف شود؟");
	if (r == true) {
	    window.location.href=this.id;
	}
});