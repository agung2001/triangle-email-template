<?php 
	//Booking Fees
	$booking_paid = get_field('booking_paid',$post->ID);

	//Fullname
	$first_name = get_usermeta($user['ID'],'first_name',true);
	$last_name = get_usermeta($user['ID'],'last_name',true);
	$fullname = $first_name.' '.$last_name;
	$tmp = str_replace(' ','',$fullname);
	if($tmp==''){
		$fullname = $user['display_name'];
	}

	//Pets
	$pets = get_field('booking_additional_pets',$post->ID);
	$pets = $this->pet_lists($pets, $user['ID']);

?>

[triangle_gravity request="notify" logo="wp-content/uploads/2017/08/logo.png" address="52a Frenchs Road Willoughby NSW 2068 p: 02) 9958 3363 f: 02) 9958 2267" contact="enquiries@divinecreatures.com.au, http://www.divinecreatures.com.au"]
	[triangle_section]
		[triangle_row]
			[triangle_column]
				[triangle_title]Payment Confirmation[/triangle_title]
				<p>Dear <?= $fullname ?>, </p>
				<p>Thank you for checking 
					<?php foreach($pets as $pet){
						echo $pet->post_title.' ';
					} ?>
					for a holiday at Divine Creatures Luxury Cattery.
				</p>
				<p>Your booking fee for $<?= $booking_paid ?> has been received - Thank You.</p>
				<p>Please check the below details provided are correct, current and that you read and agree to the attached boarding Terms and Conditions.</p>
				<p>Please allow at least 20 minutes check in time to finalize the paperwork & settle your cat(s) into their room. </p>
				<p>You may wish to speed up check in times by emailing or faxing (0299582267) vaccination certificates and signed attached Terms and Conditions. </p>
				<p>T&C's can be signed directly from your mobile phone or ipad by using an app such as <a href="https://www.getsigneasy.com/">EasySign</a> By receiving this email, you are accepting the latest terms and conditions, even if old T&C's have been signed.</p>
			[/triangle_column]
		[/triangle_row]
	[/triangle_section]
	[triangle_section]
		[triangle_row]
			[triangle_column]
				[triangle_title]Terms & Conditions[/triangle_title]
				[triangle_media request="pdf" src="wp-content/uploads/2017/10/ico-pdf.png" url="wp-content/uploads/2018/08/Divine-Creatures-Terms-conditions-2018.pdf" style="max-width:600px; text-align:center;"] 
				<div style="text-align:center;"><span>Boarding Contracts</span></div><br>
				<p><b>* Please remember to bring your current vaccination certificate(s) & apply a topical flea treatment on the <?= get_field('booking_start',$post->ID) ?> prior to admissions</b></p>
				<p>All cats must be de-sexed and have a current F3, F4 or F5 vaccination. Documentation of vaccination must be sighted on or before admission. In accordance with our high standard of service & to protect our resort guests, admission will be refused if these requirements are not met.</p>
				<p>Please check the details below are correct. You may email us or call at any time to update your reservation details.</p>
				<p>This holiday is fully inclusive: *all meals, toys & bedding.</p>
				<p>*Cats will be fed the highest quality premium cat food of Royal Canin Sensible. Any other diet other than the one supplied by Divine Creatures or if your cat has special dietary needs e.g: Diabetic, Urinary Tract problems, Dietary sensitivity / allergy, we are happy to feed them these diets. You may purchase a bag through us or supply the diet yourself. Sufficient food must be supplied by you to feed your cat(s) for the whole period of stay. You will not be charged any extra for this service.</p>
				<p>Please do not hesitate to contact us, anytime, should you have any further questions.</p>
			[/triangle_column]
		[/triangle_row]
	[/triangle_section]
	[triangle_section]
		[triangle_row]
			[triangle_column]
				[triangle_title align="center"]Check in & Check out times[/triangle_title] <hr>
				<div style="text-align:center;">
					Monday - Friday: 8:30am to 4:30pm <br>
					Saturday: 9am to 2pm <br>
					Sundays: 11am to 3pm <hr>
				</div>
				<p>
					* We are CLOSED on public holidays <br>
					* Please note: We operate like a human hotel! <br>
					&nbsp;	- Check out is midday. <br>
					&nbsp;	- Check out between 12pm-3pm incurs a small late fee. <br>
					&nbsp;	- Check out after 3pm incurs an additional nights fee. <br>
				</p>
			[/triangle_column]
		[/triangle_row]
	[/triangle_section]
	[triangle_section]
		[triangle_row]
			[triangle_column size="2"]
				[triangle_title align="center"]Submission[/triangle_title]
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				[triangle_title]Admission & Accomodation[/triangle_title]
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Admission Type: 
			[/triangle_column]
			[triangle_column]
				<?php 
					$service = get_field('booking_service',$post->ID); 
					echo $service->post_title;
				?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Booking Number: 
			[/triangle_column]
			[triangle_column]
				<?= $post->post_title ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Booking Status: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('booking_status',$post->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Checkin: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('booking_start',$post->ID) ?><br>
				<?= get_field('booking_in',$post->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Checkout: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('booking_end',$post->ID) ?><br>
				<?= get_field('booking_out',$post->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Referral: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('booking_referral',$post->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Jungle Gym <br>
				Daily : 
			[/triangle_column]
			[triangle_column]
				<?php 
					$junglegym = get_field('booking_jungle_gym_daily',$post->ID); 
					if($junglegym) echo 'Yes';
					else echo 'No';
				?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Jungle Gym <br>
				Every Other Day : 
			[/triangle_column]
			[triangle_column]
				<?php 
					$junglegym = get_field('booking_jungle_gym_every_other_day',$post->ID); 
					if($junglegym) echo 'Yes';
					else echo 'No';
				?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				[triangle_title]Owner Details[/triangle_title]
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Full Name: 
			[/triangle_column]
			[triangle_column]
				<?= get_usermeta($user['ID'],'first_name',true) ?>
				<?= get_usermeta($user['ID'],'last_name',true) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Email: 
			[/triangle_column]
			[triangle_column]
				<?= $user['user_email'] ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Address: 
			[/triangle_column]
			[triangle_column]
				<?= get_user_meta($user['ID'],'billing_address_1',true) ?>, 
				<?= get_user_meta($user['ID'],'billing_city',true) ?> 
				<?= get_user_meta($user['ID'],'billing_state',true) ?> 
				<?= get_user_meta($user['ID'],'billing_postcode',true) ?> 
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Home Phone: 
			[/triangle_column]
			[triangle_column]
				<?= get_user_meta($user['ID'],'billing_phone',true) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Mobile Phone: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('user_mobile',$post->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				[triangle_title]Emergency Contact[/triangle_title]
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Name: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('booking_emergency_name',$post->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Number: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('booking_emergency_phone',$post->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Email: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('booking_emergency_email',$post->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				[triangle_title]Veterinarian Details[/triangle_title]
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Name of Practice: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('booking_veterinarian_name_of_practice',$post->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Name of Vet: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('booking_veterinarian_name_of_vet',$post->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Contact Number: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('booking_veterinarian_contact_number',$post->ID) ?>
			[/triangle_column]
		[/triangle_row]
	<?php 
		$counter = 0;
		foreach($pets as $key => $pet): 
	?>
	[triangle_row]
		[triangle_column]
			[triangle_title]Pet <?= ++$counter; ?>[/triangle_title]
		[/triangle_column]
	[/triangle_row]
		[triangle_row]
			[triangle_column]
				Name: 
			[/triangle_column]
			[triangle_column]
				<?= $pet->post_title ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Breeds: 
			[/triangle_column]
			[triangle_column]
				<?php
					$terms = wp_get_post_terms($pet->ID,'pet_breeds');
					foreach($terms as $term)
						echo $term->name.' ';
				?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Sex: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('pet_sex',$pet->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Desexed: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('pet_desexed',$pet->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				DOB: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('pet_dob',$pet->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Last Vaccinated: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('pet_last_vaccinated',$pet->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Regular Flea Treatment: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('pet_regular_flea_treatment',$pet->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Flea Treatment Type: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('pet_flea_treatment_type',$pet->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Normal Feeding Time: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('pet_normal_feeding_time',$pet->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Preferred Diet AM: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('pet_preferred_diet_am',$pet->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Preferred Diet PM: 
			[/triangle_column]
			[triangle_column]
				<?= get_field('pet_preferred_diet_pm',$pet->ID) ?>
			[/triangle_column]
		[/triangle_row]
		[triangle_row]
			[triangle_column]
				Health Problems : 
			[/triangle_column]
			[triangle_column]
				<?= get_field('pet_health_problems_allergies_medications',$pet->ID) ?>
			[/triangle_column]
		[/triangle_row]
	<?php endforeach; ?>
	[/triangle_section]
	[triangle_section]
		[triangle_row]
			[triangle_column]
				<p>Kind Regards,</p>
				<p><b>Jules dos Santos</b><p>
				<p>Owner & founder of Divine Creatures <br>
				Veterinary Nurse & Professional Cat TLC therapist <br>
				Mum of rescued fur babies: Titan, Moon, Jonny, Jai & Karma</p>
				<p>
				Follow us on facebook: <a href="www.facebook.com/luxuryhotelforcats/">DivineCreatures</a><br>
				Help us grow! Recommend us: <a href="http://www.womo.com.au/reviews/Divine-Creatures-Willoughby/">Womo</a>			
				</p>
				<p>
					Signature logo new as seen on <br>
					[triangle_media request="image" src="wp-content/uploads/2017/10/thumbnail_image003.jpg" style="width:100%; text-align:center;"]
				</p>
			[/triangle_column]
		[/triangle_row]
	[/triangle_section]
[/triangle_gravity]
