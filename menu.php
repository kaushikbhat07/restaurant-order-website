<?php include("includes/front/top.php"); ?>

<link rel="stylesheet" href="css/menu.css">
</head>

<body>

    <!--==========================
    Header
  ============================-->
    <?php include("includes/front/header_static.php"); ?>


    <!--==========================
      Portfolio Section
    ============================-->
    <section id="portfolio" class="section-bg">
        <div class="container">

            <header class="section-header">
                <?php $cust->get_cat_menu_page(); ?>
                </ul>
        </div>
        </div>

        <div class="row portfolio-container">

            <?php $cust->get_items_menu_page(); ?>

        </div>

        </div>
    </section><!-- #portfolio -->

    <!--==========================
    Footer
  ============================-->

    <?php include("includes/front/footer.php"); ?>