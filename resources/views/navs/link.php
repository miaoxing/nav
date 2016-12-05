<?php foreach ($links as $link) : ?>
  <?php if ($link->isDivider()) : ?>
    <li class="list-divider"></li>
  <?php else : ?>
    <li class="list-item-link">
      <a class="list-item has-feedback" href="<?= $link->getUrl() ?>">
        <div class="list-col list-col-left list-col-icon">
          <?php if ($link['icon'] == 'image') : ?>
            <img class="list-icon" src="<?= $link['image'] ?>">
          <?php elseif ($link['icon'] == 'font') : ?>
            <i class="list-icon <?= $link['font'] ?>"
              style="<?= $link['bgColor'] ? ('background-color:' . $link['bgColor']) : '' ?>">
            </i>
          <?php else : ?>
            <i class="list-icon iconfont"
              style="<?= $link['bgColor'] ? ('background-color:' . $link['bgColor']) : '' ?>">
              <?= $link['customFont'] ?></i>
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
