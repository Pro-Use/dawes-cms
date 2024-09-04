
        <section id="images" class="artist-index">
            <?php 
                $categories = $page->categories()->split();
                $i = 0;
                if($categories):
            ?> 
            <div class="filters mono cap">
                <?php foreach($categories as $category):?>
                <button class="filter-button button" aria-label="Only Show <?=$category ?>" data-filter="filter-<?=$category;?>"><?= $category ?></button>
                <?php if($i == count($categories)-1){ }else{ echo '•';}?>
                <?php $i++; endforeach;?>
            </div>
            <?php elseif($page->placeholder()->isNotEmpty()):?>
                <div class="filters mono cap">
                    <?= $page->placeholder();?>
                </div>
            <?php endif;?>
            <ul class="artist-index-grid">
                <?php   
                    $albums = $page->children()->template('slideshow')->listed();
                    if($albums->count() > 0):    
                        foreach($albums as $album):
                            $categories = $album->categories()->split();
                            if($cover = $album->cover()->toFile()):
                ?>
                    <li class="album <?php foreach($categories as $category):?> filter-<?= $category;?> <?php endforeach;?>">
                        <a href="<?= $album->url();?>" class="album-link prevent <?= $cover->orientation();?> <?= $cover->type();?>" data-barba-prevent="self">
                            <?php if($cover): ?>
                                <?php if ($cover->slideType() == 'video'):?>
                                    <?php $ratio = ($cover->height() / $cover->width() * 100);?>
                                    <div class="image-wrapper" style="padding-bottom: <?= $ratio;?>%">
                                        <?php if($src = $cover->videoFile()->toFile()): ?>
                                            <video
                                                width="500"
                                                height="500"
                                                class="lazyload"
                                                preload="none"
                                                muted=""
                                                loop
                                                playsinline 
                                                data-autoplay=""
                                                alt="<?= $album->title();?>"
                                                src="<?= $src->url() ?>"
                                            ></video>
                                        <?php endif;?>
                                    </div>
                                <?php else:?>
                                    <?php $ratio = ($cover->height() / $cover->width() * 100);?>
                                    <div class="image-wrapper" style="padding-bottom: <?= $ratio;?>%">
                                        <img class="lazyload" data-srcset="<?= $cover->srcset('half')?>" alt="<?= $album->title();?>"/>
                                    </div>
                                <?php endif;?>
                            <?php endif; ?>
                            <span class="album-caption mono cap"><?= $album->title();?></span>
                        </a>
                    </li>        
                <?php   
                    endif;
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