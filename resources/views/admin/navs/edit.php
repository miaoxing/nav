<?php $view->layout() ?>

<div class="page-header">
  <h1>
    导航管理
  </h1>
</div>
<!-- /.page-header -->

<div class="row">
  <div class="col-xs-12">
    <form class="form-horizontal" id="navs-form" role="form" method="post">
      <div class="form-group">
        <label for="color" class="col-sm-2 control-label">文字颜色</label>

        <div class="col-sm-4">
          <input type="text" class="form-control" name="color" id="color" data-rule-required="true">
        </div>
      </div>

      <div class="form-group">
        <label for="active-color" class="col-sm-2 control-label">文字激活时颜色</label>

        <div class="col-sm-4">
          <input type="text" class="form-control" name="activeColor" id="active-color">
        </div>
      </div>

      <div class="form-group">
        <label for="bg-color" class="col-sm-2 control-label">背景颜色</label>

        <div class="col-sm-4">
          <input type="text" class="form-control" name="bgColor" id="bg-color" data-rule-required="true">
        </div>
      </div>

      <input type="hidden" name="id" id="id">

      <div class="clearfix form-actions form-group">
        <div class="col-lg-offset-2">
          <button class="btn btn-info" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>
          &nbsp; &nbsp; &nbsp;
          <a class="btn" href="<?= $url('admin/navs') ?>">
            <i class="fa fa-undo bigger-110"></i>
            返回列表
          </a>
        </div>
      </div>
    </form>
  </div>
</div>

<?= $block('js') ?>
<script>
  require([
    'plugins/nav/js/admin/navs',
    'linkTo',
    'assets/spectrum',
    'validator',
    'form'], function (navs, linkTo) {
    navs.edit({
      data: <?= $nav->toJson() ?>,
      linkTo: linkTo
    });
  });
</script>
<?= $block->end() ?>

<script type="text/html" id="nav-color-tpl">
  <style type="text/css">
    .link-icon {
      background-color: <% = backgroundColor% >
    }

    .link-icon i {
      color: <% = color% >;
    }
  </style>
</script>

<script type="text/html" id="sort-col-tpl">
  <%= sort %><!-- 让DataTables正常排序 -->
  <input type="hidden" name="links[<%= id %>][sort]" value="<%= sort %>">
</script>

<script type="text/html" id="icon-col-tpl">
  <a href="javascript:;" title="更换图标" class="link-icon">
    <% if (image) { %>
    <span class="helper"></span><img src="<%= image %>">
    <% } else { %>
    <i class="fa <%= icon %>"></i>
    <% } %>
  </a>
  <input type="hidden" name="links[<%= id %>][image]" class="link-image" value="<%= image %>">
  <input type="hidden" name="links[<%= id %>][icon]" value="<%= icon %>">
</script>

<script type="text/html" id="label-col-tpl">
  <input type="text" name="links[<%= id %>][label]" style="width: 160px" value="<%= label %>" data-rule-maxlength="5">
</script>

<script type="text/html" id="link-to-col-tpl">
  <!-- 因为dataTable渲染字段不支持返回jQuery元素,所以将一些选项放到data中 -->
  <div class="set-link-to" data-name="links[<%= id %>][linkTo]" data-data="<%= linkToData %>"></div>
</script>

<script type="text/html" id="actions-col-tpl">
  <input type="hidden" name="links[<%= id %>][id]" value="<%= id %>">
  <div class="action-buttons">
    <a href="javascript:;" class="text-danger delete-record" title="删除">
      <i class="fa fa-trash-o bigger-130"></i>
    </a>
  </div>
</script>

<?php require $view->getFile('@link-to/link-to/link-to.php') ?>
