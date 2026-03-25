# Workorder Documentation

## Summary

### Shared core files
- Before: workorder pages were handling login checks, CSRF concerns, database fetches, workflow validation, and mail setup separately in many places.
- After: common logic was centralized into `workorder_bootstrap.php`, `workorder_mail.php`, and one simple config file `workorder_mail_config.php`.

### Submit page
- Page: `workorder_form.php`
- Before: raw SQL insert, mail credentials inside the page, no CSRF validation, and duplicate old submit/mail code inside the file.
- After: prepared insert query, CSRF protection, audit log entry, shared mail helper, flash messages, and old duplicate block removed.

### Approval action pages
- Pages: `workorder_head_approve.php`, `workorder_head_reject.php`, `workorder_admin_approve.php`, `workorder_admin_reject.php`, `workorder_engineering_approve.php`, `workorder_engineering_reject.php`, `workorder_finance_approve.php`, `workorder_finance_reject.php`, `workorder_ceo_approve.php`, `workorder_ceo_reject.php`
- Before: requests were being changed through GET URLs and each page had repeated mail and workflow code.
- After: all key actions now use POST + CSRF, permission checks, current-stage validation, prepared updates, flash messages, and shared mail sending.

### Approval list pages
- Pages: `workorder_head_list.php`, `workorder_admin_list.php`, `workorder_engineering_list.php`, `workorder_finance_list.php`, `workorder_ceo_list.php`
- Before: list pages linked directly to old approve/reject URLs.
- After: list pages now submit protected forms and reject reasons are collected through the shared helper script.

### User and detail pages
- Pages: `workorder_userlist.php`, `workorder_userlist_details.php`, `workorder_head_details.php`, `workorder_finance_details.php`, `workorder_adminlist_details.php`, `workorder_engineeringlist_details.php`, `workorder_dhead_details.php`
- Before: login checks were inconsistent and some detail pages fetched records with direct SQL interpolation.
- After: login checks are standardized and request loading for the main workflow detail pages uses the shared helper.

### Mail configuration
- Before: there were two config files, one sample and one local file.
- After: simplified to one file only, `workorder_mail_config.php`, using your single Gmail account for all workorder emails.

## Detailed Page-wise Changes

### `workorder_bootstrap.php`
- Added shared login guard.
- Added HTML escaping helper.
- Added CSRF token generation and validation helpers.
- Added prepared-statement helper.
- Added request fetch helper for `workorder_form`.
- Added permission helpers for head, admin, engineering, finance, and CEO actions.
- Added workflow-stage validation helpers.
- Added flash message helpers.
- Added action-log table helper and action-log writer.
- Added shared JS helper for reject-reason forms.

### `workorder_mail.php`
- Removed repeated SMTP setup from workflow pages.
- Simplified mail loading to one config file only: `workorder_mail_config.php`.
- Kept one shared `workorder_create_mailer()` function for all workorder email sending.

### `workorder_mail_config.php`
- Added one simple SMTP config file.
- Configured it to use your single Gmail account for all workorder mail.

### `workorder_form.php`
- Added shared login protection.
- Added CSRF validation on submit.
- Replaced raw insert SQL with prepared insert SQL.
- Added action log entry when a request is submitted.
- Replaced inline SMTP setup with shared mail helper usage.
- Added flash messages for success, warning, and failure.
- Removed old dead duplicate submit/mail block to keep the page simpler.

### `workorder_head_approve.php`
- Added POST-only flow.
- Added CSRF validation.
- Added head-role permission validation.
- Added request-stage validation.
- Replaced update logic with prepared statement usage.
- Added action logging.
- Switched to shared mail sending.

### `workorder_head_reject.php`
- Added POST-only flow.
- Added CSRF validation.
- Added required reject reason handling.
- Added head-role permission validation.
- Added request-stage validation.
- Replaced update logic with prepared statement usage.
- Added action logging.
- Switched to shared mail sending.

### `workorder_admin_approve.php`
- Added POST-only flow.
- Added CSRF validation.
- Added admin permission validation.
- Added request-stage validation.
- Replaced update logic with prepared statement usage.
- Added action logging.
- Switched to shared mail sending.

### `workorder_admin_reject.php`
- Added POST-only flow.
- Added CSRF validation.
- Added required reject reason handling.
- Added admin permission validation.
- Added request-stage validation.
- Replaced update logic with prepared statement usage.
- Added action logging.
- Switched to shared mail sending.

### `workorder_engineering_approve.php`
- Added POST-only flow.
- Added CSRF validation.
- Added engineering permission validation.
- Added request-stage validation.
- Replaced update logic with prepared statement usage.
- Added action logging.
- Switched to shared mail sending.

### `workorder_engineering_reject.php`
- Added POST-only flow.
- Added CSRF validation.
- Added required reject reason handling.
- Added engineering permission validation.
- Added request-stage validation.
- Replaced update logic with prepared statement usage.
- Added action logging.
- Switched to shared mail sending.

### `workorder_finance_approve.php`
- Added POST-only flow.
- Added CSRF validation.
- Added finance permission validation.
- Added request-stage validation.
- Replaced update logic with prepared statement usage.
- Added action logging.
- Switched to shared mail sending.

### `workorder_finance_reject.php`
- Added POST-only flow.
- Added CSRF validation.
- Added required reject reason handling.
- Added finance permission validation.
- Added request-stage validation.
- Replaced update logic with prepared statement usage.
- Added action logging.
- Switched to shared mail sending.

### `workorder_ceo_approve.php`
- Added POST-only flow.
- Added CSRF validation.
- Added CEO permission validation.
- Added request-stage validation.
- Replaced update logic with prepared statement usage.
- Added action logging.
- Switched to shared mail sending.

### `workorder_ceo_reject.php`
- Added POST-only flow.
- Added CSRF validation.
- Added required reject reason handling.
- Added CEO permission validation.
- Added request-stage validation.
- Replaced update logic with prepared statement usage.
- Added action logging.
- Switched to shared mail sending.

### `workorder_head_list.php`
- Replaced approve/reject links with protected POST forms.
- Added CSRF hidden inputs.
- Added flash message area.
- Connected reject flow to shared JS submit helper.

### `workorder_admin_list.php`
- Replaced approve/reject links with protected POST forms.
- Added CSRF hidden inputs.
- Added flash message area.
- Removed old leftover redirect-style reject JS.

### `workorder_engineering_list.php`
- Replaced approve/reject links with protected POST forms.
- Added CSRF hidden inputs.
- Added flash message area.
- Removed old leftover redirect-style reject JS.

### `workorder_finance_list.php`
- Replaced approve/reject links with protected POST forms.
- Added CSRF hidden inputs.
- Added flash message area.
- Removed old leftover redirect-style reject JS.

### `workorder_ceo_list.php`
- Replaced old GET approve/reject links with protected POST forms.
- Added CSRF hidden inputs.
- Added flash message area.

### `workorder_userlist.php`
- Standardized login guard through shared bootstrap helper.

### `workorder_userlist_details.php`
- Standardized login guard through shared bootstrap helper.
- Replaced direct request fetch SQL with shared request loader.

### `workorder_head_details.php`
- Standardized login guard through shared bootstrap helper.
- Replaced direct request fetch SQL with shared request loader.

### `workorder_finance_details.php`
- Standardized login guard through shared bootstrap helper.
- Replaced direct request fetch SQL with shared request loader.

### `workorder_adminlist_details.php`
- Standardized login guard through shared bootstrap helper.
- Replaced direct request fetch SQL with shared request loader.

### `workorder_engineeringlist_details.php`
- Standardized login guard through shared bootstrap helper.
- Replaced direct request fetch SQL with shared request loader.

### `workorder_dhead_details.php`
- Standardized login guard through shared bootstrap helper.
- Replaced direct request fetch SQL with shared request loader.

## Why The Mail Config Was Simplified

- Before, I had created:
- `workorder_mail_config.local.php`
- `workorder_mail_config.example.php`
- That was to separate a real local config from a sample config.
- Since you want this project simpler and you only use one email account, that setup was removed.
- Now there is only one mail file:
- `workorder_mail_config.php`

## Current Mail Setup

- One account is used for all workorder emails.
- Host: `smtp.gmail.com`
- Port: `465`
- Security: `SMTPS`
- From email: `hamza.mediclabs@gmail.com`

## Notes

- All `workorder*.php` files were syntax-checked after the main workorder changes.
- The core workorder flow is now more consistent, safer, and easier to maintain.
- Some old legacy display pages can still be polished more later, but the main workflow is in much better professional shape now.
