<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DIGITALYCHEE | Helium</title>
    <link rel="stylesheet" href="<?=resource_url('AdminLTE/bootstrap/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=resource_url('font-awesome/css/font-awesome.min.css')?>">
    <link rel="stylesheet" href="<?=resource_url('ionicons/css/ionicons.min.css')?>">
    <link rel="stylesheet" href="<?=resource_url('AdminLTE/dist/css/AdminLTE.min.css')?>">
    <link rel="stylesheet" href="<?=resource_url('AdminLTE/dist/css/skins/skin-blue.min.css')?>">
    <link rel="stylesheet" href="<?=resource_url('AdminLTE/plugins/jQueryUI/jquery-ui.min.css')?>">
    <link rel="stylesheet" href="<?=resource_url('AdminLTE/plugins/jQueryUI/jquery-ui.theme.css')?>">
    <link rel="stylesheet" href="<?=resource_url('toastr/toastr.min.css')?>">
    <?php if(isset($header_css)): foreach ($header_css as $each): ?>
        <link rel="stylesheet" href="<?=resource_url($each)?>" />
    <?php endforeach; endif; ?> 
    <?php if(isset($header_js)): foreach ($header_js as $each): ?>
        <script src="<?=resource_url($each)?>"></script>
    <?php endforeach; endif; ?>
</head>
<body class="hold-transition skin-blue layout-boxed sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="#" class="logo">
                <span class="logo-mini"><b>DL</b></span>
                <span class="logo-lg"><b>DIGITALYCHEE</b></span>
            </a>

            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">收缩导航栏</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="user user-menu">
                            <a href="#">
                                <img src="<?=gravatar_url(25)?>" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?=current_username()?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=site_url('logout')?>"><i class="fa fa-power-off"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <ul class="sidebar-menu">
                    <?=$sidebar?>
                </ul>
            </section>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <h1><?=$title?></h1>
            </section>
            <section class="content">
                <?=$body?>
            </section>
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                Helium System
            </div>
            <strong>Copyright &copy; 2017 <a href="https://lizhi.io/">DIGITALYCHEE</a>.</strong> All rights reserved.
        </footer>
    </div>

    <script src="<?=resource_url('AdminLTE/plugins/jQuery/jquery-2.2.3.min.js')?>"></script>
    <script src="<?=resource_url('AdminLTE/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?=resource_url('AdminLTE/dist/js/app.min.js')?>"></script>
    <script src="<?=resource_url('AdminLTE/plugins/jQueryUI/jquery-ui.min.js')?>"></script>
    <script src="<?=resource_url('AdminLTE/plugins/jQueryUI/datepicker-zh-CN.js')?>"></script>
    <script src="<?=resource_url('toastr/toastr.min.js')?>"></script>
    <?php if(isset($footer_js)): foreach ($footer_js as $each): ?>
        <script src="<?=resource_url($each)?>"></script>
    <?php endforeach; endif; ?>

    <script type="text/javascript">
        <?=show_info_error()?>
    </script>
</body>
</html>
