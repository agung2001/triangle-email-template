
		
		<!-- Email Footer : BEGIN -->
		<table role="presentation" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
			<tr>
				<td style="font-size:11px; text-align:center; line-height:18px; color: #888888;" class="x-gmail-data-detectors">
					<?php 
						$theme_default_footer = get_option('triangle_theme_footer');
						if($theme_default_footer){
							echo $theme_default_footer;
						} else {
					?>
						Powered by <a href="https://applebydesign.com.au">ApplebyDesign</a>
					<?php } ?>
				</td>
			</tr>
		</table>
		<!-- Email Footer : END -->

		<!--[if mso]>
		</td>
		</tr>
		</table>
		<![endif]-->
	</div>
</body>
</html>