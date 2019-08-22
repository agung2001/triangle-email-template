
		<!-- Email Footer : BEGIN -->
		<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 680px;">
			<tr>
				<td style="font-size:11px; text-align:center; line-height:18px; color: #888888;" class="x-gmail-data-detectors">
					If you prefer not to receive this email, please go 
					<u><a href="<?= $atts['unsubscribe'] ?>" target="_blank"><unsubscribe style="color:#888888; text-decoration:underline;">here</unsubscribe></a></u> to unsubscribe <br>
					<?php if(''!=$atts['address']): ?>
						<?= $atts['address'] ?><br>
						<?= $atts['contact'] ?><br>
						<?= $atts['follow'] ?>
					<?php endif; ?>
					&copy; <?= date('Y') ?> <?= get_bloginfo( 'name' ) ?>
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

    </center>
</body>
</html>