<?php 
/************************************************************
 * DESIGNERS: SCROLL DOWN! (IGNORE ALL THIS STUFF AT THE TOP)
 ************************************************************/
defined('C5_EXECUTE') or die("Access Denied.");
use \Concrete\Block\Form\MiniSurvey;

$survey = $controller;
$miniSurvey = new MiniSurvey($b);
$miniSurvey->frontEndMode = true;

//Clean up variables from controller so html is easier to work with...
$bID = intval($bID);
$qsID = intval($survey->questionSetId);
$formAction = $view->action('submit_form').'#formblock'.$bID;

$questionsRS = $miniSurvey->loadQuestions($qsID, $bID);
$questions = array();
while ($questionRow = $questionsRS->fetchRow()) {
	$question = $questionRow;
	$question['input'] = $miniSurvey->loadInputType($questionRow, false);
	
	//Make type names common-sensical
	if ($questionRow['inputType'] == 'text') {
		$question['type'] = 'textarea';
	} else if ($questionRow['inputType'] == 'field') {
		$question['type'] = 'text';
	} else {
		$question['type'] = $questionRow['inputType'];
	}

    	$question['labelFor'] = 'for="Question' . $questionRow['msqID'] . '"';
	
	//Remove hardcoded style on textareas
	if ($question['type'] == 'textarea') {
		$question['input'] = str_replace('style="width:95%"', '', $question['input']);
	}
	
	$questions[] = $question;
}

//Prep thank-you message
$success = (\Request::request('surveySuccess') && \Request::request('qsid') == intval($qsID));
$thanksMsg = $survey->thankyouMsg;

//Collate all errors and put them into divs
$errorHeader = isset($formResponse) ? $formResponse : null;
$errors = isset($errors) && is_array($errors) ? $errors : array();
if (isset($invalidIP) && $invalidIP) {
	$errors[] = $invalidIP;
}
$errorDivs = '';
foreach ($errors as $error) {
	$errorDivs .= '<div class="error">'.$error."</div>\n"; //It's okay for this one thing to have the html here -- it can be identified in CSS via parent wrapper div (e.g. '.formblock .error')
}

//Prep captcha
$surveyBlockInfo = $miniSurvey->getMiniSurveyBlockInfoByQuestionId($qsID, $bID);
$captcha = $surveyBlockInfo['displayCaptcha'] ? Loader::helper('validation/captcha') : false;

/******************************************************************************
* DESIGNERS: CUSTOMIZE THE FORM HTML STARTING HERE...
*/?>

<div id="formblock<?php  echo $bID; ?>">
    <form enctype="multipart/form-data" class="hc-form" id="miniSurveyView<?php  echo $bID; ?>" method="post" action="<?php  echo $formAction ?>">

        <?php if ($success): ?>

        <div class="hc-alert hc-alert-success">
			<i class="fa fa-info-circle"></i>
            <?php echo h($thanksMsg); ?>
        </div>

        <?php elseif ($errors): ?>

		<div class="hc-alert hc-alert-error">
			<i class="fa fa-exclamation-circle"></i>
            <?php echo $errorHeader; ?>
            <?php echo $errorDivs; /* each error wrapped in <div class="error">...</div> */ ?>
</div>

<?php endif; ?>


<div class="hc-fields-container">

    <?php foreach ($questions as $question): ?>
    <div class="hc-form-group hc-field hc-field-<?php  echo $question['type']; ?> <?php echo isset($errorDetails[$question['msqID']]) ? 'has-error' : ''?>">
    <?php echo $question[ 'input']; ?>
		<label class="hc-field-label" <?php echo $question[ 'labelFor']; ?>>
            <?php echo $question[ 'question']; ?>
            <?php if ($question[ 'required']): ?>
            <span class="text-muted small" style="font-weight: normal"><?php echo t("Required")?></span>
            <?php endif; ?>
		</label>
    </div>
    <?php endforeach; ?>

</div>
<!-- .fields -->

<?php if ($captcha): ?>
<div class="row">
	<div class="xs-12 sm-8 md-9 hc-captcha-input">
		<div class="hc-form-group hc-captcha">
			<?php $captcha->showInput(); ?>
			<?php $captchaLabel = $captcha->label(); if (!empty($captchaLabel)) { ?>
			<label class="hc-field-label">
				<?php echo $captchaLabel; ?>
			</label>
			<?php } ?>
		</div>
	</div>
	<div class="xs-12 sm-4 md-3 hc-captcha-img">
		<?php $captcha->display(); ?>
	</div>
</div>
<?php endif; ?>

<div class="hc-form-actions">
    <input type="submit" name="Submit" class="btn btn-primary" value="<?php  echo h(t($survey->submitText)); ?>" />
</div>

<input name="qsID" type="hidden" value="<?php  echo $qsID; ?>" />
<input name="pURI" type="hidden" value="<?php  echo isset($pURI) ? $pURI : ''; ?>" />

</form>
</div>
<!-- .formblock -->

<script>
$(function() {
    $('.form-control').on('change', function(){
		if($(this).val()){
			$(this).closest('.hc-form-group').addClass('active');;
		}else{
			$(this).closest('.hc-form-group').removeClass('active');;
		}
	}).on('focus', function(){
		$(this).closest('.hc-form-group').addClass('active');
	}).blur(function(){
		if(!$(this).val()){
			$(this).closest('.hc-form-group').removeClass('active');
		}
	});
	$('.form-control').filter(function() {
		return this.value;
	}).closest('.hc-form-group').addClass('active');
});
</script>