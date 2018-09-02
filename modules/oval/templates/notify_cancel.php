<?php 
	$pets = get_field('booking_additional_pets',$post->ID);
	$pets = explode(',', $pets);

	//Fullname
	$first_name = get_usermeta($user['ID'],'first_name',true);
	$last_name = get_usermeta($user['ID'],'last_name',true);
	$fullname = $first_name.' '.$last_name;
	$tmp = str_replace(' ','',$fullname);
	if($tmp==''){
		$fullname = $user['display_name'];
	}
?>

[triangle_gravity request="notify" logo="wp-content/uploads/2017/08/logo.png" address="52a Frenchs Road Willoughby NSW 2068 p: 02) 9958 3363 f: 02) 9958 2267" contact="enquiries@divinecreatures.com.au, http://www.divinecreatures.com.au"]
	[triangle_section]
		[triangle_row]
			[triangle_column]
				[triangle_title]Booking Cancelation[/triangle_title]
				<p>Dear, <?= $fullname ?></p>
				<p>We are sorry to see you have cancelled 
					<?php foreach($pets as $pet){
						$pet = get_post($pet);
						echo $pet->post_title.' ';
					} ?>
					holiday plans.
				</p>
				<p>We hope we see <?php foreach($pets as $pet) echo $pet->post_title.' '; ?>again for a holiday in the near future.</p>
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
