<?= snippet('header');?>

<div class="main-wrapper" data-page="container" data-page-namespace="<?=$page->template();?>" data-order="1">
    <main id="main" class="main artist-content">
        <header class="site-header">
            <h1 class="site-title">
                <a href="<?= $site->url();?>">
                    <span class="visuallyhidden"><?= $site->title();?></span>
                    <?= snippet('logo-1');?>
                    <?= snippet('limon-vega-logo-2');?>
                </a>
            </h1>
        </header>
        <?php 
            if($password == $page->password()){
                $auth = true;
            }else{
                $error = "Incorrect Password";
            }
            if($auth == true){
                snippet('private-slideshow', ['page' => $page]); 
            }else{
                snippet('private-login', ['page' => $page]); 
            }
        ?>
    </main>

</div><?php // close main-contanier ?>

<?= snippet('footer');?>