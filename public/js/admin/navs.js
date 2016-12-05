define([], function () {
  var Navs = function () {
    // do something
  };

  $.extend(Navs.prototype, {
    $el: $('#navs-form'),
    data: [],
    $: function (selector) {
      return this.$el.find(selector);
    },
    edit: function (options) {
      $.extend(this, options);

      this.$el
        .loadJSON(this.data)
        .ajaxForm({
          url: $.url('admin/navs?_method=' + (this.data.id ? 'put' : 'post')),
          dataType: 'json',
          beforeSubmit: function (arr, $form) {
            return $form.valid();
          },
          success: function (ret) {
            $.msg(ret, function () {
              if (ret.code > 0) {
                window.location = $.url('admin/navs');
              }
            });
          }
        })
        .validate();

      this.$('#color, #active-color, #bg-color').spectrum();
    }
  });

  return new Navs();
});
