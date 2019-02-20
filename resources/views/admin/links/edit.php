<?php $view->layout() ?>

<div class="page-header">
  <h1>
    导航管理
  </h1>
</div>
<!-- /.page-header -->

<div class="row">
  <div class="col-12">
    <form class="form-horizontal" id="links-form" role="form" method="post">
      <?php if ($link['parentId']) : ?>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="parent-id">
            父链接
          </label>

          <div class="col-lg-4">
            <p class="form-control-static"><?= $link->getParentLink()->get('name') ?></p>
            <input type="hidden" id="parent-id" name="parentId">
          </div>
        </div>
      <?php endif ?>

      <div class="js-group-type form-group display-none">
        <label class="col-lg-2 control-label" for="type">
          类型
        </label>

        <div class="col-lg-6">
          <label class="radio-inline">
            <input type="radio" name="type" class="js-type type" id="type1" value="1"> 链接
          </label>
          <label class="radio-inline">
            <input type="radio" name="type" class="js-type type" id="type2" value="2"> 分隔线
          </label>
        </div>
      </div>

      <div class="js-links-group">
        <div class="form-group">
          <label class="col-lg-2 control-label" for="name">
            <span class="text-warning">*</span>
            名称
          </label>

          <div class="col-lg-4">
            <input type="text" class="form-control" name="name" id="name" data-rule-required="true">
          </div>
        </div>

        <?php if (!$link['parentId']) : ?>
          <div class="js-group-icons form-group display-none">
            <label class="col-lg-2 control-label" for="icon">
              图标类型
            </label>

            <div class="col-lg-6">
              <label class="radio-inline">
                <input type="radio" name="icon" class="js-icon icon" id="icon1" value="image"> 图片
              </label>
              <label class="radio-inline">
                <input type="radio" name="icon" class="js-icon icon" id="icon2" value="font"> 系统图标
              </label>
              <label class="radio-inline">
                <input type="radio" name="icon" class="js-icon icon" id="icon3" value="custom-font"> 自定义图标
              </label>
            </div>
          </div>

          <div class="js-group-icon js-icon-image form-group display-none">
            <label class="col-lg-2 control-label" for="image">
              初始状态的图片
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" id="image" name="image">
            </div>
            <label class="col-lg-6 help-text" for="image">
              高度和宽度1:1
            </label>
          </div>

          <div class="js-group-icon js-icon-image form-group display-none">
            <label class="col-lg-2 control-label" for="active-image">
              被激活时的图片
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" id="active-image" name="activeImage">
            </div>
            <label class="col-lg-6 help-text" for="active-image">
              高度和宽度1:1
            </label>
          </div>

          <div class="js-group-icon js-icon-font form-group display-none">
            <label class="col-lg-2 control-label" for="font">
              系统图标
            </label>

            <div class="col-lg-4">
              <button class="btn btn-default" type="button" id="icon-picker"></button>
              <input type="hidden" class="form-control" name="font" id="font">
            </div>
          </div>

          <div class="js-group-icon js-icon-custom-font form-group display-none">
            <label class="col-lg-2 control-label" for="custom-font">
              自定义图标
            </label>

            <div class="col-lg-4">
              <input type="text" class="form-control" name="customFont" id="custom-font">
            </div>

            <label class="col-lg-6 help-text" for="custom-font">
              支持<a href="http://www.iconfont.cn/" target="_blank">iconfont</a>,如需使用,请联系开发人员
            </label>
          </div>

          <div class="js-group-bg-color form-group display-none">
            <label for="bg-color" class="col-sm-2 control-label">背景颜色</label>

            <div class="col-sm-4">
              <input type="text" class="js-bg-color form-control" name="bgColor" id="bg-color">
            </div>
          </div>

          <div class="js-group-display form-group display-none">
            <label class="col-lg-2 control-label" for="display">
              显示
            </label>

            <div class="col-lg-4">
              <select class="form-control" name="display" id="display">
                <option value="all">图标和文字</option>
                <option value="icon">图标</option>
                <option value="text">文字</option>
              </select>
            </div>
          </div>

          <div class="js-group-description form-group display-none">
            <label class="col-lg-2 control-label" for="description">
              描述
            </label>

            <div class="col-lg-4">
              <textarea class="form-control" name="description" id="description"></textarea>
            </div>
          </div>

          <div class="js-group-side form-group display-none">
            <label class="col-lg-2 control-label" for="side">
              位置
            </label>

            <div class="col-lg-4">
              <select class="form-control" name="side" id="side">
                <option value="left">左边</option>
                <option value="right">右边</option>
              </select>
            </div>
          </div>
        <?php endif ?>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="link-to">
            链接到
          </label>

          <div class="col-lg-4">
            <p class="form-control-static" id="link-to"></p>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="sort">
          <span class="text-warning">*</span>
          顺序
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="sort" id="sort">
        </div>
      </div>

      <input type="hidden" name="id" id="id">
      <input type="hidden" name="navId" id="nav-id">

      <div class="clearfix form-actions form-group">
        <div class="offset-lg-2">
          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>
          &nbsp; &nbsp; &nbsp;
          <a class="btn btn-default" href="<?= $url('admin/navs/%s/links', $link['navId']) ?>">
            <i class="fa fa-undo bigger-110"></i>
            返回列表
          </a>
        </div>
      </div>
    </form>
  </div>
</div>

<?= $block->js() ?>
<script>
  require(['plugins/link-to/js/link-to', 'plugins/app/js/validation', 'form',
    'ueditor',
    'plugins/admin/js/spectrum',
    'comps/bootstrap-iconpicker/bootstrap-iconpicker/js/bootstrap-iconpicker.min',
    'css!comps/bootstrap-iconpicker/bootstrap-iconpicker/css/bootstrap-iconpicker.min',
    'css!plugins/nav/css/navs',
    'plugins/admin/js/image-upload'
  ], function (linkTo) {
    // 显示支持的输入框
    var supports = <?= json_encode($type['supports']) ?>;
    $.each(supports, function (key, field) {
      $('.js-group-' + field).show();
    });

    var link = <?= $link->toJson() ?>;
    var navId = <?= $link['navId'] ?: (int) $req['navId'] ?>;
    $('#links-form')
      .loadJSON(link)
      .ajaxForm({
        url: $.url('admin/navs/%s/links?_method=' + (link.id ? 'put' : 'post'), navId),
        dataType: 'json',
        beforeSubmit: function (arr, $form, options) {
          return $form.valid();
        },
        success: function (ret) {
          $.msg(ret, function () {
            if (ret.code > 0) {
              window.location = $.url('admin/navs/%s/links', <?= $link['navId'] ?>);
            }
          });
        }
      })
      .validate();

    $('.js-bg-color').spectrum();

    // 选择类型
    function changeType() {
      if ($('.js-type:checked').val() == '1') {
        $('.js-links-group').show();
      } else {
        $('.js-links-group').hide();
      }
    }

    $('.js-type').change(changeType);
    changeType();

    // 选择图标
    function changeIcon() {
      $('.js-group-icon').hide();
      if ($('.js-group-icons').css("display") != 'none') {
        $('.js-icon-' + $('.js-icon:checked').val()).show();
      }
    }

    $('.js-icon').change(changeIcon);
    changeIcon();

    // 图标选择器
    $('#icon-picker').iconpicker({
      arrowClass: 'btn-default',
      arrowPrevIconClass: 'fa fa-angle-left',
      arrowNextIconClass: 'fa fa-angle-right',
      cols: 5,
      icon: $('#font').val(),
      iconset: {
        iconClass: '',
        iconClassFix: '',
        icons: [
          'ni ni-list', 'ni ni-list-2', 'ni ni-list-3', 'ni ni-list-4',
          'ni ni-list-search', 'ni ni-cart', 'ni ni-left', 'ni ni-phone',
          'ni ni-user', 'ni ni-users', 'ni ni-gift', 'ni ni-coupon',
          'ni ni-coins', 'ni ni-wallet', 'ni ni-home', 'ni ni-gear',
          'ni ni-marker', 'ni ni-dist', 'ni ni-question', 'ni ni-search'
        ]
      },
      labelHeader: '{0} / {1} 页',
      labelFooter: '{0} - {1} ，共 {2} 个图标',
      placement: 'bottom',
      rows: 5,
      search: false,
      searchText: '搜索',
      selectedClass: 'btn-success',
      unselectedClass: 'btn-default'
    }).on('change', function (e) {
      $('#font').val(e.icon);
    });

    linkTo.init({
      $el: $('#link-to'),
      data: link.linkTo,
      display: {
        none: true,
        url: true,
        site: true,
        photo: true,
        mall: true,
        act: true,
        browser: true,
        tel: true
      }
    });

    $('#image').imageUpload();
    $('#active-image').imageUpload();
  });
</script>
<?= $block->end() ?>

<?php require $view->getFile('@link-to/link-to/link-to.php') ?>
