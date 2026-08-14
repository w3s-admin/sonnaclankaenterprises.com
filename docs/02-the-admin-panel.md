# The Admin Panel — Getting Started

The admin panel is your private back office for running the website. This is where you and your staff do all the actual work — nothing changes on the public website unless someone does it here.

## How to Log In

1. Go to `sonnaclankaenterprises.com/systemadmin/` (the admin panel has its own separate web address, distinct from the main site).
2. Enter your username and password.
3. Once logged in, you'll land on the **Home Page** (the dashboard).

Currently there's one active login:
- **Username:** `test`
- **Password:** `11111111`

(This was set up during development so the system could be tested. You'll want to think about setting up your own real staff logins with proper passwords before this goes live for actual use — see [Managing Staff Accounts](05-staff-accounts.md).)

## The Layout

Every admin page has the same basic structure:

- **Top bar** — your business name/logo, and a logout button.
- **Left sidebar menu** — this is your main navigation. It's organized into three groups:
  - **User** — managing staff accounts who can log into this admin panel
  - **Vehicle** — managing your car inventory
  - **Review** — managing customer testimonials
- **Main content area** — whatever page you've clicked into, where the actual work happens.

## The Home Page (Dashboard)

Right now, the dashboard you land on after logging in is just a **welcome screen** — it doesn't currently show any summary numbers, charts, or "at a glance" widgets (like "5 vehicles added this week" or "3 new reviews"). It's essentially a blank landing page that confirms you're logged in and gives you the sidebar to navigate from.

*(If you'd find it useful to have a real dashboard — e.g. showing total vehicles in stock, recent sales, pending reviews — that's something that could be built. It doesn't exist yet.)*

## What You Can Actually Do, In Short

| Sidebar Section | What It Lets You Do |
|---|---|
| **User** | Create and manage staff logins for the admin panel |
| **Vehicle** | Add new cars to your stock, edit existing ones, mark cars as sold, view an unsold-inventory report |
| **Review** | Manually add customer testimonials, manage/edit existing ones |

There's also a **Newsletter/Email** feature built into the system, but it currently isn't linked anywhere in this sidebar menu — see [Newsletter & Email Tools](06-newsletter-emails.md) for details on that.

## Logging Out

Use the logout option in the top bar when you're done. This is especially important on a shared or public computer, since anyone with access to your logged-in browser session could make changes to your live website.

## Continue To:

- **[Managing Vehicles](03-managing-vehicles.md)** — the task you'll use most often
- **[Managing Customer Reviews](04-managing-reviews.md)**
- **[Managing Staff Accounts](05-staff-accounts.md)**
