<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
	    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php echo($_GET['name']); ?> || Processing Application</title>
		<script type="text/javascript" src="<?php echo($_GET['pluginurl']); ?>/data/pe_deployJava.js"></script>
		<script type="text/javascript">
			/* <![CDATA[ */
			/*
			window.onload = function() {
				var appWidth  = <?php echo($_GET['width']); ?>;
				var appHeight = <?php echo($_GET['height']); ?>;
				// alert('window height: '+window.innerHeight+', app height: '+appHeight);
				if (window.innerHeight<appHeight) {
					var h = appHeight-window.innerHeight;
					window.resizeTo(appWidth, appHeight+h)
				}
			}
			*/
			/* ]]> */
		</script>
		<style>
			/* <![CDATA[ */
			*{
				margin: 0;
				padding: 0;
			}
			
			html,body{
				margin: 0;
				padding: 0;
			}
			/* ]]> */
		</style>
	</head>
	<body>
		<div class="processing_embed" id="<?php echo($_GET['name']); ?>_container">
			<script type="text/javascript">
				/* <![CDATA[ */
				var attributes = { 
					code: '<?php echo($_GET['name']); ?>.class',
					archive: '<?php echo($_GET['file']); ?>,<?php echo($_GET['pluginurl']); ?>/data/core.jar',
					width: <?php echo($_GET['width']); ?>, 
					height: <?php echo($_GET['height']); ?>,
					image: '<?php echo($_GET['pluginurl']); ?>/data/loading.gif'
					};
				var parameters = { };
				var version = '1.5';
				deployJava.runApplet(attributes, parameters, version);
				/* ]]> */
			</script>
			<noscript><div>
				<!--[if !IE]> -->
				<object classid="java:<?php echo($_GETname); ?>.class" 
					type="application/x-java-applet"
					archive="<?php echo($_GETfile); ?>,<?php echo($_GETpluginurl); ?>/data/core.jar"
					width="<?php echo($_GETwidth); ?>" height="<?php echo($_GETheight); ?>"
					standby="Loading Processing software..." >
				<param name="archive" value="<?php echo($_GETfile); ?>,<?php echo($_GETpluginurl); ?>/data/core.jar" />
				
				<param name="mayscript" value="true" />
				<param name="scriptable" value="true" />
				
				<param name="image" value="<?php echo($_GETpluginurl); ?>/data/loading.gif" />
				<param name="boxmessage" value="Loading Processing software..." />
				<param name="boxbgcolor" value="#FFFFFF" />
				
				<param name="test_string" value="outer" />
				<!--<![endif]-->
				
				<object classid="clsid:8AD9C840-044E-11D1-B3E9-00805F499D93"
					codebase="http://java.sun.com/update/1.6.0/jinstall-6u20-windows-i586.cab"
					width="<?php echo($_GETwidth); ?>" height="{<?php echo($_GETheight); ?>}"
					standby="Loading Processing software..."  >
					
					<param name="code" value="<?php echo($_GETname); ?>" />
					<param name="archive" value="<?php echo($_GETfile); ?>,<?php echo($_GETpluginurl); ?>/data/core.jar" />
					
					<param name="mayscript" value="true" />
					<param name="scriptable" value="true" />
					
					<param name="image" value="<?php echo($_GETpluginurl); ?>/data/loading.gif" />
					<param name="boxmessage" value="Loading Processing software..." />
					<param name="boxbgcolor" value="#FFFFFF" />
					
					<param name="test_string" value="inner" />
					
					<p>
						<?php echo($_GET['alternate']); ?>
						<strong>This browser does not have a Java Plug-in.
						<br />
						<a href="http://www.java.com/getjava" title="Download Java Plug-in">Get the latest Java Plug-in here.</a>
						</strong>
					</p>
				
				</object>
				<!--[if !IE]> -->
				</object>
				<!--<![endif]-->
			</div></noscript>
		</div>
	</body>
</html>