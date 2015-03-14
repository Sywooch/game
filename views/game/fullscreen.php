<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.03.15
 * Time: 11:56
 */
?>
<div class="game-flash">
    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" width="468" height="60" id="mymoviename">
        <param name="movie" value="http://www.tizag.com/pics/example.swf" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#ffffff" />
        <embed src="/flash/<?=$model->file?>" quality="high" bgcolor="#ffffff"
               width="99%" height="99%"
               name="mymoviename" align="" type="application/x-shockwave-flash"
               pluginspage="http://www.macromedia.com/go/getflashplayer">
        </embed>
    </object>
</div>