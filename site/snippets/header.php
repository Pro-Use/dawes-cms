<!doctype html>
<html lang="<?= $kirby->language() ? $kirby->language()->code() : 'en' ?>" class="no-js">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <?php snippet('meta_information'); ?>
  <?php snippet('robots'); ?>
  
  <link rel="apple-touch-icon" sizes="180x180" href="<?= $site->url() ?>/assets/icons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= $site->url() ?>/assets/icons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= $site->url() ?>/assets/icons/favicon-16x16.png">
  <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
  <?= css('assets/style-v1.3.css?v=1') ?>
  <?= js('assets/modernizr.min.js')?>
  <?= js('assets/pace.min.js')?>
</head>
<body>
  <div data-page="wrapper" class="site-wrapper">
    <a href="#main" class="skip-to-content">Skip to content</a>

    <nav class="main-menu">
        <details>
          <summary id="menu-toggle-button" class="button menu-toggle-button">
            <span class="visuallyhidden">Main Menu</span>
            <div class="menu-toggle-button-inner">
              <span class="menu-bar"></span>
              <span class="menu-bar"></span>
            </div>          
          </summary>
          <div id="menu" class="main-menu-container">
            <button class="button menu-close" aria-expanded="false" aria-controls="menu">Close</button>
            
            <ul class="main-menu-list">
                <?php 
                  $children = $site->children()->listed();
                  foreach($children as $child):
                ?>
                <li class="menu-item"><a href="<?= $child->url();?>"><?= $child->title();?></a></li>
                <?php 
                  endforeach;
                ?>
            </ul>
          </div>
        </details>
      </nav>
