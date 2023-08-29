

                                         <!--  THIS IS THE CONTENT MAIN -->
         
        <?php include_once dirname(__FILE__).'/modal.php'; ?>

        <script>var hostUrl = "<?php echo get_template_directory_uri();?>/assets/";</script>
        <!--begin::Global Javascript Bundle(mandatory for all pages)-->
        <script src="<?php echo get_template_directory_uri();?>/assets/plugins/global/plugins.bundle.js"></script>
        <script src="<?php echo get_template_directory_uri();?>/assets/js/scripts.bundle.js"></script>
        <!--end::Global Javascript Bundle-->
        <!--begin::Vendors Javascript(used for this page only)-->
        <script src="<?php echo get_template_directory_uri();?>/assets/plugins/custom/fslightbox/fslightbox.bundle.js"></script>
        <script src="<?php echo get_template_directory_uri();?>/assets/plugins/custom/typedjs/typedjs.bundle.js"></script>
        <!--end::Vendors Javascript-->
        <!--begin::Custom Javascript(used for this page only)-->
    <script src="<?php echo get_template_directory_uri();?>/assets/js/custom/landing.js"></script>
       
    <?php
     if (function_exists('getCurrentPageFileName')) {
         $filename = getCurrentPageFileName();
         if (isset($filename) && $filename =='login.php') { ?>
          <script src="<?php echo get_template_directory_uri();?>/assets/js/login.js"></script>
          <?php
         } elseif (isset($filename) && $filename=='signup.php') { ?>
          <script src="<?php echo get_template_directory_uri();?>/assets/js/signup.js"></script>
       <?php
         } elseif (isset($filename) && $filename=='getstarted.php') { ?>
          <script src="<?php echo get_template_directory_uri();?>/assets/js/order.js"></script>
       <?php
         }
     }


        wp_footer();
        ?>
</body>
</html>
