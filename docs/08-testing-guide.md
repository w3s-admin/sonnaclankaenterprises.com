# Testing Guide: How to Test Every Admin Feature

This is a step-by-step checklist for testing the admin panel yourself, feature by feature, using safe made-up test data. Follow it top to bottom the first time; after that, use it as a checklist whenever something changes and you want to confirm nothing broke.

**Rule of thumb:** everything you add here is real data that will appear on the live public website immediately. Use obviously fake test data (like the examples below, all marked "TEST") so you can find and delete it afterwards without mixing it up with real stock, real reviews, or real staff.

---

## Before You Start

- **Admin panel URL:** `sonnaclankaenterprises.com/systemadmin/` (or `localhost:8000/systemadmin/` if testing on a local copy)
- **Login:** use your own staff username/password. If you don't have one yet, see [Staff Accounts](05-staff-accounts.md).
- Test in a normal desktop browser window. If you also want to check how it looks on a phone/tablet, resize your browser window narrower, or use your phone directly.
- Keep this checklist open in one tab and the admin panel in another.

---

## Test 1 — Login and Logout

1. Go to the admin URL. You should see a login screen with the company logo on the left and a sign-in form on the right.
2. Enter your username and password, click **Login**.
   - ✅ Success looks like: you land on the **Dashboard**.
   - ❌ If you see an error message, double check the username/password (they're case-sensitive).
3. Click your name (top-right corner) → **Logout**.
   - ✅ Success looks like: you're returned to the login screen and can't get back to any admin page by hitting "back" in the browser.

---

## Test 2 — Dashboard

After logging in, you should land on **Dashboard**. Check that:

- Four number cards show up top: **Vehicles In Stock**, **Vehicles Sold**, **Active Reviews**, **Staff Accounts** — each with a number (not blank, not an error).
- A **Recently Added Vehicles** table shows your most recent stock.
- A **Quick Actions** box on the right has buttons: **+ Add Vehicle**, **+ Add Review**, **+ Add Staff User**, **View Vehicle Manager**. Click each one and confirm it takes you to the right page.

---

## Test 3 — Add a Car

Go to **Vehicles → Add Vehicle**. Fill in the form with this test data:

| Field | Test value |
|---|---|
| Stock | Japan |
| Type | Car (any car sub-type, e.g. Sedan) |
| Make | Toyota |
| Model | Corolla (type it if not in the list) |
| Body Type | Sedan |
| Chasi Number | TEST-CHASI-001 |
| Engine Capacity | 1500 |
| Transmission | Auto |
| Fuel Type | Petrol |
| Colour | White |
| Year & Month | 2015-06 |
| Mileage | 50000 |
| Price | 3,000,000 |
| Registration Number | TEST-1234 |

Leave the feature checkboxes (AC, PS, PW, sunroof, etc.) as you like — they're optional extras. Upload any test image for the photo. Click **Save**.

- ✅ Success looks like: you're taken back to a save-confirmation, and the car now appears in **Vehicle Manager** and in the **Vehicles In Stock** count on the Dashboard.
- Also check the **public website** (in a separate tab): search or browse for "Toyota Corolla" and confirm your test car shows up with the right price/photo.

## Test 4 — Add a Motor Bicycle

Repeat the same **Add Vehicle** form, but this time:

| Field | Test value |
|---|---|
| Type | **Motor Bicycle** |
| Make | Honda *(should switch to a motorcycle-only make list once you pick Motor Bicycle)* |
| Body Type | Scooter *(should also switch to motorcycle-only options)* |
| Chasi Number | TEST-BIKE-001 |
| Engine Capacity | 125 |
| Colour | Black |
| Price | 400,000 |

- ✅ Success looks like: as soon as you change **Type** to "Motor Bicycle," the **Make** and **Body Type** dropdowns refresh to show motorcycle brands (Honda, Yamaha, Suzuki, Bajaj, TVS, Hero, Kawasaki, KTM) instead of car brands. This confirms the car/motorcycle split is working correctly.

---

## Test 5 — Vehicle Manager (search, edit, mark sold, delete)

Go to **Vehicles → Vehicle Manager**.

1. **Filter test:** use the filter panel at the top — set Make to "Toyota" and click **Search**. Only Toyota vehicles should show. Click **Reset** to clear it.
2. **Table search test:** type "TEST" into the table's own **Search** box. Both test vehicles you just added should appear (since their chasis start with TEST-).
3. **Edit test:** click **View & Edit** on your test Toyota. Change the price to 3,100,000 and save. Confirm the new price shows in the list.
4. **Mark as sold test:** find the "sold/in-stock" toggle button on your test car's row and mark it sold. Confirm the badge changes to "Sold" and the Dashboard's "Vehicles Sold" count goes up by one.
5. **Delete test:** delete both TEST vehicles once you're done (so they don't clutter the real stock list or show to real customers).

---

## Test 6 — Unsold List

Go to **Vehicles → Unsold List**. This should open as a normal page (not a popup) showing a printable table of everything still in stock. Try the **Print** button — it should open a print preview.

---

## Test 7 — Vehicle Attribute Managers

These seven pages control the dropdown options used on the Add Vehicle form: **Make, Model, Colour, Body Type, Transmission, Fuel Type, Engine Capacity** (all under **Vehicle Attributes** in the sidebar).

Test one of them fully — **Colour Manager** is the simplest:

1. Go to **Vehicle Attributes → Colour**.
2. In "Add New Colour," type `TEST Colour` and click **Add**. It should appear in the list on the right immediately.
3. Click **Edit** next to it, rename it to `TEST Colour Renamed`, save — confirm the list updates.
4. Click **Delete** — confirm it disappears from the list.
5. Go back to **Add Vehicle** and open the Colour dropdown — confirm your test colour is *not* there anymore (since you deleted it).

Repeat the same add/edit/delete pattern briefly on **Make** and **Body Type** — these two have an extra **Vehicle Group** dropdown (Car / Motor Bicycle). Test data:

| Field | Test value |
|---|---|
| Make name | TEST Make |
| Vehicle Group | Motor Bicycle |

Confirm that after adding it, it shows up in the Make dropdown **only** when "Motor Bicycle" is selected as the vehicle Type on Add Vehicle — not when "Car" is selected. Delete it afterwards.

For **Model**, test data:

| Field | Test value |
|---|---|
| Make | Toyota |
| Model name | TEST Model |

Confirm it only shows up in the Model dropdown when Toyota is the selected Make.

---

## Test 8 — Reviews

**Add Review** (sidebar → Reviews → Add Review). Test data:

| Field | Test value |
|---|---|
| Name | Jane Test |
| Title | Excellent service |
| Country | Sri Lanka |
| Comment | This is a TEST review — please delete after testing. |
| Image | any test photo (optional) |

Save, then:

- Check **Review Manager** — your test review should appear in the list.
- Check the **public website's** testimonials/reviews section — it should show up there too.
- Delete it from Review Manager once confirmed, and re-check the public site to confirm it's gone.

---

## Test 9 — Staff Accounts (Users)

⚠️ Be careful here — this creates a real login. Use a throwaway password and delete the account when done.

**Add User** (sidebar → Staff → Add User). Test data:

| Field | Test value |
|---|---|
| First Name | Test |
| Last Name | Account |
| Contacts | 0770000000 |
| Email | test.account@example.com |
| User Name | testaccount |
| Password | Temp12345! |
| Super Admin | OFF |
| Permission toggles | turn ON "User C.U.R.D" and "Purchase, Vehicle Manager" only |

Save, then:

1. Go to **User Manager** — confirm "Test Account" appears in the list.
2. Log out, and log back in as `testaccount` / `Temp12345!` to confirm the new login works.
3. While logged in as the test account, confirm you can do the things you gave permission for (Vehicle Manager) — and that anything you *didn't* give permission for is hidden or blocked.
4. Log back in as your real admin account, go to **User Manager**, and delete the test account.

---

## What "Everything Passed" Looks Like

- No error messages (red text, "Warning," or "Fatal error") appeared on any page during testing.
- Every test record you created (vehicle, colour, make, model, review, user) showed up immediately where expected, and disappeared immediately after you deleted it.
- The Motor Bicycle Type correctly swapped the Make/Body Type dropdowns to motorcycle-only options.
- Public website changes (new vehicle, new review) matched what you entered in the admin panel, and disappeared after deletion.
- You were able to log in as the throwaway test staff account and its permissions behaved as configured.

If any step doesn't match what's described, that's a bug worth reporting — note which step, what you expected, and what actually happened.

---

## Cleanup Checklist

Before you finish testing, make sure you deleted:

- [ ] TEST Toyota Corolla vehicle
- [ ] TEST Honda motorcycle
- [ ] TEST Colour / TEST Colour Renamed
- [ ] TEST Make (motor bicycle)
- [ ] TEST Model (Toyota)
- [ ] Jane Test review
- [ ] testaccount staff user
