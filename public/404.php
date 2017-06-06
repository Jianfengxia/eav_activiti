<?php
/**
 * Created by PhpStorm.
 * User: jianfeng.xia
 * Date: 2016/6/24
 * Time: 10:07
 */
require 'layout.php';

?>
<style>
    h1 {
        display: block;
        font-size: 2em;
        -webkit-margin-before: 0.67em;
        -webkit-margin-after: 0.67em;
        -webkit-margin-start: 0px;
        -webkit-margin-end: 0px;
        font-weight: bold;
    }
    body .logo h1 {
         color: #FFFFFF;
         font-size: 100px;
         text-shadow: 0 1px 0 #CCCCCC,0 2px 0 #C9C9C9,0 3px 0 #BBBBBB,0 4px 0 #B9B9B9,0 5px 0 #AAAAAA,0 6px 1px rgba(0,0,0,0.1),0 0 5px rgba(0,0,0,0.1),0 1px 3px rgba(0,0,0,0.3),0 3px 5px rgba(0,0,0,0.2),0 5px 10px rgba(0,0,0,0.25),0 10px 10px rgba(0,0,0,0.2),0 20px 20px rgba(0,0,0,0.15);

</style>

<div class="col-lg-8 col-lg-offset-2 text-center">
    <div class="logo">
        <h1>404</h1>
    </div>
    <p class="lead text-muted">Nope, not here.</p>
    <div class="clearfix"></div>
    <div class="col-lg-6 col-lg-offset-3">
        <div class="btn-group btn-group-justified">
            <a href="dashboard.php" class="btn btn-info">Return Dashboard</a>
            <a href="index.php" class="btn btn-warning">Return Website</a>
        </div>
    </div>
</div><!-- /.col-lg-8 col-offset-2 -->
</div>
</body>
</html>