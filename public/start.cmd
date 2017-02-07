@echo off

:: PHP简易开发环境搭建工具 V1.0
::
:: 作者：Anyon <zoujingli@qq.com>
:: 网址：http://www.ctolog.com
:: 创建：2016/09/22 20:20

title HTTP-SERVER

set pan=%~d0
:: 判断PHP运行环境是否存在
if not exist %pan%\php (goto down) else (goto start)


:start
	cls

	:: 临时设置PHP运行环境路径
	set path=%~dp0..\php;%~dp0php;%pan%\php;%path% 

	:: 随机计算服务运行端口
	set port=%random%
	set /a port=port%%1000+2000
	title [ %port% ] HTTP-SERVER

	:: 打开浏览器窗口
	start http://localhost:%port%

	:: 启动Web服务进程
	@echo on
	@php -S localhost:%port% router.php
	goto end

:down
	cls 
	echo.
	echo 　　未检测到本地环境，正在尝试下载安装，请稍候...
	echo.

	:: 资源路径定义
	set src=http://zoujingli.oschina.io/static/php-install/php.zip
	set des=%pan%\php.zip
	
	set sof_32=http://zoujingli.oschina.io/static/php-install/vc_redist.x86.exe
	set sof_des_32=%pan%\vc_redist.x86.exe

	set sof_64=http://zoujingli.oschina.io/static/php-install/vc_redist.x64.exe
	set sof_des_64=%pan%\vc_redist.x64.exe
	
	set script=%pan%\script.vbs
	set dir=%pan%\

	:: 生成VB脚本，下载并处理PHP支持程序
	echo Set xPost = CreateObject("Microsoft.XMLHTTP") >%script%
	echo xPost.Open "GET","%src%",0 >>%script%
	echo xPost.Send() >>%script%
	echo Set sGet = CreateObject("ADODB.Stream") >>%script%
	echo sGet.Mode = 3 >>%script%
	echo sGet.Type = 1 >>%script%
	echo sGet.Open() >>%script%
	echo sGet.Write(xPost.responseBody) >>%script%
	echo sGet.SaveToFile "%des%",2 >>%script%
	
	if "%PROCESSOR_ARCHITECTURE%"=="x86" (		
		echo Set xPost = CreateObject("Microsoft.XMLHTTP") >>%script%	
		echo xPost.Open "GET","%sof_32%",0 >>%script%
		echo xPost.Send() >>%script%
		echo Set sGet = CreateObject("ADODB.Stream") >>%script%
		echo sGet.Mode = 3 >>%script%
		echo sGet.Type = 1 >>%script%
		echo sGet.Open() >>%script%
		echo sGet.Write(xPost.responseBody) >>%script%
		echo sGet.SaveToFile "%sof_des_32%",2 >>%script%
	) else (
		echo Set xPost = CreateObject("Microsoft.XMLHTTP") >>%script%	
		echo xPost.Open "GET","%sof_64%",0 >>%script%
		echo xPost.Send() >>%script%
		echo Set sGet = CreateObject("ADODB.Stream") >>%script%
		echo sGet.Mode = 3 >>%script%
		echo sGet.Type = 1 >>%script%
		echo sGet.Open() >>%script%
		echo sGet.Write(xPost.responseBody) >>%script%
		echo sGet.SaveToFile "%sof_des_64%",2 >>%script%
	)
	
	:: 定义ZIP解析函数
	echo Sub UnZip(ByVal myZipFile, ByVal myTargetDir) >>%script%
	echo     Set fso = CreateObject("Scripting.FileSystemObject") >>%script%
	echo     If NOT fso.FileExists(myZipFile) Then >>%script%
	echo         Exit Sub >>%script%
	echo     ElseIf NOT fso.FolderExists(myTargetDir) Then >>%script%
	echo         fso.CreateFolder(myTargetDir) >>%script%
	echo     End If >>%script%
	echo     Set objShell = CreateObject("Shell.Application") >>%script%
	echo     Set objSource = objShell.NameSpace(myZipFile) >>%script%
	echo     Set objFolderItem = objSource.Items() >>%script%
	echo     Set objTarget = objShell.NameSpace(myTargetDir) >>%script%
	echo     intOptions = 256 >>%script%
	echo     objTarget.CopyHere objFolderItem, intOptions >>%script%
	echo End Sub >>%script%
	:: 解压ZIP文件
	echo UnZip "%des%", "%dir%" >>%script%
	:: 执行VB脚本
	cscript %script%
	
	cls
	echo.
	echo 　　这里会提示您安装VC支持库，请根据提示进行操作！
	echo.
	echo 　　　--- 如果没有安装，请根据提示进行安装！---
	echo.
	echo 　　　--- 如果已经安装，请忽略并关闭提示框！---
	echo.
	
	:: 安装并生成VB清理脚本
	echo Set fso = CreateObject("Scripting.FileSystemObject") >%script%
	echo fso.deleteFile "%des%" >>%script%
	if "%PROCESSOR_ARCHITECTURE%"=="x86" (
		%sof_des_32%
		echo fso.deleteFile "%sof_des_32%" >>%script%
	) else (
		%sof_des_64%
		echo fso.deleteFile "%sof_des_64%" >>%script%
	)
	echo fso.deleteFile "%script%" >>%script%
	:: 执行VB脚本
	cscript %script%

	cls
	goto start

:end