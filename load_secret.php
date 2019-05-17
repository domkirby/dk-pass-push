<?php
/**
 * Created by PhpStorm.
 * User: DominicKirby
 * Date: 10/8/2017
 * Time: 21:55
 * Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
 */

?>
<?php
$_SESSION['csrf'] = base64_encode(random_bytes(32));
?>
<div class="container">
    <img class="img-responsive center-block" style="height:100px; padding-bottom:20px" src="<?php echo $cfg_appUrl;?>/gui/custom/logo.png">
    <div class="jumbotron">
        <div class="alert alert-primary" role="alert">
            <?php echo $app_SecretRetrieveInstructions; ?>
        </div>
        
    </div><br />
        <br />
        <form action="doRetrieveSecret.php" id="frm_GetSecret" method="post">
            <input type="hidden" name="UrlKey" value="<?php echo $_GET['pid']; ?>" id="field_urlkey">
            <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf'];?>" id="field_csrf">
            <span id="div_Secret">
                <div id="quill-toolbar" style="display: none;"></div>
                <p><b>Your Secret</b></p>
            <div id="quill-readonly" style="background: white;"></div>
            <button class="btn-danger btn-lg" id="btn_Delete" onclick="location.href = 'delete.php?pid=<?php echo $_GET['pid']; ?>&csrf=<?php echo $_SESSION['csrf'];?>'; return false;">Delete Secret</button>
        </span>
            <span id="div_Recap">
        
            <button class="btn-success btn-lg" id="btn_RetrieveSecret" type="submit"> Retrieve Secret </button>
        </span>
        </form>
    </div>
</div>
<script>
    //hide result
    $("#div_Secret").hide();
    <?php if($retrieve && !$SecretExists) {
        echo "alert('This secret does not exist or has expired.');
        location.href = '{$cfg_appUrl}';";
    }?>

    $(document).ready(function() {
        var quillOptions = {
            debug: 'info',
            modules: {
                toolbar: false
            },
            readOnly : true,
            theme: 'snow'
        };
        var quillObject = new Quill('#quill-readonly', quillOptions);

        $("#frm_GetSecret").submit(function(e) {
            e.preventDefault();
            urlkey = $("#field_urlkey").val();
            csrf = $("#field_csrf").val();
            $.ajax({
                url: 'doRetrieveSecret.php',
                data: {
                    urlkey: urlkey,
                    csrf: csrf
                },
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    if(data.result) {
                        secret = data.value;
                        jsonSecret = JSON.parse(secret);
                        quillObject.setContents(jsonSecret);
                        $("#div_Secret").show();
                        $("#div_Recap").hide();
                        new Clipboard(".btncopy");
                    } else {
                        alert('Could not grab secret.\n' + data.reason);
                        window.location.reload(true);
                    }

                }
            });
        });
    });


</script>
