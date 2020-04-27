=== Triangle - Email Template Builder ===
Contributors: agung2001
Tags: email template, html mail, email design, mail, email templates, email editor, email builder, email contact
Requires at least: 5.0
Tested up to: 5.4
Requires PHP: 7.1
Stable tag: 1.0.3
License: GPL-3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

Email template editor and builder that can be used to send a beautiful professional design email template to your customers.

== Description ==
Triangle is an email template editor and builder that can be used to send a beautiful professional design email template to your customers.
You can set up your custom email template design by pasting your HTML and CSS into the editor.
The plugin will then automatically combine your HTML and CSS script into a standardized email template that will be sent to your customers.

You can use the plugin for cases like, sending custom invoice, getting in touch with your customers, sending a notification about payments, etc.
You can also modify the pre-built templates to match your needs.

= Features = 

* **Built in CSSInline:**
Email clients are unpredictable. Even today many clients strip styles that are not inlined, so it is important to inline your CSS before sending.
The plugin using custom libraries to inline your CSS script with your HTML. Don't risk your transactional emails or marketing campaigns falling apart.
* **Support SMTP Option**
We have provide custom SMTP email route options under the setting menu, so you can easily integrate your SMTP server with the plugin.
It also supports 3rd party route plugin like WP Mail SMTP, etc.
* **Beautiful User Interface (UI):**
We have set up a beautiful user interface and functionality to our custom editor, to make you create an email template as easy as never before.
* **Contact Customers**
We have provide extra custom link action under users.php page so then you can easily contact your customers from the admin users page

= 3rd Party Plugins =

Unsupported plugins
* WP Html Mail
* ...

Supported plugins
* WP Mail SMTP
* ...

= Credits =

* Thanks to Automattic for the css inline library [Juice on Github](https://github.com/Automattic/juice)
* Thanks to ColorlibHQ for the great responsive email layout [Email-Templates on Github](https://github.com/ColorlibHQ/email-templates)
* Thanks to Daniel Eden for his beautiful animation library [Denaden on Github](https://github.com/daneden/animate.css)
* Thanks to Select2 for the best jquery select boxes replacement [Select2 on Github](https://github.com/select2/select2)
* Thanks to Font Awesome for the best crafted icons library [Fontawesome](https://fontawesome.com/)
* Thanks to Ace Js for the high performance code editor [Ace Js](https://ace.c9.io/)

The plugin is still in an early stage of development so we are expecting your feedback and rating so then we can improve the plugins even more.
We are very excited about the plugin and hope you do as well. There are lots of features coming so stay tuned and also thank you for your very supports.

== Installation ==
* You can install the plugin from the Wordpress Plugin Repositories or
* Download the plugin and extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation


== Changelog ==

= 1.0.3 =
* finish setting up automattic/juice for css inliner
* add custom sections animations with animate.css

== Upgrade Notice ==

== Frequently Asked Questions ==

= The images is not showing, in a customer email? =

Before you send the email to your customers, please make sure that your email template is already using absolute path.
For example :
`
<img src="images/picture1.jpg">
<img src="/images/picture1.jpg">
`
Cant be used, you need to change that into your images absolute path like :
`
<img src="https://mydomain.com/wp-content/uploads/2020/04/picture1.jpg">
`

= My email template is not updating? =

After you copy and paste your html code into the editor, please make a little bit of changes like giving a spaces,
so then the javascript library will be invoked and render your html script.