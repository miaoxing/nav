<!-- htmllint tag-bans="false" -->
<style>
  <?php foreach ($links as $i => $link) { ?>
  .icon-bg-<?= $i ?> {
    <?= $link['bgColor'] ? ('background-color:' . $link['bgColor']) : '' ?>;
  }
  <?php } ?>
</style>
<!-- htmllint tag-bans="$previous" -->

<!-- htmllint preset="none" -->
<!-- htmllint tag-name-match="false" -->

<ul class="list list-indented">
  <?php foreach ($links as $i => $link) { ?>
    <?php if ($link->isDivider()) { ?>
      <li class="list-item list-divider"></li>
    <?php } else { ?>
      <li class="list-item-link">
        <a class="js-link-nav-item list-item list-has-arrow" href="<?= $link->getUrl() ?>">
          <div class="list-col list-col-icon">
            <?php if ('image' == $link['icon']) { ?>
              <img class="list-icon <?= 'icon-bg-' . $i ?>" src="<?= $link['image'] ?>">
            <?php } elseif ('font' == $link['icon']) { ?>
              <i class="list-icon <?= $link['font'] ?> <?= 'icon-bg-' . $i ?>">
              </i>
            <?php } else { ?>
              <i class="list-icon iconfont <?= 'icon-bg-' . $i ?>">
                <?= $link['customFont'] ?>
              </i>
            <?php } ?>
          </div>
          <div class="list-col align-self-center">
            <h4 class="list-title">
              <?= $link['name'] ?>
            </h4>
          </div>
          <i class="bm-angle-right list-arrow"></i>
        </a>
      </li>
    <?php } ?>
  <?php } ?>
</ul>
