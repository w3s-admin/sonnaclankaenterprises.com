# Managing Staff Accounts

This controls **who can log into your admin panel** — it has nothing to do with customers (customers never have accounts on this system at all). This is under the **User** section of the sidebar.

## Add User

Creates a new staff login. The form asks for:

- **First Name / Last Name**
- **Username** — what they'll type to log in
- **Password**
- **Email**
- **Email Password** — a field for storing an email account password if that staff member's own email is connected to something in the system
- **Contact Number**
- **Other** — a free-text notes field
- **Super Admin** — a yes/no toggle

## What "Super Admin" Means

This is the one important setting to understand:

- A **Super Admin** account has full, unrestricted access to everything in the admin panel.
- A **regular** (non-super-admin) account is meant to have *limited* access — the system has a permissions structure designed to let you restrict staff to only certain sections (e.g. someone who only handles reviews, without letting them touch vehicle pricing or other staff accounts).

**Note:** the permission-restriction screens exist in the system, but weren't a focus of testing — before relying on this to actually *lock* a staff member out of certain sections, it's worth double-checking that restricting access works exactly as expected for your use case. Right now, the safest assumption is: **treat every account as if it can see everything**, and only hand out logins to people you fully trust, until this is verified.

## User Manager

Lists all staff accounts. From here you can edit or remove a login.

## Practical Advice

- Change the test login (`test` / `11111111`) before this goes live, or create your own real account and stop using the test one.
- Don't share one login between multiple staff — if something goes wrong (a vehicle deleted by mistake, a price changed incorrectly), separate logins let you know who did what.
- Only give **Super Admin** to people who genuinely need full control (typically just you, or a trusted manager).
