<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$formId = 'feedback_form_' . $this->randString();
?>

<?if(!empty($arResult["ERROR_MESSAGE"])):?>
    <div class="alert alert-danger" role="alert" aria-live="polite">
        <?foreach($arResult["ERROR_MESSAGE"] as $error):?>
            <div><?=htmlspecialcharsbx($error)?></div>
        <?endforeach;?>
    </div>
<?endif;?>

<?if($arResult["OK_MESSAGE"] <> ''):?>
    <div class="alert alert-success mf-ok-text" role="alert" aria-live="polite">
        <?=htmlspecialcharsbx($arResult["OK_MESSAGE"])?>
    </div>
<?endif;?>

<form class="mt--40 feedback-form" id="<?=$formId?>" action="<?=POST_FORM_ACTION_URI?>" method="POST" novalidate>
	<?=bitrix_sessid_post()?>
	<div class="row">
		<div class="col-lg-6 col-md-12 col-12">
			<div class="rnform-group">
				<label for="user_name_<?=$formId?>" class="visually-hidden"><?=GetMessage("MFT_NAME")?></label>
				<input type="text" 
					   id="user_name_<?=$formId?>"
					   name="user_name" 
					   value="<?=htmlspecialcharsbx($arResult["AUTHOR_NAME"])?>" 
					   placeholder="<?=GetMessage("MFT_NAME")?>" 
					   required
					   minlength="2"
					   maxlength="50"
					   aria-required="true"
					   aria-invalid="false"
					   data-validation="name">
				<div class="form-error" role="alert" aria-live="polite"></div>
			</div>

			<div class="rnform-group">
				<label for="user_phone_<?=$formId?>" class="visually-hidden"><?=GetMessage("MFT_PHONE")?></label>
				<input class="phone" 
					   id="user_phone_<?=$formId?>"
					   type="tel" 
					   name="user_phone" 
					   value="<?=htmlspecialcharsbx($arResult["AUTHOR_PHONE"])?>" 
					   placeholder="+7 (999) 999-99-99" 
					   required
					   pattern="\+7\s?[\(]{0,1}9[0-9]{2}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}"
					   aria-required="true"
					   aria-invalid="false"
					   data-validation="phone">
				<div class="form-error" role="alert" aria-live="polite"></div>
			</div>
		</div>

		<?if($arParams["USE_CAPTCHA"] == "Y"):?>
			<div class="col-lg-12">
				<div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
				<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["capCode"])?>">
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["capCode"])?>" 
					 width="180" 
					 height="40" 
					 alt="CAPTCHA"
					 loading="lazy">
				<div class="mf-text">
					<label for="captcha_word_<?=$formId?>"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></label>
				</div>
				<input class="blog-btn" 
					   id="captcha_word_<?=$formId?>"
					   type="text" 
					   name="captcha_word" 
					   size="30" 
					   maxlength="50" 
					   value=""
					   required
					   aria-required="true"
					   aria-invalid="false"
					   data-validation="captcha">
				<div class="form-error" role="alert" aria-live="polite"></div>
			</div>
		<?endif;?>

		<input type="hidden" name="PARAMS_HASH" value="<?=htmlspecialcharsbx($arResult["PARAMS_HASH"])?>">
		<button type="submit" name="submit" class="btn-default" aria-label="<?=GetMessage("MFT_SUBMIT")?>">
			<span class="btn-text"><?=GetMessage("MFT_SUBMIT")?></span>
			<span class="btn-loader" aria-hidden="true">
				<svg class="spinner" viewBox="0 0 50 50">
					<circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
				</svg>
			</span>
		</button>
	</div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
	const form = document.getElementById('<?=$formId?>');
	const closeMess = document.querySelector(".mf-ok-text");
	const submitBtn = form.querySelector('button[type="submit"]');
	const btnText = submitBtn.querySelector('.btn-text');
	const btnLoader = submitBtn.querySelector('.btn-loader');
	
	// Form validation
	const validateField = (field) => {
		const errorDiv = field.parentElement.querySelector('.form-error');
		let isValid = true;
		let errorMessage = '';
		
		if (field.hasAttribute('required') && !field.value.trim()) {
			isValid = false;
			errorMessage = '<?=GetMessage("MFT_REQUIRED_FIELD")?>';
		} else if (field.dataset.validation === 'name' && field.value.length < 2) {
			isValid = false;
			errorMessage = '<?=GetMessage("MFT_NAME_TOO_SHORT")?>';
		} else if (field.dataset.validation === 'phone' && !field.checkValidity()) {
			isValid = false;
			errorMessage = '<?=GetMessage("MFT_PHONE_INVALID")?>';
		}
		
		field.setAttribute('aria-invalid', !isValid);
		errorDiv.textContent = errorMessage;
		return isValid;
	};
	
	// Form submission
	if (form) {
		form.addEventListener('submit', function(e) {
			e.preventDefault();
			
			// Validate all fields
			const fields = form.querySelectorAll('input[required]');
			let isFormValid = true;
			
			fields.forEach(field => {
				if (!validateField(field)) {
					isFormValid = false;
				}
			});
			
			if (!isFormValid) {
				return;
			}
			
			// Show loading state
			submitBtn.disabled = true;
			btnText.style.display = 'none';
			btnLoader.style.display = 'block';
			
			// Submit form
			const formData = new FormData(form);
			
			BX.ajax.submit(form, function(response) {
				// Handle response
				submitBtn.disabled = false;
				btnText.style.display = 'block';
				btnLoader.style.display = 'none';
				
				if (response.status === 'success') {
					form.reset();
					// Show success message
					const successDiv = document.createElement('div');
					successDiv.className = 'alert alert-success';
					successDiv.setAttribute('role', 'alert');
					successDiv.setAttribute('aria-live', 'polite');
					successDiv.textContent = '<?=GetMessage("MFT_SUCCESS_MESSAGE")?>';
					form.parentElement.insertBefore(successDiv, form);
					
					// Facebook conversion
					if (form.elements && 
						form.elements['user_email'] &&
						form.elements['user_phone'] &&
						form.elements['user_phone'].value && 
						form.elements['user_site']) {
						BX.ajax.runAction('sale.facebookconversion.contact', {
							data: {contactBy: form.elements['user_email'].value}
						});
					}
				} else {
					// Show error message
					const errorDiv = document.createElement('div');
					errorDiv.className = 'alert alert-danger';
					errorDiv.setAttribute('role', 'alert');
					errorDiv.setAttribute('aria-live', 'polite');
					errorDiv.textContent = '<?=GetMessage("MFT_ERROR_MESSAGE")?>';
					form.parentElement.insertBefore(errorDiv, form);
				}
			});
		});
		
		// Real-time validation
		form.querySelectorAll('input').forEach(field => {
			field.addEventListener('blur', () => validateField(field));
			field.addEventListener('input', () => {
				field.setAttribute('aria-invalid', 'false');
				field.parentElement.querySelector('.form-error').textContent = '';
			});
		});
	}
	
	// Close message handler
	if (closeMess) {
		closeMess.addEventListener("click", function() {
			this.style.display = "none";
		});
	}
});
</script>

<style>
.visually-hidden {
	position: absolute;
	width: 1px;
	height: 1px;
	padding: 0;
	margin: -1px;
	overflow: hidden;
	clip: rect(0, 0, 0, 0);
	white-space: nowrap;
	border: 0;
}

.form-error {
	color: #dc3545;
	font-size: 0.875rem;
	margin-top: 0.25rem;
}

.btn-loader {
	display: none;
}

.spinner {
	animation: rotate 2s linear infinite;
	width: 20px;
	height: 20px;
}

.spinner .path {
	stroke: currentColor;
	stroke-linecap: round;
	animation: dash 1.5s ease-in-out infinite;
}

@keyframes rotate {
	100% {
		transform: rotate(360deg);
	}
}

@keyframes dash {
	0% {
		stroke-dasharray: 1, 150;
		stroke-dashoffset: 0;
	}
	50% {
		stroke-dasharray: 90, 150;
		stroke-dashoffset: -35;
	}
	100% {
		stroke-dasharray: 90, 150;
		stroke-dashoffset: -124;
	}
}

input[aria-invalid="true"] {
	border-color: #dc3545;
}

.alert {
	padding: 1rem;
	margin-bottom: 1rem;
	border: 1px solid transparent;
	border-radius: 0.25rem;
}

.alert-danger {
	color: #721c24;
	background-color: #f8d7da;
	border-color: #f5c6cb;
}

.alert-success {
	color: #155724;
	background-color: #d4edda;
	border-color: #c3e6cb;
}
</style>