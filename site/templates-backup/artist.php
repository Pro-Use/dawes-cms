<?= snippet('header');?>

<div class="main-wrapper" data-page="container" data-page-namespace="<?=$page->template();?>" data-order="1">
    <main id="main" class="main artist-content">
        <header class="artist-header">
            <div class="artist-header-inner">
                <h1 class="page-title artist-title">
                    <a href="<?= $site->url();?>">
                        <?= $page->title();?>
                    </a>
                </h1>
                <p class="artist-cat mono cap"><?= $page->caption();?></p>
                <div class="bio-link-wrapper xs-hide sm-show page-margins cap">
                    <a href="#bio" class="bio-link">Bio</a>
                </div>
                <div class="back-link-wrapper xs-hide sm-show page-margins cap">
                    <a href="<?= $site->url();?>" class="back-link">Back</a>
                </div>                
            </div>
        </header>
            <?php
                $display = $page->display();
                if($display == 'single'):
                    snippet('single-content', ['page' => $page]);
                else:
                    snippet('multiple-content', ['page' => $page]);
                endif;
            ?>
        <section id="bio" class="artist-bio">  
            <div class="bio-inner">
                <div class="bio-grid page-margins body-content">
                        <div class="artist-bio-text rte">
                            <?= $page->biography();?>
                        </div>
                        <div class="artist-contact">
                            <?= $page->contact();?>
                        </div>
                </div>
                <footer class="artist-footer page-margins">
                    <div class="cap">
                        <a href="<?= $site->url();?>">Artists</a> • <a href="<?= $site->children()->find('contact')->url();?>">Contact</a>
                    </div>
                </footer>
            </div>
        </section>
    </main>

</div><?php // close main-contanier ?>

<?= snippet('footer');?>