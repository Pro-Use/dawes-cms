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
        <section id="images" class="artist-index">
            <ul class="artist-index-grid">
                
                <?php   
                    $slides = $page->gallery()->toFiles();
                    if($slides->count() > 0):    
                        $i = 0;
                        $vi = 0;
                        foreach($slides as $slide):
                ?>
                    <li class="album">
                        <a  href="#single-overlay" 
                            class="slideshow-link prevent <?= $slide->orientation();?>" 
                            data-barba-prevent="self" 
                            data-index="<?= $i; ?>" 
                            <?php if($slide->slideType() == "vimeo" || $slide->slideType() == "video"): ?>
                            data-vindex="<?= $vi; ?>"
                            <?php $vi++; endif;?>
                        >
                            <?php if($slide): 
                                $ratio = ($slide->height() / $slide->width() * 100);
                            ?>
                                <div class="image-wrapper" style="padding-bottom: <?= $ratio;?>%">
                                    <img class="lazyload" data-srcset="<?= $slide->srcset('half')?>" />
                                </div>
                            <?php endif; ?>
                            <span class="album-caption mono cap"><?= $slide->caption();?>
                        </a>
                    </li>        
                <?php   
                    $i++;
                    endforeach;
                    endif;
                ?>
            </ul>
            <footer class="artist-footer page-margins">
                <div class="cap">
                    <a href="<?= $site->url();?>">Artists</a> • <a href="<?= $site->children()->find('contact')->url();?>">Contact</a>
                </div>
            </footer>
        </section>            
        <div id="single-overlay" class="single-slideshow-overlay">
        <a href="<?= $page->parent()->url();?>" aria-label="close slideshow" class="slideshow-close-button cap">Close</a>
        <div id="slideshow-wrapper" class="main-wrapper slideshow-wrapper" data-page="container" data-page-namespace="<?=$page->template();?>" data-order="2">
            <div class="slideshow">
                <?php   
                    $slides = $page->gallery()->toFiles();
                    if($slides): foreach($slides as $slide):
                        $ratio = ($slide->height() / $slide->width() * 100);
                ?>
                    <div class="slide <?=$slide->slideType();?>">
                        <div class="slide-inner">
                                <?php if($slide->slideType() == 'video'):
                                    if($video = $slide->videoFile()->toFile()):    
                                ?>
                                    <div class="slide-image-container <?= $slide->orientation();?>">
                                        <video
                                            width="500"
                                            height="500"
                                            class="lazyload"
                                            style="width: 100%; height: 100%;"
                                            preload="none"
                                            loop
                                            <?php if($slide->autoplayVideo()->toBool() == true):?>
                                                data-autoplay=""
                                                muted=""
                                            <?php endif;?>
                                            data-poster="<?=$slide->url();?>"
                                            alt="<?= $slide->alt();?>"
                                            src="<?= $video->url();?>">
                                        </video>
                                    </div>
                                <?php endif;?>
                                <?php elseif($slide->slideType() == 'vimeo'):?>
                                    <div class="slide-image-container <?= $slide->orientation();?>">
                                        <div class="video-wrapper" data-ratio="<?= $slide->ratio();?>" data-orientation="<?= $slide->orientation();?>">
                                            <div class="video-wrapper js-player">
                                                <?php 
                                                    $url = $slide->vimeoLink();
                                                    $options = [
                                                        'vimeo' => [
                                                        'autoplay' => 0,
                                                        'controls' => 0,
                                                        'mute'     => 0
                                                        ],
                                                    ];
                                                ?>
                                                <?= video($url, $options);?>
                                            </div>
                                        </div>
                                    </div>
                                <?php else:?>
                                <div class="slide-image-container <?= $slide->orientation();?>">
                                    <img class="lazyload" data-flickity-lazyload-srcset="<?= $slide->srcset('full')?>" data-flickity-lazyload-src="YOMMOE" alt="<?= $slide->alt();?>" />
                                </div>
                                <?php endif;?>
                        </div>
                    </div>
                <?php
                    endforeach; endif;
                ?>
            </div>
            <button class="prev-slide">
                <span class="visuallyhidden">Previous Image</span>
            </button>
            <button class="next-slide">
                <span class="visuallyhidden">Next Image</span>
            </button>
            <footer class="slideshow-footer cap mono">
                <div class="slideshow-caption">
                    <span class="slideshow-caption-text"><?php echo $page->title()->inline() . ' &mdash;';?></span> <span id="count">1</span>/<span id="total"><?= $slides->count();?></span>
                </div>
            </footer>
        </div><?php // close main-contanier ?>
        </div>
    </main>