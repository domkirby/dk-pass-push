<?php
/* DK PASS PUSH
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
<div class="container">
    <img class="img-responsive center-block" style="height:100px; padding-bottom:20px" src="<?php echo $cfg_appUrl;?>/gui/custom/logo.png">
    <div class="jumbotron"><?php echo $app_IntroTextLinkCreationPage; ?><br />
        <br />
        <form id="frm_CreateASecret">
            <div>
                <input type="hidden" name="secret" id="hiddenSecret"/>
                <!--<textarea class="form-control" placeholder="Password/Secret" name="secret"></textarea>-->
                <div id="quill-toolbar" style="background:white;"></div>
                <div id="quill-editor" style="background: white; height: 400px;"></div>
            </div>
            <div class="input-group">
                <span class="input-group-addon">Time Limit</span>
                <input class="form-control" type="text" value="60" name="time" aria-label="time" />
                <div class="input-group-btn">
                    <select class="form-control" name="units">
                        <option>minutes</option>
                        <option>hours</option>
                        <option>days</option>
                    </select>
                </div>
            </div>
            <div class="input-group">
                <span class="input-group-addon" data-toggle="tooltip">Max Views</span>
                <input class="form-control" type="text" value="5" name="views" />
                <span class="input-group-addon">views</span>
            </div>
            <button class="btn btn-success btn-large" type="submit" id="btn_RequestLink">Get Secure Link</button>
        </form>
        <form id="frm_Nowhere">
            <div class="input-group">
                <span class="input-group-addon">Your Secure Link</span>
                <input class="form-control" type="text" id="field_YourLink" />
            </div>
            <button class="btn btn-success btn-large btncopy" id="btn_Copy" data-clipboard-target="#field_YourLink">Copy to Clipboard</button>
        </form>
    </div>
</div>
<script>
    //hide result
    $("#frm_Nowhere").hide();

    $(document).ready(function() {
        //quill it up
        var quill = new Quill('#quill-editor', {
            modules:  {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    ['code-block']
                ]
            },
            placeholder: 'Enter Your Secret Here',
            theme: 'snow'  // or 'bubble'
        });
        //submission handler
        $("#frm_CreateASecret").submit(function(e) {
            e.preventDefault();
            var secret = quill.getContents();
            var stringSecret = JSON.stringify(secret);
            $("#hiddenSecret").val(stringSecret);
            $("#btn_RequestLink").html('<img src="gui/img/loading.gif">');
            $.ajax({
                url: 'doCreateSecret.php',
                method: 'post',
                data: $("#frm_CreateASecret").serialize(),
                dataType: 'json',
                success: function(data) {
                    if(data.result) {
                        $("#field_YourLink").val(data.link);
                        $("#frm_CreateASecret").hide();
                        new Clipboard('.btncopy');
                        $("#frm_Nowhere").show();
                    } else {
                        alert('System Error');
                    }
                }
            })
        });
        //prevent copy btn from submitting form
        $("#frm_Nowhere").submit(function (e) {
            e.preventDefault();
        });
    });

</script>