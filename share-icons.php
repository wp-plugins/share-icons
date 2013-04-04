<?php
/*
Plugin Name: Share Icons
Plugin URI: http://jusarg.com/shareicons
Description: Go to the plugins settings page to add/remove different share buttons.
Version: 1.0
Author: Justin Sargent - Professional Web Developer
Author URI: http://jusarg.com
License: GPL2
*/


// Plugin Code
$jusarg_optName = 'jusarg_dot_com_icon_options';

add_filter('the_content', 'jusarg_dot_com_share_icons');

function get_jusarg_dot_com_icon_opts(){
    global $jusarg_optName;
    $iconOpt = get_option($jusarg_optName);
    // If no options set then set them
    if(!$iconOpt){
        $iconOpt = new stdClass();
        $iconOpt->ad = false;
        $iconOpt->fb = true;
        $iconOpt->twitter = true;
        $iconOpt->su = false;
        $iconOpt->reddit = false;

        update_option($jusarg_optName, $iconOpt);
    }

    return $iconOpt;
}

function jusarg_dot_com_share_icons($content){
    global $jusarg_optName;

    // DELETE CODE - Using for testing - Sets database to null to simulate a fresh install
    //update_option($jusarg_optName, null);
    // DELETE CODE - Using for testing

    $iconOpt = get_jusarg_dot_com_icon_opts();
    $content.='<i>-Share this page-</i>';

    if($iconOpt->fb){
        $content.= '<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));</script>
<div style="width:44px;overflow:hidden;" class="fb-like" data-send="false" data-layout="button_count" data-width="30" data-show-faces="false"></div>';
    }
    if($iconOpt->twitter){
        $content.='<a href="https://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
    }
    if($iconOpt->su){
        $content.='<!-- Place this tag where you want the su badge to render -->
<su:badge layout="6"></su:badge>

<!-- Place this snippet wherever appropriate -->
<script type="text/javascript">
    (function() {
        var li = document.createElement("script"); li.type = "text/javascript"; li.async = true;
        li.src = ("https:" == document.location.protocol ? "https:" : "http:") + "//platform.stumbleupon.com/1/widgets.js";
        var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(li, s);
    })();
</script>';
    }
    if($iconOpt->reddit){
        $content.='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url=\' + encodeURIComponent(window.location); return false"> <img src="http://www.catalystathletics.com/images/socialIcons/reddit.png" alt="submit to reddit" border="0" /> </a>';
;
    }
    if($iconOpt->ad){
        $content.='<a href="http://jusarg.com"> <img src="http://gameznet.com.au/computer/animated/cat7/anim53.gif" alt="Hire a Professional Programmer"> </a>';
    }

    return $content;
}

// Be sure to do a check b4 going to admin page to make sure i have options defined
// Admin Page

if (isset($_POST["submit_opts"])){
    // Process Form
    $iconOpt = get_jusarg_dot_com_icon_opts();
    if (isset($_POST["twitter"])){
        $iconOpt->twitter = true;
    }else{
        $iconOpt->twitter = false;
    }
    if (isset($_POST["fb"])){
        $iconOpt->fb = true;
    }else{
        $iconOpt->fb = false;
    }
    if (isset($_POST["su"])){
        $iconOpt->su = true;
    }else{
        $iconOpt->su = false;
    }
    if (isset($_POST["ad"])){
        $iconOpt->ad = true;
    }else{
        $iconOpt->ad = false;
    }
    if (isset($_POST["reddit"])){
        $iconOpt->reddit = true;
    }else{
        $iconOpt->reddit = false;
    }
    update_option($jusarg_optName, $iconOpt);
    echo '<b style="COLOR: #00FF00;background-color: #696969;">------------------------------------------ .:| Settings Saved |:. ------------------------------------------</b>';
}

add_action( 'admin_menu', 'jusarg_dot_com_share_icons_plugin_menu' );

function jusarg_dot_com_share_icons_plugin_menu() {
    add_options_page( 'Share Icons - Options', 'Share Icons Settings', 'manage_options', 'share-icons-options-page', 'jusarg_dot_com_share_icons_plugin_options' );
}

function jusarg_dot_com_share_icons_plugin_options() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    $iconOpt = get_jusarg_dot_com_icon_opts();
    $html4opts = '<p>This plugin was created by <a href="http://jusarg.com">Justin Sargent</a>.</p>
    <form name="optsForm" action="" method="post">
    <p><input type="checkbox" name="fb" '.(($iconOpt->fb) ? "checked" : "").'/> Facebook</p>
    <p><input type="checkbox" name="twitter" '.(($iconOpt->twitter) ? "checked" : "").'/> Twitter</p>
    <p><input type="checkbox" name="su" '.(($iconOpt->su) ? "checked" : "").'/> StumbleUpon</p>
    <p><input type="checkbox" name="reddit" '.(($iconOpt->reddit) ? "checked" : "").'/> Reddit</p>
    <p><input type="checkbox" name="ad" '.(($iconOpt->ad) ? "checked" : "").'/> Jusarg</p>
    <p><input type="submit" name="submit_opts" value="-Save Settings-" /></p>
    </form>
    <p>If you like my plugin then please consider <a href="http://jusarg.com/donate"><b>donating</b></a>!</p>
    <p>If you are interested in hiring a professional web developer then please contact me on my site: <a href="http://jusarg.com">Jusarg.com</a>!</p>
    ';
    echo $html4opts;
}
?>
