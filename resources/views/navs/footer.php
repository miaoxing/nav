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
  .snap-drawer, .snap-content {
    bottom: 50px; /* TODO */
  }
</style>
<!-- htmllint tag-bans="$previous" -->

<nav class="nav-footer border-top flex flex-center">
  <?php foreach ($links as $link) : ?>
    <?php $isMatch = $curPath == $link['url'] || wei()->urlMapper->matchMap($link['url'], $curPath); ?>
    <a class="<?= $isMatch ? 'active' : '' ?>" href="<?= $link['url'] ?>">
      <?php if ($link['icon'] == 'image' && $isMatch) : ?>
        <img class="nav-footer-icon" src="<?= $link['activeImage'] ?>">
      <?php elseif ($link['icon'] == 'image') : ?>
        <img class="nav-footer-icon" src="<?= $link['image'] ?>">
      <?php elseif ($link['icon'] == 'font') : ?>
        <i class="nav-footer-icon <?= $link['font'] ?>"></i>
      <?php else : ?>
        <i class="nav-footer-icon iconfont"><?= $link['customFont'] ?></i>
      <?php endif ?>
      <?= $link['name'] ?>
    </a>
  <?php endforeach ?>
</nav>
