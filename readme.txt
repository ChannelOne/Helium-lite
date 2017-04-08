推荐的系统环境

IIS 7.5 + / Apache 2.2 +
PHP 7.0 +
MySQL 5.6 + / MariaDB 10.0 +

=========

建立一个空的数据库

=========

数据库导入步骤：

1. 导入初始数据库版本文件: documents\database\structure
2. 依次倒入数据库升级文件: documents\database\upgrade

==========

将文件复制到网页服务器中。

这里我们默认将其复制为 helium 子文件夹

并设定访问URL为 http://localhost/helium

==========

需要修改的配置文件列表：

application\config\development\database.php
	username	- 数据库用户名
	password	- 数据库密码
	database	- 之前创建的数据库名

application\config\development\config.php
	base_url	- 如果复制到helium文件夹内则无需修改

application\config\development\hook.php
	RESOURCES_ENDPOINT - 如果复制到helium文件夹内则无需修改

.htaccess
	RewriteBase	- 如果复制到helium文件夹内则无需修改

==========

初始化设置：

创建用户

在数据库中执行以下SQL
INSERT INTO `user` (`user_id`, `display_name`, `email`, `mobile`, `password`, `tfa_secret`, `user_group`, `skudb_group`, `report_group`, `sku_tree_node`, `last_login_date`, `last_login_ip`, `disabled`)
    VALUES (2, 'developer', 'developer@lizhi.io', '1387654321', '$2y$10$NU1vZtGXhy94pxYYSDBe3Ozq6X6pr99qckc30Jxq1sNf5qcu.3AfG', 'XBFWSPVFBNVUF7VH', 4, 2, 3, '', 1491318898, '127.0.0.1', 0);

将创建一个新用户，登录账号是 developer@lizhi.io，密码是 123456
测试系统两步认证将自动跳过，随便填六位数字即可

========

设置权限：

给 application\cache 目录可读写权限
