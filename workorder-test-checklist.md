# Workorder Test Checklist

Use this checklist after changes to the workorder module.

## Mail Mode

- Confirm [workorder_mail_config.php](c:\xampp\htdocs\medicsflow\workorder_mail_config.php) is set to the mode you want:
- Live mode:
  - `enabled => true`
  - `force_to_test_inbox => false`
- Test inbox mode:
  - `enabled => true`
  - `force_to_test_inbox => true`
  - `test_email` filled
- Mail off mode:
  - `enabled => false`

## Submit Flow

- Submit a workorder as a normal user.
- Confirm the request is saved in `workorder_form`.
- Confirm HOD receives the first email.
- Confirm an action row is created in `workorder_action_log`.

## HOD Flow

- Approve a request as HOD.
- Confirm the requester gets the approval email.
- Confirm the correct department gets routed:
  - Admin request -> admin department mail
  - Engineering request -> engineering department mail
- Reject a request as HOD.
- Confirm the requester gets rejection email with reason.

## Direct HOD Request

- Submit a request using a user account that should bypass HOD approval.
- Confirm the request appears in the correct downstream queue directly.

## Estimate Cost

- Open admin estimate-cost page for an admin request.
- Submit estimate below `10000`.
- Confirm it stays in the approval path correctly.
- Submit estimate above `10000`.
- Confirm finance routing is triggered correctly.
- Repeat the same checks for engineering estimate-cost.

## Approval Flow

- Approve and reject from:
  - Admin
  - Engineering
  - Finance
  - CEO (if applicable)
- Confirm requester receives the correct mail each time.
- Confirm action log rows are created.

## Closeout Flow

- Approve a request into work-in-progress state.
- Open the correct closeout page.
- Add closeout remarks.
- Confirm:
  - `task_status` becomes completed
  - `final_status` becomes completed
  - `closeout` and `closeout_date` are saved

## Logs

- Confirm action history exists in `workorder_action_log`.
- Confirm mail attempts are visible in `workorder_mail_log`.
- If email is disabled, confirm mail log stores `skipped`.
- If test inbox mode is enabled, confirm all emails go only to the test inbox.

## Detail Pages

- Open:
  - user details
  - admin details
  - all details
  - engineering all details
- Confirm values show correctly.
- Confirm reject reasons display the correct stage-specific note.

## Final Sanity

- Confirm no page shows PHP fatal error.
- Confirm sidebar navigation still works.
- Confirm workflow home links still open the correct pages.
