<!-- htmllint tag-bans="false" -->
<style>
  <?php foreach ($links as $i => $link) : ?>
  .icon-bg-<?= $i ?> {
    <?= $link['bgColor'] ? ('background-color:' . $link['bgColor']) : '' ?>;
  }
  <?php endforeach; ?>
</style>
<!-- htmllint tag-bans="$previous" -->

<!-- htmllint preset="none" -->
<!-- htmllint tag-name-match="false" -->

<?php foreach ($links as $i => $link) : ?>
  <?php if ($link->isDivider()) : ?>
    <li class="list-divider"></li>
  <?php else : ?>
    <li class="list-item-link">
      <a class="list-item has-feedback" href="<?= $link->getUrl() ?>">
        <div class="list-col list-col-left list-col-icon">
          <?php if ($link['icon'] == 'image') : ?>
            <img class="list-icon" src="<?= $link['image'] ?>">
          <?php elseif ($link['icon'] == 'font') : ?>
            <i class="list-icon <?= $link['font'] ?> <?= 'icon-bg-' . $i; ?>">
            </i>
          <?php else : ?>
            <i class="list-icon iconfont <?= 'icon-bg-' . $i; ?>">
              <?= $link['customFont'] ?>
            </i>
          <?php endif ?>
        </div>
        <div class="list-col list-middle">
          <h4 class="list-heading">
            <?= $link['name'] ?>
          </h4>
        </div>
        <i class="bm-angle-right list-feedback"></i>
      </a>
    </li>
  <?php endif ?>
<?php endforeach ?>
