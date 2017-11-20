<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Your Referrals - Remotestaff</title>
		<meta name="description" content="" />
		<meta name="author" content="Remotestaff Inc." />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		{include file="includes.tpl"}
		<script type="text/javascript" src="/portal/jobseeker/js/jquery.validate.min.js"></script>

		<script type="text/javascript" src="/portal/jobseeker/js/utils.js"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/referral.js"></script>

	</head>

	<body>
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar_no_box.tpl"}

				<div class="span10" id="main-content-body">
					<div class="container-fluid">
						<h2 class="jobseeker-header">Refer a Friend</h2>
						<p>
							Do you know any one who might be interested to apply? We offer 500 Pesos incentive for back office admin referrals and 1000 Pesos incentive to IT Professional Referrals. (Optional)
						</p>
						<p style="font-size:0.95em">
							<strong><small><label class="label label-important">Note: </label> Referral fee will be paid out once your referred candidate works with us for a month minimum.</small></strong>
						</p>

						<form class="well" id="refer-friend">
							{if $success eq "true"}
							<div class="alert alert-success">
								<strong>Well done!</strong> You have successfully referred a friend
							</div>
							{/if}
							<div class="row-fluid header">
								<div class="span2">
									<strong>First Name</strong>
								</div>
								<div class="span2">
									<strong>Last Name</strong>
								</div>
								<div class="span3">
									<strong>Current Position</strong>
								</div>
								<div class="span3">
									<strong>Email Address</strong>
								</div>
								<div class="span2">
									<strong>Contact Number</strong>
								</div>

							</div>
							<div class="row-fluid">
								<div class="span2">
									<div class="row-fluid">
										<input type="text" name="firstname[]" class="span12 first-name" placeholder="Enter First Name"/>
									</div>
								</div>
								<div class="span2">
									<div class="row-fluid">
										<input type="text" name="lastname[]" class="span12 lastname" placeholder="Enter Last Name"/>
									</div>
								</div>
								<div class="span3">
									<div class="row-fluid">
										<div class="input-append btn-group span11">
											<input class="span12 position" name="position[]" type="text" placeholder="Enter or Select Job Position">
											<a class="btn dropdown-toggle" data-toggle="dropdown" href="#" style="margin-left:-4px;"> <span class="caret"></span> </a>
											<ul class="dropdown-menu text-dropdown" style="max-height: 300px; overflow-y: auto;width:110%">
												{foreach from=$categories item=category}
												<li>
													<strong>{$category.category.name}</strong>
												</li>
												{foreach from=$category.subcategories item=subcategory}
												<li data-value="{$subcategory.singular_name}">
													<a href="#" data-value="{$subcategory.singular_name}">{$subcategory.singular_name}</a>
												</li>
												{/foreach}
												{/foreach}
											</ul>
										</div>

									</div>
								</div>

								<div class="span3">
									<div class="row-fluid">
										<input type="text" name="emailaddress[]" class="span12 emailaddress" placeholder="Enter Current Email Address"/>
									</div>
								</div>
								<div class="span2">
									<div class="row-fluid">
										<input type="text" name="contactnumber[]" class="span12 contactnumber" placeholder="Enter Contact #"/>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span2">
									<div class="row-fluid">
										<input type="text" name="firstname[]" class="span12 first-name" placeholder="Enter First Name"/>
									</div>
								</div>
								<div class="span2">
									<div class="row-fluid">
										<input type="text" name="lastname[]" class="span12 lastname" placeholder="Enter Last Name"/>
									</div>
								</div>
								<div class="span3">
									<div class="row-fluid">
										<div class="input-append btn-group span11">
											<input class="span12 position" name="position[]" type="text" placeholder="Enter or Select Job Position">
											<a class="btn dropdown-toggle" data-toggle="dropdown" href="#" style="margin-left:-4px;"> <span class="caret"></span> </a>
											<ul class="dropdown-menu text-dropdown" style="max-height: 300px; overflow-y: auto;width:110%">
												{foreach from=$categories item=category}
												<li>
													<strong>{$category.category.name}</strong>
												</li>
												{foreach from=$category.subcategories item=subcategory}
												<li data-value="{$subcategory.singular_name}">
													<a href="#" data-value="{$subcategory.singular_name}">{$subcategory.singular_name}</a>
												</li>
												{/foreach}
												{/foreach}
											</ul>
										</div>
									</div>
								</div>

								<div class="span3">
									<div class="row-fluid">
										<input type="text" name="emailaddress[]" class="span12 emailaddress" placeholder="Enter Current Email Address"/>
									</div>
								</div>
								<div class="span2">
									<div class="row-fluid">
										<input type="text" name="contactnumber[]" class="span12 contactnumber" placeholder="Enter Contact #"/>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span2">
									<div class="row-fluid">
										<input type="text" name="firstname[]" class="span12 first-name" placeholder="Enter First Name"/>
									</div>
								</div>
								<div class="span2">
									<div class="row-fluid">
										<input type="text" name="lastname[]" class="span12 lastname" placeholder="Enter Last Name"/>
									</div>
								</div>
								<div class="span3">
									<div class="row-fluid">
										<div class="input-append btn-group span11">
											<input class="span12 position" name="position[]" type="text" placeholder="Enter or Select Job Position">
											<a class="btn dropdown-toggle" data-toggle="dropdown" href="#" style="margin-left:-4px;"> <span class="caret"></span> </a>
											<ul class="dropdown-menu text-dropdown" style="max-height: 300px; overflow-y: auto;width:110%">
												{foreach from=$categories item=category}
												<li>
													<strong>{$category.category.name}</strong>
												</li>
												{foreach from=$category.subcategories item=subcategory}
												<li data-value="{$subcategory.singular_name}">
													<a href="#" data-value="{$subcategory.singular_name}">{$subcategory.singular_name}</a>
												</li>
												{/foreach}
												{/foreach}
											</ul>
										</div>
									</div>
								</div>

								<div class="span3">
									<div class="row-fluid">
										<input type="text" name="emailaddress[]" class="span12 emailaddress" placeholder="Enter Current Email Address"/>
									</div>
								</div>
								<div class="span2">
									<div class="row-fluid">
										<input type="text" name="contactnumber[]" class="span12 contactnumber" placeholder="Enter Contact #"/>
									</div>
								</div>

							</div>
							<div class="row-fluid">
								<div class="span12" style="text-align: center">
									<button class="btn btn-primary">
										Add Referral/s
									</button>
								</div>

							</div>
						</form>

						<h4>My Referrals</h4>

						<table class="table table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Position</th>
									<th>Email Address</th>
									<th>Mobile Number</th>
									<th>Application Status</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$referrals item=referral name=referral_list}
								<tr>
									<td> {$smarty.foreach.referral_list.iteration} </td>
									<td> {$referral.firstname} {$referral.lastname} </td>
									<td> {$referral.position} </td>
									<td><a href="mailto:{$referral.email}">{$referral.email}</a></td>
									<td>{$referral.contactnumber}</td>
									<td>{$referral.application_status}</td>
									<td><a href="/portal/jobseeker/delete_referral.php?id={$referral.id}" class="btn btn-danger delete_referral">Delete</a></td>
								</tr>
								{/foreach}
							</tbody>
						</table>

					</div>

				</div>

			</div>

			{include file="footer.tpl"}
		</div>
	</body>
</html>