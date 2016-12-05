<?php $view->layout() ?>

<div class="page-header">
  <div class="pull-right">
    <a class="btn btn-success" href="<?= $url('admin/navs/%s/links/new', $req['navId']) ?>">添加链接</a>
    <a class="btn btn-white" href="<?= $url('admin/navs') ?>">返回导航列表</a>
  </div>
  <h1>
    导航管理
    <small>
      <i class="fa fa-angle-double-right"></i>
      链接列表
    </small>
  </h1>
</div>
<!-- /.page-header -->

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">
      <table id="nav-table" class="table table-bordered table-hover">
        <thead>
        <tr>
          <th>名称</th>
          <th>链接到</th>
          <?php if (in_array('side', $type['supports'])) : ?>
            <th class="t-6">位置</th>
          <?php endif ?>
          <th class="t-6">顺序</th>
          <th class="t-10">操作</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!-- /.table-responsive -->
    <!-- PAGE CONTENT ENDS -->
  </div>
  <!-- /col -->
</div>
<!-- /row -->

<?php require $view->getFile('@link-to/link-to/link-to.php') ?>

<?= $block('js') ?>
<script>
  require(['linkTo', 'dataTable', 'form', 'jquery-deparam'], function (linkTo) {
    var recordTable = $('#nav-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/navs/%s/links.json', '<?= (int) $req['navId'] ?>')
      },
      columns: [
        {
          data: 'name',
          render: function (data, type, full) {
            if (full.type == '2') {
              return '--分隔线--';
            }

            if (full.parentId == '0') {
              return data;
            } else {
              return '|-- ' + data;
            }
          }
        },
        {
          data: 'linkTo',
          render: function (data, type, full) {
            return linkTo.renderLink(data, full.url);
          }
        },
        <?php if (in_array('side', $type['supports'])) : ?>
        {
          data: 'side',
          sClass: 'text-center',
          render: function (data, type, full) {
            return template.render('side-col-tpl', full);
          }
        },
        <?php endif ?>
        {
          data: 'sort',
          sClass: 'text-center'
        },
        {
          data: 'id',
          sClass: 'text-center',
          render: function (data, type, full) {
            return template.render('table-actions', full);
          }
        }
      ]
    });

    recordTable.deletable();
  });
</script>
<?= $block->end() ?>

<script id="side-col-tpl" type="text/html">
  <% if (parentId == '0' && side != '') { %>
  <span class="badge badge-<%= side == 'left' ? 'success' : 'warning' %>"><%= side == 'left' ? '左边' : '右边' %></span>
  <% } else { %>
  -
  <% } %>
</script>

<script id="table-actions" type="text/html">
  <div class="action-buttons">
    <?php if (in_array('sub-links', $type['supports'])) : ?>
      <% if (parentId == '0') { %>
      <a href="<%= $.url('admin/navs/%s/links/new', navId, {parentId: id}) %>" title="添加子链接">
        <i class="fa fa-plus bigger-130"></i>
      </a>
      <% } %>
    <?php endif ?>
    <a href="<%= $.url('admin/links/%s/edit', id) %>" title="编辑">
      <i class="fa fa-edit bigger-130"></i>
    </a>
    <a class="text-danger delete-record" href="javascript:;"
      data-href="<%= $.url('admin/links/%s?_method=delete', id) %>" title="删除">
      <i class="fa fa-trash-o bigger-130"></i>
    </a>
  </div>
</script>
