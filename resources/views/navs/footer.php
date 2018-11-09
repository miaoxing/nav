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
  .nav-footer > a:active {
    color: <?= $nav['activeColor'] ?: $nav['color'] ?> !important;
  }
  .nav-footer a.active {
    color: <?= $nav['activeColor'] ?: $nav['color'] ?> !important;
  }
  .cart-footer-bar,
  .snap-drawer, .snap-content {
    bottom: 50px; /* TODO */
  }
</style>
<!-- htmllint tag-bans="$previous" -->

<nav class="nav-footer border-top flex flex-center">
  <?php foreach ($links as $link) : ?>
    <a class="js-nav-footer-item <?= $link['isMatch'] ? 'active' : '' ?>" href="<?= $link['url'] ?>">
      <?php if ($link['icon'] == 'image' && $link['isMatch']) : ?>
        <img class="nav-footer-icon" src="<?= $link['activeImage'] ?>">
      <?php elseif ($link['icon'] == 'image') : ?>
        <img class="nav-footer-icon" src="<?= wei()->asset->thumb($link['image'], 72) ?>">
      <?php elseif ($link['icon'] == 'font') : ?>
        <i class="nav-footer-icon <?= $link['font'] ?>"></i>
      <?php else : ?>
        <i class="nav-footer-icon iconfont"><?= $link['customFont'] ?></i>
      <?php endif ?>
      <?= $link['name'] ?>
    </a>
  <?php endforeach ?>
</nav>
