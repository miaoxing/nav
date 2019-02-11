<?php $view->layout() ?>

<div class="row">
  <div class="col-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">
      <table id="nav-table" class="table table-bordered table-hover">
        <thead>
        <tr>
          <th>类型</th>
          <th class="t-6">启用</th>
          <th class="t-7">管理链接</th>
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

<?= $block->js() ?>
<script>
  require(['dataTable', 'form', 'jquery-deparam'], function () {
    var recordTable = $('#nav-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/navs.json')
      },
      columns: [
        {
          data: 'typeConfig.name'
        },
        {
          data: 'enable',
          sClass: 'text-center',
          render: function (data, type, full) {
            return template.render('checkbox-col-tpl', {
              id: full.id,
              name: 'enable',
              value: data
            });
          }
        },
        {
          data: 'id',
          sClass: 'text-center',
          render: function (data, type, full) {
            return template.render('table-sub-link-actions', full);
          }
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

    // 切换状态
    recordTable.on('click', '.toggle-status', function(){
      var $this = $(this);
      var data = {};
      data['id'] = $this.data('id');
      data[$this.attr('name')] = +!$this.data('value');
      $.post($.url('admin/navs?_method=put'), data, function(result){
        $.msg(result);
        recordTable.reload();
      }, 'json');
    });

    recordTable.deletable();
  });
</script>
<?= $block->end() ?>

<script id="table-actions" type="text/html">
  <div class="action-buttons">
    <a href="<%= $.url('admin/navs/%s/edit', id) %>" title="编辑">
      <i class="fa fa-edit bigger-130"></i>
    </a>
  </div>
</script>

<script id="table-sub-link-actions" type="text/html">
  <a href="<%= $.url('admin/navs/%s/links', id) %>">
    管理链接
  </a>
</script>

<?php require $view->getFile('@admin/admin/checkboxCol.php') ?>
