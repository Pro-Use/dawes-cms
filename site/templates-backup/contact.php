<?= snippet('header');?>

<div class="main-wrapper" data-page="container" data-page-namespace="<?=$page->template();?>" data-order="0">
    <main id="main" class="main page-content contact-content">
            <header class="site-header">
                <h1 class="site-title">
                    <a href="<?= $site->url();?>">
                        <span class="visuallyhidden"><?= $site->title();?></span>
                        <?= snippet('logo-1');?>
                        <?= snippet('limon-vega-logo-2');?>
                    </a>
                </h1>
            </header>
            <div id="contact" class="contact-wrapper">
                    <div class="contact-details">
                        <div class="body-content">
                            <?php $contact = $site->children()->find('contact'); ?>
                            <?= $contact->contact();?>
                        </div>
                    </div>
                    <footer class="home-footer">
                        <a class="contact-link contact-link-toggle prevent cap" href="<?= $site->children()->find('artists')->url();?>">Artists</a>
                    </footer>
            </div>

    </main>
</div><?php // close main-contanier ?>

<?= snippet('footer');?>