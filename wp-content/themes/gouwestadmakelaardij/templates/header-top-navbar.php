<div class="navbar container">
  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="brand" href="<?php echo home_url(); ?>/">
        <img src="http://www.gouwestadmakelaardij.nl/images/logogouwestad.png" alt="logo"/>
      </a>
      <nav class="nav-collapse" role="navigation">
        <?php
          if (has_nav_menu('primary_navigation')) :
            wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav pull-right'));
          endif;
        ?>
      </nav>
    </div>
  </div>
</div>

<header>
    <div class="header">
    </div>
    <div class="container">         
        <div class="row-fluid clearfix">
          <div class="span6">
            <h1>De makelaar voor Waddinxveen en omstreken</h1>
            <a href="http://www.vbo.nl/makelaars/4140/gouwestad-makelaardij/aanbod.html" class="btn btn-large btn-primary btn-block">Bekijk ons woningaanbod</a>
          </div>
        </div>
    </div>
  </header>