define([], function () {
  var Navs = function () {

  };

  $.extend(Navs.prototype, {
    $el: $('#navsForm'),
    data: [],
    $: function (selector) {
      return this.$el.find(selector);
    },
    edit: function (options) {
      var self = this;
      $.extend(this, options);

      this.$el
        .loadJSON(this.data)
        .ajaxForm({
          url: $.url('admin/navs?_method=' + (this.data.id ? 'put' : 'post')),
          dataType: 'json',
          beforeSubmit: function (arr, $form, options) {
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

      this.$('#color, #activeColor, #bgColor').spectrum();
    }
  });

  return new Navs();
});
