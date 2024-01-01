<!-- htmllint tag-bans="false" -->
<style>
  body, .ui-page {
    padding-bottom: 50px;
  }
  .nav-footer {
    background-color: <?= $nav['bgColor'] ?>;
  }
  .nav-footer > a {
    color: <?= $nav['color'] ?> !important;
  }
  .nav-footer > a:active,
  .nav-footer a.active,
  .nav-footer > a:active i,
  .nav-footer > a.active i {
    color: <?= $nav['activeColor'] ?: $nav['color'] ?> !important;
  }
  .cart-footer-bar,
  .snap-drawer, .snap-content {
    bottom: 50px; /* TODO */
  }
</style>
<!-- htmllint tag-bans="$previous" -->

<nav class="nav-footer border-top d-flex flex-center">
  <?php foreach ($links as $link) { ?>
    <a class="js-nav-footer-item <?= $link['isMatch'] ? 'active' : '' ?>" href="<?= $link['url'] ?>">
      <?php if ('image' == $link['icon'] && $link['isMatch']) { ?>
        <img class="nav-footer-icon" src="<?= $link['activeImage'] ?>">
      <?php } elseif ('image' == $link['icon']) { ?>
        <img class="nav-footer-icon" src="<?= wei()->asset->thumb($link['image'], 72) ?>">
      <?php } elseif ('font' == $link['icon']) { ?>
        <i class="nav-footer-icon <?= $link['font'] ?>"></i>
      <?php } else { ?>
        <i class="nav-footer-icon iconfont <?= $link['customFont'] ?>"></i>
      <?php } ?>
      <?= $link['name'] ?>
    </a>
  <?php } ?>
</nav>
