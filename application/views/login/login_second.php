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
<body class="hold-transition lockscreen">
    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
            <a href="#"><b>DIGITALYCHEE</b></a>
        </div>
        <div class="lockscreen-name"><?=current_username()?></div>

        <div class="lockscreen-item">
            <div class="lockscreen-image">
                <img src="<?=gravatar_url(128)?>" alt="User Image">
            </div>
            <form action="<?=site_url('login/process')?>" method="post" class="lockscreen-credentials">
                <?=csrf_input()?>
                <input type="hidden" name="phase" value="2" />
                <div class="input-group">
                    <input type="text" name="token" class="form-control" placeholder="******" autocomplete="off" />

                    <div class="input-group-btn">
                        <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="help-block text-center">
            输入你的两步认证验证码
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
