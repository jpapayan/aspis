=== WP Survey And Quiz Tool ===
Contributors: Fubra
Tags: Quiz,test,exam,survey,results,email,quizzies,charts,google charts
Tested up to: 3.1
Stable tag: 1.2.1
Requires At Least: 2.9.2

A plugin to allow users to generate quizes, exams, tests and surveys for their wordpress site.

== Description ==

This plugin is designed to allow wordpress blog owners to create their own quizzes and surveys. Shows survey results using google charts.

Editable options for quizes are

* Take users contact details
* Completion notification (Instant, Batched - hourly or daily or not at all)
* Name
* Quiz sections

Editable options for quiz sections are

* Type -  Multiple choice or Text input.
* Difficulty - Easy, medium, hard or mixed which is even number of each difficulty unless the number is odd then the remainder from dividing by 3 is added to one difficulty randomly.
* Number of Questions
* Name

Editable options for surveys

* Name
* Take users contact details

Editable options for survey sections are

* Type - Multiple choice or scalable 1-10 
* Number of questions 
* Name

== Installation ==

1. Upload `wp-survey-and-quiz-tool` folder to `/wp-content/plugins/` directory
2. Go to Plugins and activate `WP Survey And Quiz Tool` 
3. Go to `WP Survey And Quiz Tool` then `Quiz/Surveys`
4. Click `Add New Quiz`
5. Fill out details.
6. Go back to Quiz/Surveys click edit sections
7. Fill out details.
8. Go back to Quiz/Surveys click edit questions
9. Click add questions and proceed.
10. Create new page and insert shortcode [wpsqt_quiz name=""] with name having the quiz name of the quiz you wish to have on the page 
10. OR Create new page and insert shortcode [wpsqt_survey name=""] with name having the survey name of the survey you wish to have on the page 
  
== Screenshots ==

1. Picture of contact details form.
2. Main Plugin Page
3. Question List
4. Create question form
5. Results list
6. Survey results

== ChangeLog == 

= 1.2.1 = 
* Added ability to export just people's details to csv
* Added mysql upgrade function

= 1.2 = 
* Removed redunant type from quiz creation and configution form.
* Fixed SQL error on surveys results table.
* Fixed notice and warnings appear when sections are missing results.
* Fixed mixed questions not always showing correct number of questions.
* Fixed user info aways being anonymous when using WordPress user info.
* Fixed warning of undeclared varaible in options page.
* Fixed wrong filepath for survey create file
* Fixed typo in survey list `configure quiz` changed to `configure survey`
* Fixed survey edit and creation options not being in form
* Added custom forms
* Added order by option on to quiz and survey sections
* Added ability to view results for single quizes.
* Added email link on result link name.
* Added html enabled question answers
* Added email notifications on percentage right
* Added export to csv ability

= 1.1.4 = 
* Increased customization ability for single quizzes and surveys.
* Added print.css to admin to allow for easy print off of results.

= 1.1.3 = 
* Fixed table creation error for quiz table
* Fixed options page not showing up.
* Fixed last quiz section not appering.

= 1.1.2 =
* All files actually uploaded this time

= 1.1.1 =
* Fixed missing require_once in quizzes
* Added ability to have custom templates.

= 1.1 = 
* Seperated Surveys and Quizes into two completely seperate sections.
* Added WPSQT_VERSION constant
* Added wordpress install information to contact form.
* Added Google Charts display for survey results.
* Added shortcode for surveys wpsqt_survey
* Added additional text ability to multiple choice questions.
* Fixed admin javascript linking issues.
* Fixed display resuts aways returning 0 corect
* Fixed questions showing up in sections the weren't assigned to.
* Fixed questions being delinked from sections on updating sections.
* Changed sortcode for quizzies to wpsqt_page to wpsqt_quiz

= 1.0.3 =
* Fixed faulty validation in questions creation.
* Fixed quiz list pages from being a fixed 20 items per page to those set in the plugin options page.
* Fixed quiz showing up when status is disabled.

= 1.0.2 = 
* Workaround to deal with register_action error

= 1.0.1 =
* Fixed error in display non mixed sections

== Upgrade Notice ==

= 1.2 = 
Bug fixes and new features!!!

= 1.1.2 = 
All files actually added this time!

= 1.1 =

Bugfixes, better survey ability and quiz tweaks.

= 1.0.3 =
Yet another bug fix release!

= 1.0.2 = 
Another bug fix release!

= 1.0.1 =
Bug fix release

== Frequently Asked Questions ==

= If I deactivate will all my results be lost? =

No, to stop accidental deletion of data we don't delete data on the plugins deactivation.

= Is there a maximum amount of questions a quiz can have? =
 
Not within the plugin it's self thou your hosting provider may set mysql limits which may limit the plugin.

= Does this plugin require any specific php modules? =

No it should work along as wordpress it able to work.

= Is their a limit on the number of quizes I can have? = 

Not within the plugin it's self thou your hosting provider may set mysql limits which may limit the plugin.

= Is this plugin compatible with Multisite? = 

Yes it has been tested and shown to be functional on a multisite install.

= A quiz section doesn't always show the correct number of questions whys this? =

You will have set the difficulty to mixed. This is only to be used when there is an even number of questions for each difficulty and is advised to only be used when there are more questions than the question number.

= Is it possible to have html for the questions? = 

HTML is enabled for the `additional` field but not the actual question question.