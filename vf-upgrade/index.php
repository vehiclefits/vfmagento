<?php
$mageRoot = str_replace('vf-upgrade', '', dirname($_SERVER['SCRIPT_FILENAME']));
file_put_contents($mageRoot.'var/vf-upgrade-progress.txt', '');
chmod($mageRoot.'var/vf-upgrade-progress.txt', 0777);
?>
<html>
    <head>
        <script src="/skin/adminhtml/default/default/vf/jquery-1.7.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                var finished = false;

                var showProgress = function() {
                    $.get('progress.php', function(data){
                        console.log(data);
                        $('.progress').text(data)
                    })
                    if(!finished) {
                        setTimeout(showProgress, 500);
                    }
                };

                $('#upgrade').click(function() {
                    showProgress();
                    $('#upgrade').attr("disabled", "disabled");
                    $.get('run.php', function(data) {
                        $('.results').text(data);
                        finished = true;
                    });
                });
            });
        </script>
    </head>
    <body>
        <input type="button" name="upgrade" id="upgrade" value="upgrade" />
        <br />
        <pre class="progress"></pre>
        <pre class="results"></pre>
    </body>
</html>