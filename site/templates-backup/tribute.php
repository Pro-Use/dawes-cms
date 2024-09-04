<?= snippet('header');?>

<div class="main-wrapper" data-page="container" data-page-namespace="<?=$page->template();?>" data-order="1">
    <main id="main" class="main artist-content">
        <header class="artist-header">
            <div class="artist-header-inner">
                <h1 class="page-title artist-title visuallyhidden">
                    <a href="<?= $site->url();?>">
                        <?= $page->title();?>
                    </a>
                </h1>
                <div class="back-link-wrapper xs-hide sm-show page-margins cap">
                    <a href="<?= $site->url();?>" class="back-link">Back</a>
                </div>                
            </div>
        </header>
        <div class="main tribute-content">
            <section class="image-section">
                <?php if($image = $page->single_image()->toFile()): 
                    $ratio = ($image->height() / $image->width() * 100);
                ?>
                    <div class="image-wrapper" style="padding-bottom: <?= $ratio;?>%">
                        <img class="lazyload tribute-image" data-srcset="<?= $image->srcset('half')?>" />
                    </div>
                <?php endif ?>
            </section>
            <section class="text-section rte small-body-content">
                <?= $page->text();?>
            </section>
        </div>
    </main>
</div><?php // close main-contanier ?>

<?= snippet('footer');?>