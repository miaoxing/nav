<?php $nav = wei()->nav()->curApp()->enabled()->find(['type' => 'word']); ?>
<?= $block('css') ?>
<!-- htmllint tag-bans="false" -->
<style type="text/css">
  .nav-word {
    background-color: <?= $nav['bgColor'] ?>;
  }

  .nav-word ul li > a {
    text-decoration: none;
    color: <?= $nav['color'] ?> !important;
  }

  .nav-word ul li > a:active {
    color: <?= $nav['activeColor'] ?: $nav['color'] ?> !important;
  }

  /* 本例子css */
  .txt-marquee-left {
    width: 100%;
    position: relative;
    border: 1px solid #ccc;
  }

  .txt-marquee-left .bd .tempWrap {
    width: 100% !important;
  }

  .txt-marquee-left .bd {
    padding: 5px 10px;
  }

  /* 用 !important覆盖SuperSlide自动生成的宽度，这样就可以手动控制可视宽度。 */
  .txt-marquee-left .bd ul {
    overflow: hidden;
    width: 9000px !important;
    zoom: 1;
  }

  .txt-marquee-left .bd ul li {
    margin-right: 20px;
    float: left;
    height: 24px;
    line-height: 24px;
    text-align: left;
    width: auto !important;
    display: inline !important;
    list-style: none;
  }

  /* 用 width:auto !important 覆盖SuperSlide自动生成的宽度，解决文字不衔接问题 */
  .txt-marquee-left .bd ul li span {
    color: #999;
  }
</style>
<!-- htmllint tag-bans="$previous" -->
<?= $block->end() ?>

<?php $links = $nav ? $nav->getLinks() : ''; ?>
<?php if ($links && $links->count() > 0) : ?>
  <div class="txt-marquee-left nav-word js-txt-marquee">
    <div class="bd">
      <ul class="info-list">
        <?php foreach ($links as $link) : ?>
          <li>
            <a href="<?= wei()->linkTo->getUrl($link['linkTo']) ?: 'javascript:;' ?>">
              <?= $link['description']; ?>
            </a>
          </li>
        <?php endforeach ?>
      </ul>
    </div>
  </div>
<?php endif; ?>

<?= $block('js') ?>
<script>
  require(['comps/superSlide/jquery.SuperSlide.2.1.1'], function (linkTo) {
    $(".js-txt-marquee").slide({
      mainCell: ".bd ul",
      autoPlay: true,
      defaultPlay: false,
      effect: "leftMarquee",
      vis: 1,
      interTime: 50
    });
  });
</script>
<?= $block->end() ?>
