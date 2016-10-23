<script type="text/javascript">
    $(document).ready(function() {
        var $toastContent = $('<?php echo h($message) ?>');
        Materialize.toast($toastContent, 10000, 'green');
    });
</script>