<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>

<style>
	img#cimg {
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}

	img#cimg2 {
		height: 50vh;
		width: 100%;
		object-fit: contain;
		/* border-radius: 100% 100%; */
	}
</style>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<h5 class="card-title">System Information</h5>
			<!-- <div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_department" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
			</div> -->
		</div>
		<div class="card-body">
			<form action="" id="system-frm">
				<div id="msg" class="form-group"></div>
				<div class="form-group">
					<label for="name" class="control-label">System Name</label>
					<input type="text" class="form-control form-control-sm" name="name" id="name" value="<?php echo $_settings->info('name') ?>">
				</div>
				<div class="form-group">
					<label for="short_name" class="control-label">System Short Name</label>
					<input type="text" class="form-control form-control-sm" name="short_name" id="short_name" value="<?php echo  $_settings->info('short_name') ?>">
				</div>
				<div class="form-group">
					<label for="" class="control-label">About Us</label>
					<textarea name="about_us" id="" cols="30" rows="2" class="form-control summernote"><?php echo  is_file(base_app . 'about.html') ? file_get_contents(base_app . 'about.html') : "" ?></textarea>
				</div>
				<div class="form-group">
					<label for="" class="control-label">System Logo</label>
					<div class="custom-file">
						<input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
						<label class="custom-file-label" for="customFile">Choose file</label>
					</div>
				</div>
				<div class="form-group d-flex justify-content-center">
					<img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
				<div class="form-group">
					<label for="" class="control-label">Website Cover Images (For Carousel)</label>
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="coverInput" name="cover[]" multiple onchange="displayCovers(this,$(this))">
						<label class="custom-file-label" for="coverInput">Choose files</label>
					</div>
				</div>
				<div class="form-group d-flex justify-content-center flex-wrap" id="cover-previews">
					<?php
					$covers = $_settings->info('cover') ? json_decode($_settings->info('cover'), true) : [];
					if (is_array($covers) && !empty($covers)) :
						foreach ($covers as $cover) :
					?>
							<div class="cover-preview-container m-2">
								<img src="<?php echo validate_image($cover) ?>" alt="" class="img-fluid img-thumbnail" style="height: 150px;">
							</div>
						<?php
						endforeach;
					else :
						// Handle case where cover is still a single image
						$single_cover = $_settings->info('cover');
						if ($single_cover) :
						?>
							<img src="<?php echo validate_image($single_cover) ?>" alt="" id="cimg2" class="img-fluid img-thumbnail">
					<?php endif;
					endif; ?>
				</div>
			</form>
		</div>
		<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary" form="system-frm">Update</button>
				</div>
			</div>
		</div>

	</div>
</div>
<script>
	function displayCovers(input, _this) {
		if (input.files && input.files.length > 0) {
			// Display file count in label
			_this.siblings('.custom-file-label').html(input.files.length + ' files selected');

			// Clear existing preview
			$('#cover-previews').html('');

			// Create preview for each file
			for (let i = 0; i < input.files.length; i++) {
				let reader = new FileReader();
				reader.onload = function(e) {
					$('#cover-previews').append(
						'<div class="cover-preview-container m-2">' +
						'<img src="' + e.target.result + '" class="img-fluid img-thumbnail" style="height: 150px;">' +
						'</div>'
					);
				}
				reader.readAsDataURL(input.files[i]);
			}
		}
	}

	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#cimg').attr('src', e.target.result);
				_this.siblings('.custom-file-label').html(input.files[0].name)
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	function displayImg2(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				_this.siblings('.custom-file-label').html(input.files[0].name)
				$('#cimg2').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	function displayImg3(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				_this.siblings('.custom-file-label').html(input.files[0].name)
				$('#cimg3').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	$(document).ready(function() {
		$('.summernote').summernote({
			height: 200,
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ol', 'ul', 'paragraph', 'height']],
				['table', ['table']],
				['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
			]
		})
	})
</script>