SeoLite = {}

SeoLite.analyze = function(e) {
	e && e.preventDefault();
	var url = e.currentTarget.attributes['href'].value;

	if (typeof e.currentTarget.attributes['data-id'] == 'undefined') {
		return alert('Please save/apply your data first');
	}

	$('.nav [href="#node-seolite"]').tab('show');

	var $keywords = $('#SeoLiteMetaKeywordsValue');
	var $description = $('#SeoLiteMetaDescriptionValue');

	if ($keywords.val().length > 0 || $description.val().length > 0) {
		if (!confirm('Replace existing keywords and description?')) {
			return false;
		}
	}
	$.getJSON(url, null, function(data, textStatus) {
		$keywords.val(data.keywords.split(',').join(', '));
		$description.val(data.description);
	});
	return false;
};

$(function() {
	$('body').on('click', 'a[data-toggle=seo-lite-analyze]', SeoLite.analyze);
});
