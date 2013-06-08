<?php
	if(session_id() == '') {
		session_start();
		$response = $_SESSION["response"];
	}
	require_once 'settings.php';
?>

		<!--
		<div id="leftsystem">
			<ul>
				<li>Video</li>
				<li>Music</li>
				<li>System</li>
			</ul>
		</div>
		<div id="rightsystem">
		</div>
		-->
		<div id="system">
			<table>
				<tr>
					<td width="25%" valign="top">
						<ul>
							<li>Video</li>
							<li>Music</li>
							<li>System</li>
						</ul>
					</td>
					<td width="75%" id="sytemcontent">
					</td>
				</tr>
			</table>
		</div>