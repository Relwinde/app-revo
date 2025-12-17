<script src="assets/js/oneui.core.min.js"></script>

<!--
            OneUI JS

            Custom functionality including Blocks/Layout API as well as other vital and optional helpers
            webpack is putting everything together at assets/_es6/main/app.js
        -->
<script src="assets/js/oneui.app.min.js"></script>

<!-- Page JS Plugins -->
<script src="assets/js/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="assets/js/plugins/chart.js/Chart.bundle.min.js"></script>

<!-- Page JS Code -->
<script src="assets/js/pages/be_pages_dashboard.min.js"></script>

<!-- Page JS Helpers (jQuery Sparkline Plugins) -->
<script>
    jQuery(function() {
        One.helpers(['sparkline']);
    });
</script>