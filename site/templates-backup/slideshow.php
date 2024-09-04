<?= snippet('header');?>

<div id="slideshow-wrapper" class="main-wrapper slideshow-wrapper" data-page="container" data-page-namespace="<?=$page->template();?>" data-order="2">
    <a href="<?= $page->parent()->url();?>" aria-label="close slideshow" class="slideshow-close-button cap">Close</a>
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
                            <img class="lazyload" data-flickity-lazyload-srcset="<?= $slide->srcset('full')?>" data-flickity-lazyload-src="<?= $slide->resize(1500)->url();?>" alt="<?= $slide->alt();?>" />
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
            <span class=""><?php if($page->caption()->isNotEmpty()){ echo $page->caption()->inline() . ' &mdash;';}?></span> <span id="count">1</span>/<span id="total"><?= $slides->count();?></span>
        </div>
    </footer>
</div><?php // close main-contanier ?>

<?= snippet('footer');?>