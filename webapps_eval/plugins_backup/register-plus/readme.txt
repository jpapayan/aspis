=== Register Plus ===
Contributors: skullbit
Donate link: http://skullbit.com/donate
Tags: register, registration, password, invitation, code, invite, disclaimer, captcha, email, validation, recaptcha, privacy, policy, license, agreement, logo, moderation, user
Requires at least: 2.5
Tested up to: 2.6
Stable tag: 3.5.1

Enhance your Registration Page.  Add Custom Logo, Password Field, Invitation Codes, Disclaimers, CAPTCHA Validation, Email Validation, User Moderation, Profile Fields and more.

== Description ==

Enhance your Registration Page.

**Custom Logo**
Tired of that WordPress logo getting all the attention?  Upload your own custom logo image and get your brand in the spotlight.

**Password Field**
Hate those forgettable auto-generated passwords? Allow your users to set their own prefered password during registration. Includes that sweet Password Strength Meter from the Profile page. 

**Invitation Codes**
Is your blog super exclusive?  If so, you better require an invite to join your high end crew.  Setup multiple codes and track where your new users are coming from with the optional Invitation Tracking Dashboard Widget.

**Disclaimers**
Worried about legal liabilities?  Setup a general disclaimer, licence agreement and/or privacy policy for new users to agree to during registration.

**Captcha Validation**
Hate spam? If you don't want those spam bots registering with their very own passwords, you need some protection.  Includes a simple captcha easy enough for real humans to read as well as the ability to add a <a href="http://recaptcha.net">reCAPTCHA</a>.

**Email Validation**
Hate fake emails?  Make sure your users are not registering with invalid email accounts by forcing them to click a validation link that's sent out with their registration email.  This sets there username to a random generated string (something like: 'unverified__h439herld3') so they can't login until they hit that validation link which will put their real username back in place allowing them to login as per usual.  Unverified registrations have a defined grace period that will automatically delete an unverified account after a specified period of time, so you don't get clogged up with those fakies. (Manage under Users > Unverified Users)

**User Moderation**
Need absolute control?  Check out every new user yourself and hand pick who can stay and who gets the boot before they are able to login to your site. (Manage under Users > Unverified Users)

**Profile Fields**
Want more done sooner?  Have new users fill out there entire profile or just bits you need all during registration, you can even make them required.  

**User Defined Fields** 
Not enough info yet?  Add your own defined fields to the registration page for users to fill out.  It also adds the new fields to the profile page as well so current users can add their own info and update as needed. Now includes the abililty to add date, select, checkbox, radio and textarea fields!

**Duplicate Email Registration**
Got multiple users using the same email address?  Easily solve this prediciment without forcing them to sign up with unneeded email accounts. Also useful for administrators to create another account with one email address.

**Customized Admin & User Registration Email**
Tired of the same old emails when someone new registers?  Spice it up with your own From/Reply-To address, customized subject and customize the entire message! You can even disable those tiresome Admin notifications for new registrations. 

== Installation ==

1. Upload the `register-plus` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Set the options in the Settings Panel

== LOCALIZATION ==
* Place your language file in the plugin folder directory and name it "regplus-{language}.mo" replacing {language} with your language value from wp-config.php 
				
== CHANGELOG ==

**v3.5.1** - July 29, 2008

	*Added Logo link to login page

**v3.5** - July 29, 2008
	
	*Changed Logo to link to site home page instead of wordpress.org and set the Logo title to "blogname - blogdescription"
	*Added Date Field ability for User Defined Fields - calendar pop-up on click with customization abilities

**v3.4.1** - July 28, 2008
	
	*Fixed admin verification error
	
**v3.4** - July 25, 2008

* Fixed verification email sending errors
* Fixed Custom Fields Extra Options duplications
* Added Custom CSS option for login and register pages
	
**v3.3** - July 23, 2006

* Updated conflict warning error to only appear on the RegPlus options page only.

**v3.2** - July 22, 2008

* Fixed Custom Field Checkbox saving issue
* Additional field types available for Custom Fields.
* Password Meter is now optional and text is editable within options page

**v3.1** - July 8, 2008

* Added Logo Removal Option
* Updated Email Validation text after registering
* Added User Sub-Panel for resending validation emails and automatic admin validation
* Added User Moderation Ability - new registrations must be approved by admin before becoming active.
* Fixed bad version control code
	
**v3.0.2** - June 23, 2008

* Updated Email notifications to use a filter to replace the From Name and Email address
	
**v3.0.1** - June 19, 2008

* Added more localization files
* Added doccumentation for auto-complete queries
* Fixed Admin notification email to now actually really go to the administrator

**v3.0** - June 18, 2008

* Added localization to password strength text
* Added stripslashes to missing areas
* Added Login Redirect option for registration email url
* Added Ability to populate registration fields using URL GET statements
* Added Simple CAPTCHA Session check and warning if not enabled
* Added ability to email all user data in notification emails

**v2.9** - June 10, 2008

* Fixed foreach error for custom invite codes
* Custom logos can now be any size
* Login fields are now hidden after registration if email verification is enabled.

**v2.8** - June 9, 2008

* Fixed Fatal Error on Options Page

**v2.7** - June 8, 2008

* Added full customization option to User Registration Email and Admin Email.
* Added ability to disable Admin notification email.
* Added style feature for required fields
* Added Custom Logo upload for replacing WP Logo on register & login pages

**v2.6** - May 15, 2008

* Fixed error on ranpass function.

**v2.5** - May 14, 2008

* Fixed registration password email to work when user set password is disabled

**v2.4** - May 13, 2008

* Fixed localization issue
* Added License Agreement & Privacy Policy plus user defined titles and agree text for these and the Disclaimer
* Fixed Javascript error in IE

**v2.3** - May 12, 2008

* Added reCAPTCHA support
* Fixed PHP short-code issue
* Added option to not require Invite Code but still show it on registration page
* Added ability to customize the registration email's From address, Subject and add your own message to the email body.

**v2.2** - April 27, 2008

* Fixed About Us Slashes from showing with apostrophes
* Modified the Captcha code to hopefully fix some compatibility issues

**v2.1** - April 26, 2008

* Fixed Admin Registation Password issue
* Added Dashboard Widget for showing invitation code tracking
* Added Email Verification for ensuring legitimate addresses are registered.  
* Unvalidated registrations are unable to login and are deleted after a set grace period
	
**v2.0** - April 20, 2008

* Added Profile Fields
* Added Multiple Invitation Codes
* Added Custom User Defined Fields with Profile integration
* Added ability to ignore duplicate email registrations

**v1.2** - April 13, 2008

* Altered Options saving and retrievals for less database interactions
* Added Disclaimer Feature
* Allowed register fields to retain values on submission if there is an error.

**v1.1** April 10 2008 

* Fixed Invitation Code from displaying when disabled.
* Added Captcha Feature


== Screenshots ==

1. Registration Page
2. Register Plus Settings
3. Invitation Tracking Dashboard Widget
4. Unverified User Management