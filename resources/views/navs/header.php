<!-- htmllint tag-bans="false" -->
<style>
  #hm-nav-<?= $nav['id'] ?> {
    background-color: <?= $nav['bgColor'] ?>;
  }

  #hm-nav-<?= $nav['id'] ?>, #hm-nav-<?= $nav['id'] ?> a {
    color: <?= $nav['color'] ?>
  }
</style>
<!-- htmllint tag-bans="$previous" -->

<nav class="hm-nav" id="hm-nav-<?= $nav['id'] ?>">
  <div class="hm-nav-left"><?= $leftLinks ?></div>
  <div class="hm-nav-center"><?= $title ?></div>
  <div class="hm-nav-right"><?= $rightLinks ?></div>
</nav>

<?= $block->js() ?>
<script>
  (function () {
    typeof $ !== 'undefined' && $('.hm-nav-link').click(function (e) {
      var next = $(this).next();
      if (next.hasClass('hm-nav-menu')) {
        next.toggle();
        e.stopPropagation();

        if (next.css('display') != 'none') {
          $(document).on('click.hm-nav', function () {
            next.hide();
            $(this).off('click.hm-nav');
          });
        }
      }
    });
  })();
</script>
<?= $block->end() ?>
