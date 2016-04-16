# WordPress Editor Lock by WisdmLabs #
**Donate link:** https://www.paypal.com/in/cgi-bin/webscr?cmd=_flow&SESSION=6MTSuYNN1k2J65hc2q4Jf9Zl5aDO_JYwBOIx29vIlpz-LIuy0-93C_roLb0&dispatch=5885d80a13c0db1f8e263663d3faee8d8494db9703d295b4a2116480ee01a05c  
**Tags:** theme, plugin, editor, lock , editor lock, editor locking, admin, wisdmlabs, Editor Lock by WisdmLabs, theme editor, plugin editor, wordpress lock, wordpress, lab  
**Requires at least:** 3.3.1  
**Tested up to:**  3.8.1  
**Stable tag:** 1.5  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

This is a plugin which allows WordPress administrator, selectively restrict other administrators from accessing the WordPress theme and plugin editors. 

## Description ##

While working with developers or clients, there are times when you wish you had a simple way of locking the theme and/or plugin editors, so as to restrict access and control unnecessary edits/damage/modification to the theme and live plugins.

__WordPress Editor Lock by WisdmLabs__, aims to achieve exactly this and in a seamless, non-intrusive manner. The plugin essentially allows an administrator user to selectively lock out the theme and plugin editors for a particular user, generally an administrator level user. This helps in scenarios such as -

a. Client requests for admin access, but is not well-versed with WordPress backend and can accidently modify something, he/she is not supposed to touch

b. The Service Provider has no prior experience working with the Client and does not want the client to have access to code before the entire project delivery is complete

c. Developers are required to commit every change to the versioning repository, but easy access to the theme editor is very tempting. They cannot exercise self regulation

In all these cases, the __WordPress Editor Lock__ plugin can successfully intervene and provide access restriction or process conformation or security, as the case maybe.

Moreover, the plugin maintains an activity log, which lets the primary administrator know about all unauthorized access attempts by restricted users.

## Installation ##

How to install '__WordPress Editor Lock by WisdmLabs__'

1. Download the 'https://github.com/wisdmlabs/editor-lock-by-wisdmlabs/archive/master.zip'file.
2. After downloading is finished, extract the master.zip. The extraction will create a folder 'editor-lock-by-wisdmlabs-master'
3. There is a folder called 'editor-lock-by-wisdmlabs' inside 'editor-lock-by-wisdmlabs-master'. Upload that 'editor-lock-by-wisdmlabs' folder into 'wp-content/plugins' directory of your WordPress website.
4. After uploading a folder go to 'Plugins' section in WordPress dashboard. Locate the plugin 'Wordpress Editor Lock' and click 'Activate' link below the plugin name. Once it is activated you would be able to see 'Editor Lock' Tab in the Menu page.


## Frequently Asked Questions ##

### How can I block a user from accessing plugin editor and theme editor ? ###

After installing the plugin, you would be able to see a menu 'Editor Lock' on the menu page (Usually, it can be located below 'Settings' Menu). Click on that menu. It would open a new page. Select a user you want to block from the drop down list and then press 'Submit'.
After clicking submit, it would ask for the confirmation. Respond positively to block the person. Once the person is blocked, you would be able to see his/her username in the blocklist (which is placed below that submit button)

### How can I remove a user from blocklist ? ###

To remove a user from blocklist, go to Editor Locks Setting page by clicking 'Editor Lock' Menu on dashboard. Click on the 'cross' next to the user name whom you want to remove from the blocklist. It would ask for the confirmation. Respond positively to remove the person from the blocklist

### What if a user try to access the editor file by typing the address of the editor file in the address bar of the browser? ###

A user who has been blocked will not be able to access the file in any case and if he/she tries to do so, then that activity will be logged in the __WordPress Editor Lock__'s database and such attempt can be seen on the __WordPress Editor Lock__'s Settings page under 'Recent Action'. This kind of action will be highlighted with the red box.

### How may I know who has locked whom ? There might be a case that some of my administrator user has blocked another without any information? ###

__WordPress Editor Lock__ keeps the log of who has locked whom, who has unlocked whom and who has tried to access blocked file. These logs can not be deleted by anyone except the main Administrator User (i.e. a user who created the first account on your WordPress website)

### What if I block myself mistakenly? ###

__WordPress Editor Lock__ does not allow a user to lock himself/herself. So please do not worry about it.

### The user who has been blocked might try remove the plugin itself to get an access to editor files. Can that happen ? ###

While designing the WordPress Editor Lock, it has been taken care of that if a person is blocked, then he would not be even able to see 'Deactivate' button on the plugin's page.


### Can I deactivate the plugin temporarily and get the same list of blocked people back again after activating the plugin? ###

Yes, if you may deactivate the plugin any time and activate it again. Deactivating the plugin would not delete your __WordPress Editor Lock__ settings i.e. it will save the list of the blocked people before deactivating and would retreive them back after activating the plugin, however, if you uninstall the plugin, then you would loose all the settings of __WordPress Editor Lock__. 

### How can I give my feedback about this plugin? ###

If you like this plugin and willing to show your love about it, then you may click the Donate button and donate as per your desire. If you have any suggestions or query , then please feel free to write us at info@wisdmlabs.com and you can like us on facebnook at https://www.facebook.com/wisdmlabs


## Changelog ##
### 1.5 ###
* Replaced hard coded wp_ prefix with dynamic prefix

### 1.4 ###
* Changed the look and feel of the settings page. 

### 1.3.3 ###
* Added a functionality. Now if blocked admin user creates a new admin user, then that new admin user will be automatically added to Blocked list

### 1.3.2 ###
* Added compatibility with WordPress 3.5

### 1.3.1 ###
* Fixed  bug which was showing a blank username in list of blocked users when blocked user is deleted

### 1.3 ###
* Made changes in layout. Assigned new look to admin page.

### 1.2 ###
* Fixed bugs found when plugin activated on Windows Server

### 1.1 ###
* Made few changes in layout

### 1.0 ###
* First version.


