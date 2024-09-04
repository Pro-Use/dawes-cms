<?= snippet('header');?>

<div class="main-wrapper" data-page="container" data-page-namespace="<?=$page->template();?>" data-order="0">
    <main id="main" class="main page-content home-content">
            <header class="site-header">
                <h1 class="site-title">
                    <a href="<?= $site->url();?>">
                        <span class="visuallyhidden"><?= $site->title();?></span>
                        <?= snippet('logo-1');?>
                        <?= snippet('limon-vega-logo-2');?>
                    </a>
                </h1>
            </header>
            <artist-list id="artists" class="artist-list-wrapper">
                <div class="ui-layer">
                    <ul class="artist-list">
                    <?php   
                        $artists = $site->children()->find('artists')->children()->listed();
                        if($artists): 
                            $i = 0;
                            foreach($artists as $artist):
                        
                    ?>
                        <li>
                            <a id="<?=$i;?>" class="artist-link" href="<?= $artist->url();?>">
                                <span class="artist-name"><?= $artist->title();?></span>
                                <span class="artist-caption"><?= $artist->caption();?></span>
                            </a>
                        </li>
                                
                    <?php   
                        $i++; endforeach; else :
                    ?>
                        no artists :(
                    <?php endif;?>
                    </ul>
                    <footer class="home-footer">
                        <a class="contact-link contact-link-toggle prevent cap" href="<?= $site->children()->find('contact')->url();?>">Contact</a>
                    </footer>
                </div>
                <div class="artist-background-images">
                    <?php foreach($artists as $artist): ?>
                        <div class="image-group">
                            <?php $images = $artist->cover()->toFiles(); foreach($images as $image): ?>
                                <img class="artist-background-image" srcset="<?= $image->srcset('full')?>" aria-hidden="true"/>
                            <?php endforeach;?>
                        </div>
                    <?php endforeach;?>
                </div>
            </artist-list>
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