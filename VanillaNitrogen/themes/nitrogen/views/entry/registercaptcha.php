<?php if (!defined('APPLICATION')) exit(); ?>
<div class="FormTitleWrapper">
<h1><?php echo T("Apply for Membership") ?></h1>
<div class="FormWrapper">



<?php //  111111111111111111111111111111111  ?>	

   <?php // Change terms url to your TGB wiki page's url.
   $TermsOfServiceUrl = 'http://YOURSITE.COM/YOURTBGfolder/thebuggenie/wiki/TermsOfUse';
   $TermsOfServiceText = sprintf(T('I agree to the <a id="TermsOfService" target="terms" href="%s">terms of use</a>'), Url($TermsOfServiceUrl));
   
   
   
   $CaptchaPublicKey = Gdn::Config('Garden.Registration.CaptchaPublicKey');
   $Request = Gdn::Request();
   $CaptchaSSL = (StringBeginsWith(Url('/', TRUE), 'https') || Gdn::Request()->GetValueFrom(Gdn_Request::INPUT_SERVER, 'SERVER_PORT') == 443) ? TRUE : FALSE;
   
   // Make sure to force this form to post to the correct place in case the view is
   // rendered within another view (ie. /dashboard/entry/index/):
   echo $this->Form->Open(array('Action' => Url('/entry/register'), 'id' => 'Form_User_Register'));
   echo $this->Form->Errors();
   ?>
   <ul>
      <?php if (!$this->Data('NoEmail')): ?>
      <li>
         <?php
            echo $this->Form->Label('Email', 'Email');
            echo $this->Form->TextBox('Email', array('type' => 'email', 'Wrap' => TRUE));
				echo '<span id="EmailUnavailable" class="Incorrect" style="display: none;">'.T('Email Unavailable').'</span>';
         ?>
      </li>
      <?php endif; ?>
      <li>
         <?php
            echo $this->Form->Label('Username', 'Name');
            echo $this->Form->TextBox('Name', array('autocorrect' => 'off', 'autocapitalize' => 'off', 'Wrap' => TRUE));
            echo '<span id="NameUnavailable" class="Incorrect" style="display: none;">'.T('Name Unavailable').'</span>';
         ?>
      </li>
      <?php $this->FireEvent('RegisterBeforePassword'); ?>
      <li>
         <?php
            echo $this->Form->Label('Password', 'Password');
            echo Wrap(sprintf(T('Your password must be at least %d characters long.'), C('Garden.Registration.MinPasswordLength')), 'div', array('class' => 'Gloss')); 
            echo $this->Form->Input('Password', 'password', array('Wrap' => TRUE, 'Strength' => TRUE));
         ?>
      </li>
      <li>
         <?php
            echo $this->Form->Label('Confirm Password', 'PasswordMatch');
            echo $this->Form->Input('PasswordMatch', 'password', array('Wrap' => TRUE));
            echo '<span id="PasswordsDontMatch" class="Incorrect" style="display: none;">'.T("Passwords don't match").'</span>';
         ?>
      </li>
      <li class="Gender">
         <?php
            echo $this->Form->Label('Gender', 'Gender');
            echo $this->Form->RadioList('Gender', $this->GenderOptions, array('default' => 'u'))
         ?>
      </li>
      <?php if ($this->Form->GetValue('DiscoveryText') || GetValue('DiscoveryText', $this->Form->ValidationResults()) ): ?>
      <li>
         <?php
            echo $this->Form->Label('Why do you want to join?', 'DiscoveryText');
            echo $this->Form->TextBox('DiscoveryText', array('MultiLine' => TRUE, 'Wrap' => TRUE));
         ?>
      </li>
      <?php endif; ?>
      <li class="CaptchaInput">
      <?php
         echo $this->Form->Label("Security Check", '');
         echo recaptcha_get_html($CaptchaPublicKey, NULL, $CaptchaSSL);
      ?></li>
      <?php $this->FireEvent('RegisterFormBeforeTerms'); ?>
      <li>
         <?php
            echo $this->Form->CheckBox('TermsOfService', '@'.$TermsOfServiceText, array('value' => '1'));
            echo $this->Form->CheckBox('RememberMe', T('Remember me on this computer'), array('value' => '1'));
         ?>
      </li>
      <li class="Buttons">
         <?php echo $this->Form->Button('Sign Up', array('class' => 'Button Primary')); ?>
      </li>
   </ul>
   <?php echo $this->Form->Close(); ?>
</div>
</div>