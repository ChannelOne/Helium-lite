<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DIGITALYCHEE | Log in</title>
    <link rel="stylesheet" href="<?=resource_url('AdminLTE/bootstrap/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=resource_url('font-awesome/css/font-awesome.min.css')?>">
    <link rel="stylesheet" href="<?=resource_url('ionicons/css/ionicons.min.css')?>">
    <link rel="stylesheet" href="<?=resource_url('AdminLTE/dist/css/AdminLTE.min.css')?>">
    <link rel="stylesheet" href="<?=resource_url('AdminLTE/dist/css/skins/skin-blue.min.css')?>">
    <link rel="stylesheet" href="<?=resource_url('AdminLTE/plugins/jQueryUI/jquery-ui.min.css')?>">
    <link rel="stylesheet" href="<?=resource_url('AdminLTE/plugins/jQueryUI/jquery-ui.theme.css')?>">
    <link rel="stylesheet" href="<?=resource_url('toastr/toastr.min.css')?>">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-box-body">
            <div class="login-logo">
                <a href="#"><b>DIGITALYCHEE</b></a>
            </div>
            <form action="<?=site_url('login/process')?>" method="post">
                <?=csrf_input()?>
                <input type="hidden" name="phase" value="1" />
                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" placeholder="邮箱" value="">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="密码" value="">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">登陆</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="<?=resource_url('AdminLte/plugins/jQuery/jquery-2.2.3.min.js')?>"></script>
    <script src="<?=resource_url('AdminLte/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?=resource_url('AdminLte/dist/js/app.min.js')?>"></script>
    <script src="<?=resource_url('AdminLte/plugins/jQueryUI/jquery-ui.min.js')?>"></script>
    <script src="<?=resource_url('AdminLte/plugins/jQueryUI/datepicker-zh-CN.js')?>"></script>
    <script src="<?=resource_url('toastr/toastr.min.js')?>"></script>

    <script type="text/javascript">
        <?=show_info_error()?>
    </script>
</body>
</html>
