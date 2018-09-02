<?php 
	$pets = get_field('booking_additional_pets',$post->ID);
	$pets = explode(',', $pets);

	// Short Book Range
	$now = time();
	$booking_start = get_field('booking_start',$post->ID);
	$booking_start = str_replace('/', '-', $booking_start );
	$booking_start = strtotime($booking_start);
	$datediff = $booking_start - $now;
	$datediff = floor($datediff / (60 * 60 * 24));

	// Long Book Range
	if($datediff>5){
		$expired = strtotime($post->post_date. ' + 5 days');
		$datediff = $expired - $now;
		$datediff = floor($datediff / (60 * 60 * 24));
	}

	//Refundable Fees
	$booking_service = get_field('booking_service',$post->ID);
	if(isset($booking_service->ID)){
		$service_price = get_field('service_price',$booking_service->ID);
	} else {
		$service_price = get_field('service_price',$booking_service);
	}

	//Regen User Variable
	$user = get_field('booking_user',$post->ID);
	$user = !isset($user['ID']) ? (array)get_userdata($user)->data : $user;
	//Fullname
	$first_name = get_usermeta($user['ID'],'first_name',true);
	$last_name = get_usermeta($user['ID'],'last_name',true);
	$fullname = $first_name.' '.$last_name;
	$tmp = str_replace(' ','',$fullname);
	if($tmp==''){
		$fullname = $user['display_name'];
	}

	if($datediff<=0) $datediff = 0;
	if($datediff<5) $warn = 'red'; else $warn = 'black';
?>

[triangle_gravity request="notify" logo="wp-content/uploads/2017/08/logo.png" address="52a Frenchs Road Willoughby NSW 2068 p: 02) 9958 3363 f: 02) 9958 2267" contact="enquiries@divinecreatures.com.au, http://www.divinecreatures.com.au"]
	[triangle_section]
		[triangle_row]
			[triangle_column]
				[triangle_title]Booking Pending[/triangle_title]
				<p>Dear, <?= $fullname ?></p>
				<p>Thank you for booking your cat(s) in for a holiday at Divine Creatures Luxury Cat Hotel!</p>
				<p>This email is to confirmed we have received your reservation. From here we just require a non refundable/non transferable booking fee of $<?= $service_price ?> to complete the booking. Should you proceed with the booking, this fee will be deducted from your invoice upon check in on the <?= get_field('booking_start',$post->ID) ?></p>
			<?php if($datediff>0): ?>
				<p style="color:<?= $warn ?>;">This booking will be <b>held for <?= $datediff ?> days</b>. In order not to disadvantage our other guests, your booking will be <u>canceled</u> if we do not receive the booking fee with in <?= $datediff ?> days.</p>
			<?php endif; ?>
				<p>To leave the booking fee payment, we have several options for your convenience:</p>
				<p>1) Complete the online payment. [encrypted by https using National Australia Bank gateway for your highest security & protection] </p>
				<p>2) Telephone payments: Call 02 9958 3363 & one of our friendly staff will assist you </p>
				<p>3) Direct Deposit: Name: JDSSM PTY LTD   BSB: 06 2336 AC: 1034 5193  [please use your reservation number as reference for payment]</p>
				</p>
				<p>Once your booking fee has been cleared, you will received a booking confirmation email.</p>
			[/triangle_column]
		[/triangle_row]
	[/triangle_section]
	[triangle_section]
		[triangle_row]
			[triangle_column]
				[triangle_title]Terms & Conditions[/triangle_title]
				[triangle_media request="pdf" src="wp-content/uploads/2017/10/ico-pdf.png" url="wp-content/uploads/2018/08/Divine-Creatures-Terms-conditions-2018.pdf" style="max-width:600px; text-align:center;"] 
				<div style="text-align:center;"><span>Boarding Contracts</span></div><br>
				<p>Please read the attached boarding terms and conditions. By receiving this email, you are accepting the latest terms and conditions, even if old T&C's have been signed. </p>
				<p>All cats must be de-sexed and have a current F3, F4 or F5 vaccination. Documentation of vaccination must be sighted on or before admission. In accordance with our high standard of service & to protect our resort guests, admission will be refused if these requirements are not met.</p>
				<p>* Cats will be fed the highest quality premium cat food of Royal Canin Sensible. Any other diet other than the one supplied by Divine Creatures or if your cat has special dietary needs e.g: Diabetic, Urinary Tract problems, Dietary sensitivity / allergy, we are happy to feed them these diets. You may purchase a bag through us or supply the diet yourself. Sufficient food must be supplied by you to feed your cat(s) for the whole period of stay. You will not be charged any extra for this service.</p>
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
					$service = get_post($service);
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
				<?= get_user_meta($user['ID'],'billing_address_1',true) ?>
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
				[triangle_title]Veteranian Details[/triangle_title]
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
	<?php foreach($pets as $key => $pet): ?>
	<?php $pet = get_post($pet); ?>
	[triangle_row]
		[triangle_column]
			[triangle_title]Pet <?= $key+1 ?>[/triangle_title]
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
