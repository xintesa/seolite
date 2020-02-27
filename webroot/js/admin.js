SeoLite = {}

SeoLite.analyze = function (e) {
  e && e.preventDefault();
  var url = e.currentTarget.attributes['href'].value;

  if (typeof e.currentTarget.attributes['data-id'] == 'undefined') {
    return alert('Please save/apply your data first');
  }

  $('.nav [href="#node-seolite"]').tab('show');

  var $keywords = $('#seo-lite-meta-keywords-value');
  var $description = $('[data-metafield=meta_description]');

  if ($keywords.length > 0 && $keywords.val().length > 0 || $description.val().length > 0) {
    if (!confirm('Replace existing keywords and description?')) {
      return false;
    }
  }
  $.getJSON(url, null, function (data, textStatus) {
    $('[href$="seo"][data-toggle="tab"]').tab('show');
    setTimeout(function() {
        $keywords.val(data.keywords.split(',').join(', '));
        $description.val(data.description);
    }, 250);
  });
  return false;
};

$(function () {
  $('body').on('click', 'a[data-toggle=seo-lite-analyze]', SeoLite.analyze);
});
